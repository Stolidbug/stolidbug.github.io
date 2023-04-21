<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Content\Blog\Shared\Infrastructure\Persistence\Fixture\Factory\AuthorFactory;
use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;

class AuthorContext implements Context
{
    public function __construct(
        private readonly SharedStorageInterface $sharedStorage,
    ) {
    }

    /**
     * @Given there is a name :name
     */
    public function thereIsAName(string $name): void
    {
        $author = AuthorFactory::new()
            ->withName($name)
            ->create()
        ;

        $this->sharedStorage->set('author', $author->object());
    }
}
