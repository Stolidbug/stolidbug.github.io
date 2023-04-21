@api @blog @articles
Feature: Create a new article in the api
    As an administrator
    I want to add a new article in the api

    Background: Fixtures
        Given I am logged in as an administrator

    Scenario: Create a new article
        Given I want to create a new article
        And there is a article "Jhon a la plage"
        Then I add it
        Then I should be notified that it has been successfully created
        And I should see the article "Jhon a la plage" in the list

