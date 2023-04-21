@api @blog @articles
Feature: Deleting a article in api
    As an administrator
    I want to delete a article
    So that I can remove it from the system

    Background: Fixtures
        Given I am logged in as an administrator

    Scenario: Deleting a article
        Given I already have a article "foo"
        When I delete article with title "foo"
        Then I should be notified that it has been successfully deleted
        And there should not have any "foo" article anymore

