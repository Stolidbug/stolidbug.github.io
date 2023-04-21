<?php

declare(strict_types=1);

namespace App\Content\WebPage\Shared\Infrastructure\Persistence\Fixture\Story;

use App\Content\WebPage\Shared\Infrastructure\Persistence\Fixture\Factory\PageFactory;
use Zenstruck\Foundry\Story;

class DefaultWebPageStory extends Story
{
    public function build(): void
    {
        PageFactory::createOne();
    }
}
