<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\UI\Frontend\Webpage;

use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\PageRepository;
use Behat\Behat\Context\Context;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Webmozart\Assert\Assert;

final class ManagingPagesContext implements Context
{
    public function __construct(
        private readonly PageRepository $repository,
        private readonly KernelBrowser $client,
    ) {
    }

    /**
     * @When I am on the :name page
     */
    public function iAmOnThePage(string $name): void
    {
        $page = $this->repository->findOneBy(['name' => $name]);
        $this->client->request('GET', '/' . $page->getSlug() . '.html');

        Assert::same($this->client->getResponse()->getStatusCode(), 200);
    }

    /**
     * @When I want to browse pages in the frontend
     */
    public function iWantToBrowsePagesInTheFrontend(): void
    {
        $this->client->request('GET', '/');
    }

    /**
     * @Then I should see the :name page
     */
    public function iShouldSeeThePage(string $name): void
    {
        $page = $this->repository->findOneBy(['name' => $name]);
        $crawler = $this->client->request('GET', '/' . $page->getSlug() . '.html');

        Assert::same($crawler->filter('h2')->text(), $name);
    }

    /**
     * @Then there should be :amount page in the list in the homepage
     */
    public function thereShouldBePageInTheListInTheHomepage(int $amount): void
    {
        $crawler = $this->client->request('GET', '/');
        Assert::eq($crawler->filter('[data-test-home-pages] li')->count(), $amount);
    }

    /**
     * @Then I should see the page :name in the list in the homepage
     */
    public function iShouldSeeThePageInTheListInTheHomepage(string $name): void
    {
        $crawler = $this->client->request('GET', '/');
        Assert::same($crawler->filter('[data-test-home-pages] li')->text(), $name);
    }
}
