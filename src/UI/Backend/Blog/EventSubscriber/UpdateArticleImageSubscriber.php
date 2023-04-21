<?php

declare(strict_types=1);

namespace App\UI\Backend\Blog\EventSubscriber;

use App\Content\Blog\Application\Processor\UpdateArticleImageProcessor;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class UpdateArticleImageSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly RequestStack                $requestStack,
        private readonly UpdateArticleImageProcessor $updatedImageArticleProcessor,
    ) {
    }

    public function onArticleImagePostUpdate(GenericEvent $event): void
    {
        /** @var Article $article */
        $article = $event->getSubject();

        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            return;
        }

        $this->updatedImageArticleProcessor->process($article, $request);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'app.blog_article.pre_update' => 'onArticleImagePostUpdate',
        ];
    }
}
