@ui @backend @blog @category
Feature: Adding a new category
    In order to create new category
    As an Administrator
    I want to add a category in the admin panel

    Background:
        Given I am logged in as an administrator

    Scenario: Adding a new category
        Given I want to create a new category
        When there is a name "Games"
        And I add it
        And the category "Games" should appear in the list
