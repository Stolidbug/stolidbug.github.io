<?php

declare(strict_types=1);

namespace App\Content\Blog\Shared\Infrastructure\Identity;

use App\Content\Blog\Shared\Domain\Identifier\AuthorId;
use App\Shared\Infrastructure\Generator\GeneratorInterface;

class AuthorIdGenerator
{
    public function __construct(
        private readonly GeneratorInterface $generator,
    ) {
    }

    public function nextIdentity(): AuthorId
    {
        return new AuthorId($this->generator::generate());
    }
}
