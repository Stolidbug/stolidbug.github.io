<?php

declare(strict_types=1);

namespace App\UI\Backend\WebPage\Controller\ReadPage;

use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\PageRepository;
use App\Shared\Infrastructure\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;

class Action
{
    public function __construct(
        private readonly HtmlResponder $htmlResponder,
        private readonly PageRepository $repository,
    ) {
    }

    public function __invoke(string $id): Response
    {
        return ($this->htmlResponder)('backend/page/read', [
            'page' => $this->repository->find($id),
        ]);
    }
}
