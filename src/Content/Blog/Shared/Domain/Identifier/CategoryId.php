<?php

declare(strict_types=1);

namespace App\Content\Blog\Shared\Domain\Identifier;

final class CategoryId
{
    public function __construct(
        private readonly string $value,
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
