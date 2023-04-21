<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\UI\API\Blog;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Behat\Context\UI\API\Resources;
use Behat\Behat\Context\Context;
use Faker\Factory;
use Faker\Generator;
use Monofony\Bridge\Behat\Client\ApiClientInterface;
use Webmozart\Assert\Assert;

final class ManagingCategoriesContext extends ApiTestCase implements Context
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
     * @Given I change its name to :name
     */
    public function iChangeItsNameTo(string $name): void
    {
        $this->client->setRequestData([
            'name' => $name,
        ]);
    }

    /**
     * @Given I want to edit this category
     */
    public function iWantToEditThisCategory(): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);

        $this->client->buildUpdateRequest(Resources::BLOG_CATEGORIES->value, $content['id']);
    }

    /**
     * @Given I delete category with name :name
     */
    public function iWantToDeleteThisCategory(string $name): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);

        $this->client->delete(Resources::BLOG_CATEGORIES->value, $content['id']);
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
     * @Given there should not have any :name category anymore
     */
    public function thereShouldNotHaveAnyCategoryAnymore(string $name): void
    {
        $response = $this->client->index(Resources::BLOG_CATEGORIES->value);
        $content = json_decode($response->getContent(), true);

        Assert::eq($content['hydra:totalItems'], 0);
    }

    /**
     * @Given I already have a category :name
     */
    public function iAlreadyHaveACategory(string $name): void
    {
        $this->client->buildCreateRequest(Resources::BLOG_CATEGORIES->value);
        $this->client->setRequestData([
            'name' => $name,
            'slug' => $this->faker->slug,
        ]);
        $response = $this->client->create();

        Assert::eq($response->getStatusCode(), 201);
    }

    /**
     * @Given I want to browse categories
     */
    public function iWantToBrowseCategories(): void
    {
        $this->client->index(Resources::BLOG_CATEGORIES->value);
    }

    /**
     * @Given there must be no categories in the list
     * @Given there should be :number categories in the list
     */
    public function shouldHaveCategories(int $number = 0): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);
        Assert::eq($content['hydra:totalItems'], $number);
    }

    /**
     * @Given I want to create a new category
     */
    public function iWantToCreateANewCategory(): void
    {
        $this->client->buildCreateRequest(Resources::BLOG_CATEGORIES->value);
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
        Assert::contains($content['@context'], '/api/contexts/Category');
        Assert::contains($content['@type'], 'Category');
        Assert::regex($content['@id'], '~^/api/categories/~');
    }

    /**
     * @Given I should see the category :name in the list
     */
    public function iShouldSeeTheCategoryInTheList(string $name): void
    {
        $response = $this->client->index(Resources::BLOG_CATEGORIES->value);
        $content = json_decode($response->getContent(), true);

        Assert::eq($content['hydra:member'][0]['name'], $name);
    }

    /**
     * @Given there is a category :name
     */
    public function thereIsACategory(string $name): void
    {
        $this->client->setRequestData([
            'name' => $name,
            'slug' => $this->faker->slug,
        ]);
    }
}
