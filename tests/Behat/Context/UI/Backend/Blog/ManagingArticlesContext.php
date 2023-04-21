<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\UI\Backend\Blog;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use App\Tests\Behat\Page\Backend\Blog\Article\CreatePage;
use App\Tests\Behat\Page\Backend\Blog\Article\IndexPage;
use App\Tests\Behat\Page\Backend\Blog\Article\UpdatePage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class ManagingArticlesContext implements Context
{
    public function __construct(
        private readonly CreatePage $createPage,
        private readonly IndexPage $indexPage,
        private readonly UpdatePage $updatePage,
    ) {
    }

    /**
     * @When I want to browse articles
     * @Given I am browsing articles
     */
    public function iWantToBrowseArticles(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Given I want to create a new article
     */
    public function iWantToCreateANewArticle(): void
    {
        $this->createPage->open();
    }

    /**
     * @When /^I want to edit (this article)$/
     */
    public function iWantToEditThisArticle(Article $article)
    {
        $this->updatePage->open(['id' => $article->getId()]);
    }

    /**
     * @When I change its title to :title
     */
    public function iChangeItsTilteTo(string $title)
    {
        $this->updatePage->titleIt($title);
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
     * @When I delete article with title :title
     */
    public function iDeleteArticleWithTitle(string $title)
    {
        $this->indexPage->deleteResourceOnPage(['title' => $title]);
    }

    /**
     * @Then there should be :amount article in the list
     */
    public function thereShouldBeArticleInTheList(int $amount): void
    {
        Assert::eq($this->indexPage->countItems(), $amount);
    }

    /**
     * @Then I should see the article :title in the list
     */
    public function iShouldSeeTheArticleInTheList(string $title): void
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['title' => $title]));
    }

    /**
     * @Then the article :title should appear in the list
     */
    public function thePageShouldAppearInTheList($title)
    {
        $this->indexPage->open();
        Assert::true($this->indexPage->isSingleResourceOnPage(['title' => $title]));
    }

    /**
     * @Then there should not be :title article anymore
     */
    public function thereShouldNotBePageAnymore($title)
    {
        $this->indexPage->open();

        Assert::false($this->indexPage->isSingleResourceOnPage(['title' => $title]));
    }
}
