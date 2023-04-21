<?php

declare(strict_types=1);

namespace App\Content\WebPage\Shared\Infrastructure\Identity;

use App\Content\WebPage\Shared\Domain\Identifier\PageId;
use App\Shared\Infrastructure\Generator\GeneratorInterface;

class PageIdGenerator
{
    public function __construct(
        private readonly GeneratorInterface $generator,
    ) {
    }

    public function nextIdentity(): PageId
    {
        return new PageId($this->generator::generate());
    }
}
