<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\UI\Backend\Blog;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Author;
use App\Tests\Behat\Page\Backend\Blog\Author\CreatePage;
use App\Tests\Behat\Page\Backend\Blog\Author\IndexPage;
use App\Tests\Behat\Page\Backend\Blog\Author\UpdatePage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingAuthorsContext implements Context
{
    public function __construct(
        private readonly CreatePage $createPage,
        private readonly IndexPage  $indexPage,
        private readonly UpdatePage $updatePage,
    ) {
    }

    /**
     * @When I want to browse authors
     * @Given I am browsing authors
     */
    public function iWantToBrowseAuthors(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Given I want to create a new author
     */
    public function iWantToCreateANewAuthor(): void
    {
        $this->createPage->open();
    }

    /**
     * @When /^I want to edit (this author)$/
     */
    public function iWantToEditThisAuthor(Author $author)
    {
        $this->updatePage->open(['id' => $author->getId()]);
    }

    /**
     * @When I change its name to :name
     */
    public function iChangeItsNameTo(string $name)
    {
        $this->updatePage->nameIt($name);
    }

    /**
     * @When I add it
     */
    public function iAddIt()
    {
        $this->createPage->create();
    }

    /**
     * @When I save my changes
     */
    public function iSaveMyChanges()
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @When I delete author with name :name
     */
    public function iDeleteAuthorWithName(string $name)
    {
        $this->indexPage->deleteResourceOnPage(['name' => $name]);
    }

    /**
     * @Then there should be :amount author in the list
     */
    public function thereShouldBeAuthorInTheList(int $amount): void
    {
        Assert::eq($this->indexPage->countItems(), $amount);
    }

    /**
     * @Then I should see the author :name in the list
     */
    public function iShouldSeeTheAuthorInTheList(string $name): void
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then the author :name should appear in the list
     */
    public function thePageShouldAppearInTheList($name)
    {
        $this->indexPage->open();
        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then there should not be :name author anymore
     */
    public function thereShouldNotBeAuthorAnymore($name)
    {
        $this->indexPage->open();

        Assert::false($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }
}
