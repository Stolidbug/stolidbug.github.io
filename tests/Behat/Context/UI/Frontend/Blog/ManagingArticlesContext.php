<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\UI\Frontend\Blog;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\ArticleRepository;
use Behat\Behat\Context\Context;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Webmozart\Assert\Assert;

final class ManagingArticlesContext implements Context
{
    public function __construct(
        private readonly ArticleRepository $repository,
        private readonly KernelBrowser $client,
    ) {
    }

    /**
     * @When I am on the :name article
     */
    public function iAmOnTheArticle(string $name): void
    {
        $article = $this->repository->findOneBy(['title' => $name]);
        $this->client->request('GET', '/blog/article/' . $article->getSlug() . '.html');

        Assert::same($this->client->getResponse()->getStatusCode(), 200);
    }

    /**
     * @When I want to browse articles in the frontend
     */
    public function iWantToBrowseArticlesInTheFrontend(): void
    {
        $this->client->request('GET', '/');
    }

    /**
     * @Then I should see the :title article
     */
    public function iShouldSeeTheArticle(string $title): void
    {
        $article = $this->repository->findOneBy(['title' => $title]);
        $crawler = $this->client->request('GET', '/blog/article/' . $article->getSlug() . '.html');
        Assert::same($crawler->filter('h2')->text(), $title);
    }

    /**
     * @Then there should be :amount article in the list in the homepage
     */
    public function thereShouldBeArticleInTheListInTheHomepage(int $amount): void
    {
        $crawler = $this->client->request('GET', '/');
        Assert::eq($crawler->filter('[data-test-home-articles] li')->count(), $amount);
    }

    /**
     * @Then I should see the article :title in the list in the homepage
     */
    public function iShouldSeeTheArticleInTheListInTheHomepage(string $title): void
    {
        $crawler = $this->client->request('GET', '/');
        Assert::same($crawler->filter('[data-test-home-articles] li')->text(), $title);
    }
}
