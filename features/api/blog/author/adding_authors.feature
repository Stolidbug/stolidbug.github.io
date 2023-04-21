@api @blog @authors
Feature: Create a new author in the api
    As an administrator
    I want to add a new author in the api

    Background: Fixtures
        Given I am logged in as an administrator

    Scenario: Create a new author
        Given I want to create a new author
        And there is a author "Jhon"
        Then I add it
        Then I should be notified that it has been successfully created
        And I should see the author "Jhon" in the list

