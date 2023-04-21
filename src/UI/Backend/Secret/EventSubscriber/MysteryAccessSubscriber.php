<?php

declare(strict_types=1);

namespace App\UI\Backend\Secret\EventSubscriber;

use App\Secret\MysteryNumber\Application\Processor\MysteryAccessProcessor;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class MysteryAccessSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MysteryAccessProcessor $mysteryAccessProcessor,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $session = $request->getSession();

        if ($request->attributes->get('_route') === 'app_frontend_contact' && $request->isMethod('POST')) {
            $data = $request->request->all();

            /** @var array $contact */
            $contact = $data['contact'];

            $accessMysteryPage = $this->mysteryAccessProcessor->checkAccess($contact);

            if ($accessMysteryPage) {
                $session->set('mystery_access_granted', true);
            } else {
                $session->set('mystery_access_granted', false);
            }
        }
    }
}
