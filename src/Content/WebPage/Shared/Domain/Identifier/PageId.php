<?php

declare(strict_types=1);

namespace App\Content\WebPage\Shared\Domain\Identifier;

final class PageId
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
