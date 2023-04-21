<?php

declare(strict_types=1);

namespace App\UI\API\Blog\Author\State\Processor\Add;

final class Payload
{
    public function __construct(
        private readonly string $name,
        private readonly string $slug,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
