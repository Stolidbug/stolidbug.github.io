<?php

declare(strict_types=1);

namespace App\Content\WebPage\Shared\Infrastructure\Persistence\Fixture\DataFixtures;

use App\Content\WebPage\Shared\Infrastructure\Persistence\Fixture\Story\DefaultWebPageStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class DefaultFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        DefaultWebPageStory::load();
    }

    public static function getGroups(): array
    {
        return ['default', 'webpage'];
    }
}
