@api @blog @authors
Feature: Deleting a author in api
    As an administrator
    I want to delete a author
    So that I can remove it from the system

    Background: Fixtures
        Given I am logged in as an administrator

    Scenario: Deleting a author
        Given I already have a author "foo"
        When I delete author with name "foo"
        Then I should be notified that it has been successfully deleted
        And there should not have any "foo" author anymore

