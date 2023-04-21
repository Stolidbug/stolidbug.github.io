@ui @backend @blog @category
Feature: Deleting a category
    In order to get rid of deprecated category
    As an Administrator
    I want to be able to delete a category

    Background:
        Given there is a name "Games"
        And I am logged in as an administrator

    Scenario: Deleting a category
        Given I am browsing categories
        When I delete category with name "Games"
        Then I should be notified that it has been successfully deleted
        And there should not be "Games" category anymore
