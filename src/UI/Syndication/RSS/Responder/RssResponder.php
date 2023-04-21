<?php

declare(strict_types=1);

namespace App\UI\Syndication\RSS\Responder;

use App\Shared\Infrastructure\Responder\XmlResponder;
use Symfony\Component\HttpFoundation\Response;

final class RssResponder
{
    public function __construct(
        private readonly XmlResponder $xmlResponder,
    ) {
    }

    /**
     * @param array<array-key, mixed> $parameters
     * @param array<array-key, mixed> $headers
     */
    public function __invoke(
        string $template,
        array $parameters = [],
        int $status = 200,
        array $headers = [],
    ): Response {
        $response = ($this->xmlResponder)($template, $parameters, $status, $headers);
        $response->headers->set('Content-Type', 'application/rss+xml');

        return $response;
    }
}
