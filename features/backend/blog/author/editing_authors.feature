@ui @backend @blog @authors
Feature: Editing a author
    In order to change information about a author
    As an Administrator
    I want to be able to edit a author

    Background:
        Given there is a name "foo"
        And I am logged in as an administrator

    Scenario: Renaming a author
        When I want to edit this author
        And I change its name to "Jhon"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the author "jhon" should appear in the list
