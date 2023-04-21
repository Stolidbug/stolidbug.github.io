<?php

declare(strict_types=1);

namespace App\UI\Frontend\Controller\Secret\ReadMisteryNumber;

use App\Secret\MysteryNumber\Application\Processor\MysteryNumberProcessor;
use App\Secret\MysteryNumber\Application\Provider\MysteryNumberProvider;
use App\Shared\Infrastructure\Responder\HtmlResponder;
use App\Shared\Infrastructure\Responder\RedirectResponder;
use App\UI\Frontend\Controller\Routes;
use App\UI\Frontend\Controller\Secret\Form\MysteryNumberType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class Action
{
    public function __construct(
        private readonly FormFactoryInterface   $form,
        private readonly HtmlResponder          $htmlResponder,
        private readonly UrlGeneratorInterface  $urlGenerator,
        private readonly RedirectResponder      $redirectResponder,
        private readonly MysteryNumberProcessor $processor,
        private readonly MysteryNumberProvider  $gameProvider,
    ) {
    }

    #[Route(
        path: Routes::FRONTEND_MYSTERY_NUMBER['path'],
        name: Routes::FRONTEND_MYSTERY_NUMBER['name'],
        methods: ['GET', 'POST'],
    )]
    public function __invoke(Request $request): Response
    {
        $session = $request->getSession();

        if (!$session->has('mystery_access_granted')) {
            return $this->redirectToRoute(Routes::FRONTEND_INDEX['name']);
        }

        if ($this->shouldRefresh($request)) {
            $this->gameProvider->resetGame($session);
            return $this->redirectToRoute(Routes::FRONTEND_MYSTERY_NUMBER['name']);
        }

        $this->gameProvider->initializeGame($session);

        $form = $this->form->create(MysteryNumberType::class);
        $form->handleRequest($request);

        $showRefreshButton = false;
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var array<string, int> $data */
            $data = $form->getData();

            if (!isset($data['guess'])) {
                $data['guess'] = 0;
            }

            $previousNumbers = $session->get('previous_numbers', []);
            assert(is_array($previousNumbers));

            $result = $this->processor->process(
                intval($session->get('mysteryNumber')),
                intval($data['guess']),
                intval($session->get('tries')),
                intval($session->get('difficulty')),
                $previousNumbers,
            );

            $session->set('mysteryNumber', $result['mystery_number']);
            $session->set('tries', $result['tries']);
            $session->set('difficulty', $result['difficulty']);
            $session->set('previous_numbers', $result['previous_numbers']);

            $message = $result['message'];

            if ($result['lost']) {
                $this->gameProvider->resetGame($session);
                $showRefreshButton = true;
            }
        } else {
            $message = '';
        }

        return ($this->htmlResponder)('frontend/secret/mystery_number_game', [
            'form' => $form->createView(),
            'message' => $message,
            'max_tries' => 10,
            'showRefreshButton' => $showRefreshButton,
            'difficulty' => $session->get('difficulty'),
        ]);
    }

    private function shouldRefresh(Request $request): bool
    {
        return $request->query->has('refresh');
    }

    private function redirectToRoute(string $routeName): Response
    {
        return ($this->redirectResponder)($this->urlGenerator->generate($routeName));
    }
}
