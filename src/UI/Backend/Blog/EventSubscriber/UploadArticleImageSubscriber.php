<?php

declare(strict_types=1);

namespace App\UI\Backend\Blog\EventSubscriber;

use App\Content\Blog\Application\Processor\UploadArticleImageProcessor;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class UploadArticleImageSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly RequestStack                $requestStack,
        private readonly UploadArticleImageProcessor $uploadImageArticleProcessor,
    ) {
    }

    public function onImageArticlePostCreate(GenericEvent $event): void
    {
        /** @var Article $article */
        $article = $event->getSubject();

        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            return;
        }

        $this->uploadImageArticleProcessor->process($article, $request);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'app.blog_article.pre_create' => 'onImageArticlePostCreate',
        ];
    }
}
