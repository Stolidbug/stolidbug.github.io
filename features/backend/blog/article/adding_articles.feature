@ui @backend @blog @articles
Feature: Adding a new article
    In order to create new article
    As an Administrator
    I want to add a article in the admin panel

    Background:
        Given I am logged in as an administrator

    Scenario: Adding a new article
        Given I want to create a new article
        When there is a title "foo"
        And I add it
        And the article "foo" should appear in the list
