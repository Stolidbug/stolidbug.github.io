@api @blog @categories
Feature: Create a new category in the api
    As an administrator
    I want to add a new category in the api

    Background: Fixtures
        Given I am logged in as an administrator

    Scenario: Create a new category
        Given I want to create a new category
        And there is a category "foo"
        Then I add it
        Then I should be notified that it has been successfully created
        And I should see the category "foo" in the list

