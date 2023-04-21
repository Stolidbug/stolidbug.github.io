<?php

declare(strict_types=1);

namespace App\UI\API\WebPage\State\Processor\Add;

final class Payload
{
    public function __construct(
        private readonly string $name,
        private readonly string $content,
        private readonly string $author,
        private readonly bool $status,
        private readonly string $slug,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
