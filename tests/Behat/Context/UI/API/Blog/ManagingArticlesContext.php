<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\UI\API\Blog;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Author;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Category;
use App\Tests\Behat\Context\UI\API\Resources;
use Behat\Behat\Context\Context;
use Faker\Factory;
use Faker\Generator;
use Monofony\Bridge\Behat\Client\ApiClientInterface;
use Webmozart\Assert\Assert;

final class ManagingArticlesContext extends ApiTestCase implements Context
{
    private readonly Generator $faker;
    public function __construct(
        private readonly ApiClientInterface $client,
    ) {
        $this->faker = Factory::create();
    }

    /**
     * @Given I save it
     */
    public function iSaveIt(): void
    {
        $response = $this->client->update();

        Assert::eq($response->getStatusCode(), 200);
    }

    /**
     * @Given I change its title to :title
     */
    public function iChangeItsTitleTo(string $title): void
    {
        $this->client->setRequestData([
            'title' => $title,
        ]);
    }

    /**
     * @Given I want to edit this article
     */
    public function iWantToEditThisArticle(): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);

        $this->client->buildUpdateRequest(Resources::BLOG_ARTICLES->value, $content['id']);
    }

    /**
     * @Given I delete article with title :title
     */
    public function iWantToDeleteThisTitle(string $title): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);

        $this->client->delete(Resources::BLOG_ARTICLES->value, $content['id']);
    }

    /**
     * @Given I should be notified that it has been successfully deleted
     */
    public function iShouldBeNotifierThatItHasBeenSuccessfullyDeleted(): void
    {
        $response = $this->client->getLastResponse();

        Assert::eq($response->getStatusCode(), 204);
    }

    /**
     * @Given there should not have any :title article anymore
     */
    public function thereShouldNotHaveAnyArticleAnymore(string $title): void
    {
        $response = $this->client->index(Resources::BLOG_ARTICLES->value);
        $content = json_decode($response->getContent(), true);

        Assert::eq($content['hydra:totalItems'], 0);
    }

    /**
     * @Given I already have a article :title
     */
    public function iAlreadyHaveAArticle(string $title): void
    {
        $this->client->buildCreateRequest(Resources::BLOG_AUTHORS->value);
        $this->client->setRequestData([
            'name' => 'toto',
            'slug' => $this->faker->slug,
        ]);
        $this->client->create();
        $this->client->buildCreateRequest(Resources::BLOG_CATEGORIES->value);
        $this->client->setRequestData([
            'name' => 'blavbla',
            'slug' => $this->faker->slug,
        ]);
        $this->client->create();
        $author = $this->findIriBy(Author::class, ['name' => 'toto']);
        $categories = $this->findIriBy(Category::class, ['name' => 'blavbla']);
        $this->client->buildCreateRequest(Resources::BLOG_ARTICLES->value);
        $this->client->setRequestData([
            'title' => $title,
            'content' => $this->faker->text(100),
            'slug' => $this->faker->slug,
            'categories' => [$categories],
            'authors' => [$author],
            'image' => 'https://picsum.photos/200/300',

        ]);
        $response = $this->client->create();

        Assert::eq($response->getStatusCode(), 201);
    }

    /**
     * @Given I want to browse articles
     */
    public function iWantToBrowseArticles(): void
    {
        $this->client->index(Resources::BLOG_ARTICLES->value);
    }

    /**
     * @Given there must be no articles in the list
     * @Given there should be :number articles in the list
     */
    public function shouldHaveArticles(int $number = 0): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);
        Assert::eq($content['hydra:totalItems'], $number);
    }

    /**
     * @Given I want to create a new article
     */
    public function iWantToCreateANewArticle(): void
    {
        $this->client->buildCreateRequest(Resources::BLOG_ARTICLES->value);
    }

    /**
     * @Then I add it
     */
    public function iAddIt(): void
    {
        $response = $this->client->create();
        Assert::eq($response->getStatusCode(), 201);
    }


    /**
     * @Given /^I should be notified that it has been successfully (created|edited)$/
     */
    public function iShouldBeNotifierThatItHasBeenSuccessfullyEdited(): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);

        Assert::eq($response->headers->get('content-type'), 'application/ld+json; charset=utf-8');
        Assert::contains($content['@context'], '/api/contexts/Article');
        Assert::contains($content['@type'], 'Article');
        Assert::regex($content['@id'], '~^/api/articles/~');
    }

    /**
     * @Given I should see the article :title in the list
     */
    public function iShouldSeeTheArticleInTheList(string $title): void
    {
        $response = $this->client->index(Resources::BLOG_ARTICLES->value);
        $content = json_decode($response->getContent(), true);

        Assert::eq($content['hydra:member'][0]['title'], $title);
    }

    /**
     * @Given there is a article :title
     */
    public function thereIsAArticle(string $title): void
    {
        $this->client->buildCreateRequest(Resources::BLOG_AUTHORS->value);
        $this->client->setRequestData([
            'name' => 'toto',
            'slug' => $this->faker->slug,
        ]);
        $this->client->create();
        $this->client->buildCreateRequest(Resources::BLOG_CATEGORIES->value);
        $this->client->setRequestData([
            'name' => 'blavbla',
            'slug' => $this->faker->slug,
        ]);
        $this->client->create();
        $author = $this->findIriBy(Author::class, ['name' => 'toto']);
        $categories = $this->findIriBy(Category::class, ['name' => 'blavbla']);
        $this->client->buildCreateRequest(Resources::BLOG_ARTICLES->value);
        $this->client->setRequestData([
            'title' => $title,
            'content' => $this->faker->text(100),
            'slug' => $this->faker->slug,
            'categories' => [$categories],
            'authors' => [$author],
            'image' => 'https://picsum.photos/200/300',

        ]);
    }
}
