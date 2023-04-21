<?php

declare(strict_types=1);

namespace App\UI\Backend\Blog\EventSubscriber;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use League\Flysystem\FilesystemWriter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class DeleteArticleImageSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly FilesystemWriter $defaultStorage,
    ) {
    }

    public function onArticleImagePostDelete(GenericEvent $event): void
    {
        /** @var Article $article */
        $article = $event->getSubject();
        $oldImage = $article->getImage();

        if ($oldImage) {
            $this->defaultStorage->delete($oldImage);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'app.blog_article.post_delete' => 'onArticleImagePostDelete',
        ];
    }
}
