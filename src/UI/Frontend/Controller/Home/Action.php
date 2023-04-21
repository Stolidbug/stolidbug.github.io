<?php

declare(strict_types=1);

namespace App\UI\Frontend\Controller\Home;

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
        path: Routes::FRONTEND_INDEX['path'],
        name: Routes::FRONTEND_INDEX['name'],
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        if ($this->articleRepository->count([]) > 2) {
            return ($this->htmlResponder)('frontend/home', [
                'articles' => $this->articleRepository->findLastArticles(2),
                'allArticles' => true,
            ]);
        }
        return ($this->htmlResponder)('frontend/home', [
            'articles' => $this->articleRepository->findLastArticles(2),
        ]);
    }
}
