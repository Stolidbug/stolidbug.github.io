<?php

declare(strict_types=1);
namespace App\UI\Backend\Blog\Controller\ReadCategory;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\CategoryRepository;
use App\Shared\Infrastructure\Responder\HtmlResponder;
use Symfony\Component\HttpFoundation\Response;

class Action
{
    public function __construct(
        private readonly HtmlResponder $htmlResponder,
        private readonly CategoryRepository $repository,
    ) {
    }

    public function __invoke(string $slug): Response
    {
        return ($this->htmlResponder)('backend/blog/category/read', [
            'category' => $this->repository->findOneBy(['slug' => $slug]),
        ]);
    }
}
