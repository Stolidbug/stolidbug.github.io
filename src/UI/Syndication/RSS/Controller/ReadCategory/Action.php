<?php

declare(strict_types=1);

namespace App\UI\Syndication\RSS\Controller\ReadCategory;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\CategoryRepository;
use App\UI\Syndication\RSS\Controller\Routes;
use App\UI\Syndication\RSS\Responder\RssResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    public function __construct(
        private readonly CategoryRepository $repository,
        private readonly RssResponder $xmlResponder,
    ) {
    }

    #[Route(
        path: Routes::RSS_READ_CATEGORY['path'],
        name: Routes::RSS_READ_CATEGORY['name'],
        requirements: [
            '_format' => 'xml',
        ],
        methods: ['GET'],
    )]
    public function __invoke(string $slug): Response
    {
        $category = $this->repository->findOneBy(['slug' => $slug]);

        return ($this->xmlResponder)('syndication/rss/category', [
            'category' => $category,
        ]);
    }
}
