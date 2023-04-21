<?php

declare(strict_types=1);

namespace App\UI\Frontend\Controller\Contact;

use App\Shared\Infrastructure\Mailer\Email;
use App\Shared\Infrastructure\Mailer\SymfonyMailer;
use App\Shared\Infrastructure\Responder\HtmlResponder;
use App\Shared\Infrastructure\Responder\RedirectResponder;
use App\UI\Frontend\Controller\Contact\Form\ContactDTO;
use App\UI\Frontend\Controller\Contact\Form\ContactType;
use App\UI\Frontend\Controller\Routes;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Mime\Address;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

final class Action
{
    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly NotifierInterface $notifier,
        private readonly SymfonyMailer $mailer,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly RedirectResponder $redirectResponder,
        private readonly FormFactoryInterface $form,
        private readonly HtmlResponder $htmlResponder,
    ) {
    }

    #[Route(
        path: Routes::FRONTEND_CONTACT['path'],
        name: Routes::FRONTEND_CONTACT['name'],
        methods: ['GET', 'POST'],
    )]
    public function __invoke(Request $request): Response
    {
        $form = $this->form->create(ContactType::class);
        $form->handleRequest($request);

        if (true === $form->isSubmitted() && true === $form->isValid()) {

            /** @var ContactDTO $data */
            $data = $form->getData();

            if ($request->getSession()->get('mystery_access_granted', false)) {
                return ($this->redirectResponder)($this->urlGenerator->generate(Routes::FRONTEND_MYSTERY_NUMBER['name']));
            }

            if ($this->process($data)) {
                $this->addMessage($this->translator->trans('app.ui.send'));
                return ($this->redirectResponder)($this->urlGenerator->generate(Routes::FRONTEND_CONTACT['name']));
            } else {
                if ($request->getSession() instanceof Session) {
                    $request->getSession()->getFlashBag()->add('error', $this->translator->trans('app.ui.captcha_error'));
                }
            }
        }

        return ($this->htmlResponder)('frontend/contact', [
            'form' => $form->createView(),
        ]);
    }

    private function process(ContactDTO $data): bool
    {
        if ($this->validateCaptcha($data)) {
            Assert::isInstanceOf($data, ContactDTO::class);

            $email = (new Email(
                new Address($data->getEmail()),
                'Contact form',
                'frontend/emails/contact.txt.twig',
                'frontend/emails/contact.html.twig',
                $data->getData(),
            ));

            $this->mailer->send($email);

            return true;
        }

        return false;
    }


    private function addMessage(string $message): void
    {
        $this->notifier->send(new Notification($message, ['browser']));
    }

    private function validateCaptcha(ContactDTO $data): bool
    {
        return $data->getCaptchaUserAnswer() === $data->getCaptChaAnswer();
    }
}
