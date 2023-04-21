<?php

declare(strict_types=1);

namespace App\UI\Backend\AdminUser\EventSubscriber;

use App\Content\Blog\Application\Processor\AuthorAnonymizationProcessor;
use App\Security\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\User\AdminUser;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class AdministratorDeletedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly AuthorAnonymizationProcessor $AuthorAnonymizationProcessor,
    ) {
    }

    public function onSyliusAdminUserPostDelete(GenericEvent $event): void
    {
        /** @var AdminUser $administrator */
        $administrator = $event->getSubject();
        $this->AuthorAnonymizationProcessor->process($administrator);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'sylius.admin_user.post_delete' => 'onSyliusAdminUserPostDelete',
        ];
    }
}
