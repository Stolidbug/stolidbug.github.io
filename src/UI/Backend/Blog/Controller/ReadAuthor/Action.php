<?php

declare(strict_types=1);
namespace App\UI\Backend\Blog\Controller\ReadAuthor;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\AuthorRepository;
use App\Shared\Infrastructure\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;

class Action
{
    public function __construct(
        private readonly HtmlResponder $htmlResponder,
        private readonly AuthorRepository $repository,
    ) {
    }

    public function __invoke(string $slug): Response
    {
        return ($this->htmlResponder)('backend/blog/author/read', [
            'author' => $this->repository->findOneBy(['slug' => $slug]),
        ]);
    }
}
