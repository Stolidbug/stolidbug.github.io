<?php

declare(strict_types=1);

namespace App\UI\Frontend\Controller\WebPage\LegalNotice;

use App\Shared\Infrastructure\Responder\HtmlResponder;
use App\UI\Frontend\Controller\Routes;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    public function __construct(
        private readonly HtmlResponder $htmlResponder,
    ) {
    }

    #[Route(
        path: Routes::FRONTEND_INFO['path'],
        name: Routes::FRONTEND_INFO['name'],
        methods: ['GET'],
    )]
    public function __invoke(): Response
    {
        return ($this->htmlResponder)('frontend/legal_notices', [
        ]);
    }
}
