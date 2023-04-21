<?php

declare(strict_types=1);

namespace App\UI\Frontend\Controller\Blog\ReadArticle;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\ArticleRepository;
use App\Shared\Infrastructure\Responder\HtmlResponder;
use App\UI\Frontend\Controller\Routes;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    public function __construct(
        private readonly HtmlResponder $htmlResponder,
        private readonly ArticleRepository $repository,
    ) {
    }

    #[Route(
        path: Routes::FRONTEND_BLOG_SHOW_ARTICLE['path'],
        name: Routes::FRONTEND_BLOG_SHOW_ARTICLE['name'],
        methods: ['GET'],
    )]
    public function __invoke(string $slug): Response
    {
        return ($this->htmlResponder)('frontend/blog/read_article', [
            'article' => $this->repository->findOneBy(['slug' => $slug]),
        ]);
    }
}
