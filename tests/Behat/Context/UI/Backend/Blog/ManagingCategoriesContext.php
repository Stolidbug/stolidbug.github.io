<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\UI\Backend\Blog;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Category;
use App\Tests\Behat\Page\Backend\Blog\Category\CreatePage;
use App\Tests\Behat\Page\Backend\Blog\Category\IndexPage;
use App\Tests\Behat\Page\Backend\Blog\Category\UpdatePage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingCategoriesContext implements Context
{
    public function __construct(
        private readonly CreatePage $createPage,
        private readonly IndexPage  $indexPage,
        private readonly UpdatePage $updatePage,
    ) {
    }

    /**
     * @When I want to browse categories
     * @Given I am browsing categories
     */
    public function iWantToBrowseCategories(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Given I want to create a new category
     */
    public function iWantToCreateANewCategory(): void
    {
        $this->createPage->open();
    }

    /**
     * @When /^I want to edit (this category)$/
     */
    public function iWantToEditThisCategory(Category $category)
    {
        $this->updatePage->open(['id' => $category->getId()]);
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
     * @When I delete category with name :name
     */
    public function iDeleteCategoryWithName(string $name)
    {
        $this->indexPage->deleteResourceOnPage(['name' => $name]);
    }

    /**
     * @Then there should be :amount category in the list
     */
    public function thereShouldBeCategoryInTheList(int $amount): void
    {
        Assert::eq($this->indexPage->countItems(), $amount);
    }

    /**
     * @Then I should see the category :name in the list
     */
    public function iShouldSeeTheCategoryInTheList(string $name): void
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then the category :name should appear in the list
     */
    public function thePageShouldAppearInTheList($name)
    {
        $this->indexPage->open();
        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then there should not be :name category anymore
     */
    public function thereShouldNotBeCategoryAnymore($name)
    {
        $this->indexPage->open();

        Assert::false($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }
}
