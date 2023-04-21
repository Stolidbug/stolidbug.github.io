<?php

declare(strict_types=1);

namespace App\UI\Frontend\Controller\Blog\LastReadArticles;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\ArticleRepository;
use App\Shared\Infrastructure\Responder\HtmlResponder;
use App\UI\Frontend\Controller\Routes;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    public function __construct(
        private readonly HtmlResponder     $htmlResponder,
        private readonly ArticleRepository $articleRepository,
    ) {
    }

    #[Route(
        path: Routes::FRONTEND_BLOG_LAST_READ_ARTICLES['path'],
        name: Routes::FRONTEND_BLOG_LAST_READ_ARTICLES['name'],
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        return ($this->htmlResponder)('frontend/blog/last_read_article', [
            'articles' => $this->articleRepository->findAll(),
        ]);
    }
}
