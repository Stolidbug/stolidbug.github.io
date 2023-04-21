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

final class ManagingAuthorsContext extends ApiTestCase implements Context
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
     * @Given I want to edit this author
     */
    public function iWantToEditThisAuthor(): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);

        $this->client->buildUpdateRequest(Resources::BLOG_AUTHORS->value, $content['id']);
    }

    /**
     * @Given I delete author with name :name
     */
    public function iWantToDeleteThisAuthor(string $name): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);

        $this->client->delete(Resources::BLOG_AUTHORS->value, $content['id']);
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
     * @Given there should not have any :name author anymore
     */
    public function thereShouldNotHaveAnyAuthorAnymore(string $name): void
    {
        $response = $this->client->index(Resources::BLOG_AUTHORS->value);
        $content = json_decode($response->getContent(), true);

        Assert::eq($content['hydra:totalItems'], 0);
    }

    /**
     * @Given I already have a author :name
     */
    public function iAlreadyHaveAAuthor(string $name): void
    {
        $this->client->buildCreateRequest(Resources::BLOG_AUTHORS->value);
        $this->client->setRequestData([
            'name' => $name,
            'slug' => $this->faker->slug,
        ]);
        $response = $this->client->create();

        Assert::eq($response->getStatusCode(), 201);
    }

    /**
     * @Given I want to browse authors
     */
    public function iWantToBrowseAuthors(): void
    {
        $this->client->index(Resources::BLOG_AUTHORS->value);
    }

    /**
     * @Given there must be no authors in the list
     * @Given there should be :number authors in the list
     */
    public function shouldHaveAuthors(int $number = 0): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);
        Assert::eq($content['hydra:totalItems'], $number);
    }

    /**
     * @Given I want to create a new author
     */
    public function iWantToCreateANewAuthor(): void
    {
        $this->client->buildCreateRequest(Resources::BLOG_AUTHORS->value);
    }

    /**
     * @Then I add it
     */
    public function iAddIt()
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
        Assert::contains($content['@context'], '/api/contexts/Author');
        Assert::contains($content['@type'], 'Author');
        Assert::regex($content['@id'], '~^/api/authors/~');
    }

    /**
     * @Given I should see the author :name in the list
     */
    public function iShouldSeeTheAuthorInTheList(string $name): void
    {
        $response = $this->client->index(Resources::BLOG_AUTHORS->value);
        $content = json_decode($response->getContent(), true);

        Assert::eq($content['hydra:member'][0]['name'], $name);
    }

    /**
     * @Given there is a author :name
     */
    public function thereIsAAuthor(string $name): void
    {
        $this->client->setRequestData([
            'name' => $name,
            'slug' => $this->faker->slug,
        ]);
    }
}
