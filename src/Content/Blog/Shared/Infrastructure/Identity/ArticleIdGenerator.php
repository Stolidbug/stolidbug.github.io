<?php

declare(strict_types=1);

namespace App\Content\Blog\Shared\Infrastructure\Identity;

use App\Content\Blog\Shared\Domain\Identifier\ArticleId;
use App\Shared\Infrastructure\Generator\GeneratorInterface;

class ArticleIdGenerator
{
    public function __construct(
        private readonly GeneratorInterface $generator,
    ) {
    }

    public function nextIdentity(): ArticleId
    {
        return new ArticleId($this->generator::generate());
    }
}
