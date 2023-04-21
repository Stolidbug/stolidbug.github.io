<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\UI\Backend\WebPage;

use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Page;
use App\Tests\Behat\Page\Backend\WebPage\CreatePage;
use App\Tests\Behat\Page\Backend\WebPage\IndexPage;
use App\Tests\Behat\Page\Backend\WebPage\UpdatePage;
use Behat\Behat\Context\Context;
use Faker\Factory;
use Faker\Generator;
use Webmozart\Assert\Assert;

final class ManagingPagesContext implements Context
{
    private readonly Generator $faker;

    public function __construct(
        private readonly IndexPage $indexPage,
        private readonly CreatePage $createPage,
        private readonly UpdatePage $updatePage,
    ) {
        $this->faker = Factory::create();
    }

    /**
     * @When I want to browse pages
     * @Given I am browsing pages
     */
    public function iWantToBrowsePages(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Given there must be no page in the list
     * @Given there should be :number page in the list
     */
    public function shouldHavePages(int $number = 0): void
    {
        Assert::eq($this->indexPage->countItems(), $number);
    }

    /**
     * @Given I want to create a new page
     */
    public function iWantToCreateANewPage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When /^I want to edit (this page)$/
     */
    public function iWantToEditThisPage(Page $page)
    {
        $this->updatePage->open(['id' => $page->getId()]);
    }

    /**
     * @When I change its name to :name
     */
    public function iChangeItsNameTo(string $name)
    {
        $this->updatePage->nameIt($name);
    }

    /**
     * @When there is a page :name
     */
    public function thereIsAPage(string $name): void
    {
        $this->createPage->nameIt($name);
        $this->createPage->specifyContent($this->faker->text(100), );
        $this->createPage->specifyAuthor($this->faker->name);
        $this->createPage->specifySlug($this->faker->slug);
        $this->createPage->specifyPublished();
    }

    /**
     * @When I add it
     */
    public function iAddIt()
    {
        $this->createPage->create();
    }

    /**
     * @When I save it
     *
     */
    public function iSaveIt()
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @When I delete page with name :name
     */
    public function iDeletePageWithName(string $name)
    {
        $this->indexPage->open();
        $this->indexPage->deleteResourceOnPage(['name' => $name]);
    }

    /**
     * @Then I should see the page :name in the list
     */
    public function iShouldSeeThePageInTheList(string $name): void
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then the page :name should appear in the list
     */
    public function thePageShouldAppearInTheList($name)
    {
        $this->indexPage->open();
        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then there should not have any :name page anymore
     */
    public function thereShouldNotBePageAnymore($name)
    {
        $this->indexPage->open();

        Assert::false($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }
}
