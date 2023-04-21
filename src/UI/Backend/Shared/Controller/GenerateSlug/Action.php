<?php

declare(strict_types=1);

namespace App\UI\Backend\Shared\Controller\GenerateSlug;

use App\Shared\Infrastructure\Slugger\SluggerInterface;
use App\UI\Backend\Routes;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class Action
{
    public function __construct(
        private readonly SluggerInterface $slugger,
    ) {
    }

    #[Route(
        path: Routes::BACKEND_GENERATOR_SLUG['path'],
        name: Routes::BACKEND_GENERATOR_SLUG['name'],
        requirements: [
            'data' => '.+(?<!/)',
        ],
        defaults: ['data' => ''],
        format: 'json',
    )]
    public function __invoke(string $data): Response
    {
        $slug = strtolower($this->slugger::slugify($data));

        return new JsonResponse([
            'slug' => $slug,
        ]);
    }
}
