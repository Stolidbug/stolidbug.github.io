<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Content\WebPage\Shared\Infrastructure\Persistence\Fixture\Factory\PageFactory;
use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;

class PageContext implements Context
{
    public function __construct(
        private readonly SharedStorageInterface $sharedStorage,
    ) {
    }

    /**
     * @Given I already have a page :name
     */
    public function thereIsAPage(string $name): void
    {
        $page = PageFactory::new()
            ->withName($name)
            ->create()
        ;

        $this->sharedStorage->set('page', $page->object());
    }
}
