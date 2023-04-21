<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Responder;

use App\Shared\Infrastructure\Templating\TemplatingInterface;
use Symfony\Component\HttpFoundation\Response;

final class XmlResponder
{
    public function __construct(
        private readonly TemplatingInterface $templating,
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
        $template = $this->templating->render(
            sprintf('%s.xml.twig', $template),
            $parameters,
        );

        $response = new Response($template, $status, $headers);
        $response->headers->set('Content-Type', 'application/xml');

        return $response;
    }
}
