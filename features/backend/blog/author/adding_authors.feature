@ui @backend @blog @authors
Feature: Adding a new author
    In order to create new author
    As an Administrator
    I want to add a author in the admin panel

    Background:
        Given I am logged in as an administrator

    Scenario: Adding a new author
        Given I want to create a new author
        When there is a name "Jhon Doe"
        And I add it
        And the author "Jhon Doe" should appear in the list
