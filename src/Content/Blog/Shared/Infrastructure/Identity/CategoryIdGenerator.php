<?php

declare(strict_types=1);

namespace App\Content\Blog\Shared\Infrastructure\Identity;

use App\Content\Blog\Shared\Domain\Identifier\CategoryId;
use App\Shared\Infrastructure\Generator\GeneratorInterface;

class CategoryIdGenerator
{
    public function __construct(
        private readonly GeneratorInterface $generator,
    ) {
    }

    public function nextIdentity(): CategoryId
    {
        return new CategoryId($this->generator::generate());
    }
}
