<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Responder;

use App\Shared\Infrastructure\Templating\TemplatingInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class HtmlResponder
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
        bool $stream = false,
    ): Response {
        if (true === $stream) {
            return new StreamedResponse(
                fn () => $this->templating->display(
                    \sprintf('%s.html.twig', $template),
                    $parameters,
                ),
                $status,
            );
        }

        return new Response($this->templating->render(
            \sprintf('%s.html.twig', $template),
            $parameters,
        ), $status, $headers);
    }
}
