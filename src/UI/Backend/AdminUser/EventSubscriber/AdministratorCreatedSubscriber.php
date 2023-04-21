<?php

declare(strict_types=1);

namespace App\UI\Backend\AdminUser\EventSubscriber;

use App\Content\Blog\Application\Processor\AuthorCreatedProcessor;
use App\Security\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\User\AdminUser;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class AdministratorCreatedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly AuthorCreatedProcessor $AuthorCreatedProcessor,
    ) {
    }

    public function onSyliusAdminUserPostCreate(GenericEvent $event): void
    {
        /** @var AdminUser $administrator */
        $administrator = $event->getSubject();
        $this->AuthorCreatedProcessor->process($administrator);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'sylius.admin_user.post_create' => 'onSyliusAdminUserPostCreate',
        ];
    }
}
