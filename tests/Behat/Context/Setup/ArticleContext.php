<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Content\Blog\Shared\Infrastructure\Persistence\Fixture\Factory\ArticleFactory;
use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;

class ArticleContext implements Context
{
    public function __construct(
        private readonly SharedStorageInterface $sharedStorage,
    ) {
    }

    /**
     * @Given there is a title :title
     */
    public function thereIsATitle(string $title): void
    {
        $article = ArticleFactory::new()
            ->withTitle($title)
            ->create()
        ;

        $this->sharedStorage->set('article', $article->object());
    }
}
