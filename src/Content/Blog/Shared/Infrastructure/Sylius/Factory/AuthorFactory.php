<?php

declare(strict_types=1);

namespace App\Content\Blog\Shared\Infrastructure\Sylius\Factory;

use App\Content\Blog\Shared\Infrastructure\Identity\AuthorIdGenerator;
use Sylius\Component\Resource\Factory\FactoryInterface;

class AuthorFactory implements FactoryInterface
{
    public function __construct(
        private readonly string $className,
        private readonly AuthorIdGenerator $generator,
    ) {
    }

    public function createNew()
    {
        return new $this->className(
            $this->generator->nextIdentity(),
        );
    }
}
