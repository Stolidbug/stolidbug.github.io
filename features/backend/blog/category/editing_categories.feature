@ui @backend @blog @category
Feature: Editing a category
    In order to change information about a category
    As an Administrator
    I want to be able to edit a category

    Background:
        Given there is a name "Games"
        And I am logged in as an administrator

    Scenario: Renaming a category
        When I want to edit this category
        And I change its name to "Sports"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the category "Sports" should appear in the list
