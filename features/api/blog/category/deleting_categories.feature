@api @blog @categories
Feature: Deleting a category in api
    As an administrator
    I want to delete a category
    So that I can remove it from the system

    Background: Fixtures
        Given I am logged in as an administrator

    Scenario: Deleting a category
        Given I already have a category "foo"
        When I delete category with name "foo"
        Then I should be notified that it has been successfully deleted
        And there should not have any "foo" category anymore

