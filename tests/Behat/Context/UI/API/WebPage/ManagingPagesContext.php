<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\UI\API\WebPage;

use App\Tests\Behat\Context\UI\API\Resources;
use Behat\Behat\Context\Context;
use Faker\Factory;
use Faker\Generator;
use Monofony\Bridge\Behat\Client\ApiClientInterface;
use Webmozart\Assert\Assert;

final class ManagingPagesContext implements Context
{
    private readonly Generator $faker;

    public function __construct(
        private readonly ApiClientInterface $client,
    ) {
        $this->faker = Factory::create();
    }

    /**
     * @Given I want to browse pages
     */
    public function iWantToBrowsePages(): void
    {
        $this->client->index(Resources::WEBPAGE_PAGES->value);
    }

    /**
     * @Given there must be no page in the list
     * @Given there should be :number page in the list
     */
    public function shouldHavePages(int $number = 0): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);

        Assert::eq($content['hydra:totalItems'], $number);
    }

    /**
     * @Given I want to create a new page
     */
    public function iWantToCreateANewPage(): void
    {
        $this->client->buildCreateRequest(Resources::WEBPAGE_PAGES->value);
    }

    /**
     * @Given there is a page :name
     */
    public function thereIsAPage(string $name): void
    {
        $this->client->setRequestData([
            'name' => $name,
            'content' => $this->faker->text(100),
            'author' => $this->faker->name,
            'status' => true,
            'slug' => $this->faker->slug,
        ]);
    }

    /**
     * @Given I add it
     */
    public function iAddIt(): void
    {
        $response = $this->client->create();
        Assert::eq($response->getStatusCode(), 201);
    }

    /**
     * @Given I should see the page :name in the list
     */
    public function iShouldSeeThePageInTheList(string $name): void
    {
        $response = $this->client->index(Resources::WEBPAGE_PAGES->value);
        $content = json_decode($response->getContent(), true);

        Assert::eq($content['hydra:member'][0]['name'], $name);
    }

    /**
     * @Given I already have a page :name
     */
    public function iAlreadyHaveAPage(string $name): void
    {
        $this->client->buildCreateRequest(Resources::WEBPAGE_PAGES->value);
        $this->client->setRequestData([
            'name' => $name,
            'content' => $this->faker->text(100),
            'author' => $this->faker->name,
            'status' => true,
            'slug' => $this->faker->slug,
        ]);
        $response = $this->client->create();

        Assert::eq($response->getStatusCode(), 201);
    }

    /**
     * @Given I want to edit this page
     */
    public function iWantToEditThisPage(): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);

        $this->client->buildUpdateRequest(Resources::WEBPAGE_PAGES->value, $content['id']);
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
     * @Given I save it
     */
    public function iSaveIt(): void
    {
        $response = $this->client->update();

        Assert::eq($response->getStatusCode(), 200);
    }

    /**
     * @Given /^I should be notified that it has been successfully (created|edited)$/
     */
    public function iShouldBeNotifierThatItHasBeenSuccessfullyEdited(): void
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);

        Assert::eq($response->headers->get('content-type'), 'application/ld+json; charset=utf-8');
        Assert::contains($content['@context'], '/api/contexts/Page');
        Assert::contains($content['@type'], 'Page');
        Assert::regex($content['@id'], '~^/api/pages/~');
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
     * @Given I delete page with name :name
     */
    public function iWantToDeleteThisPage(string $name)
    {
        $response = $this->client->getLastResponse();
        $content = json_decode($response->getContent(), true);

        $this->client->delete(Resources::WEBPAGE_PAGES->value, $content['id']);
    }

    /**
     * @Given there should not have any :name page anymore
     */
    public function thereShouldNotHaveAnyPageAnymore(string $name)
    {
        $response = $this->client->index(Resources::WEBPAGE_PAGES->value);
        $content = json_decode($response->getContent(), true);

        Assert::eq($content['hydra:totalItems'], 0);
    }
}
