<?php

declare(strict_types=1);

namespace App\Content\WebPage\Shared\Infrastructure\Sylius\Factory;

use App\Content\WebPage\Shared\Infrastructure\Identity\PageIdGenerator;
use Sylius\Component\Resource\Factory\FactoryInterface;

class PageFactory implements FactoryInterface
{
    public function __construct(
        private readonly string $className,
        private readonly PageIdGenerator $generator,
    ) {
    }

    public function createNew()
    {
        return new $this->className(
            $this->generator->nextIdentity(),
        );
    }
}
