<?php

declare(strict_types=1);

namespace App\Content\Blog\Shared\Infrastructure\Persistence\Fixture\Story;

use App\Content\Blog\Shared\Infrastructure\Persistence\Fixture\Factory\ArticleFactory;
use App\Content\Blog\Shared\Infrastructure\Persistence\Fixture\Factory\AuthorFactory;
use App\Content\Blog\Shared\Infrastructure\Persistence\Fixture\Factory\CategoryFactory;
use Zenstruck\Foundry\Story;

class DefaultBlogStory extends Story
{
    public function build(): void
    {
        CategoryFactory::createMany(3);
        AuthorFactory::createMany(3);
        ArticleFactory::createSequence(
            function () {
                foreach (\range(1, 10) as $i) {
                    yield [
                        'categories' => CategoryFactory::randomSet($i % 3 + 1),
                        'authors' => AuthorFactory::randomSet($i % 3 + 1),
                    ];
                }
            },
        );
    }
}
