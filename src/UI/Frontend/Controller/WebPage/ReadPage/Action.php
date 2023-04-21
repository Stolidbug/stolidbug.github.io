<?php

declare(strict_types=1);

namespace App\UI\Frontend\Controller\WebPage\ReadPage;

use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\PageRepository;
use App\Shared\Infrastructure\Responder\HtmlResponder;
use App\UI\Frontend\Controller\Routes;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    public function __construct(
        private readonly HtmlResponder $htmlResponder,
        private readonly PageRepository $repository,
    ) {
    }

    #[Route(
        path: Routes::FRONTEND_WEBPAGE_PAGE_SHOW['path'],
        name: Routes::FRONTEND_WEBPAGE_PAGE_SHOW['name'],
        methods: ['GET'],
    )]
    public function __invoke(string $slug): Response
    {
        return ($this->htmlResponder)('frontend/webpage/read_page', [
            'page' => $this->repository->findOneBy(['slug' => $slug]),
        ]);
    }
}
