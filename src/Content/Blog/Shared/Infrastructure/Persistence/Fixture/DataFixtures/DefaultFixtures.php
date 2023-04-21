<?php

declare(strict_types=1);

namespace App\Content\Blog\Shared\Infrastructure\Persistence\Fixture\DataFixtures;

use App\Content\Blog\Shared\Infrastructure\Persistence\Fixture\Story\DefaultBlogStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class DefaultFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['default', 'blog'];
    }

    public function load(ObjectManager $manager): void
    {
        DefaultBlogStory::load();
    }
}
