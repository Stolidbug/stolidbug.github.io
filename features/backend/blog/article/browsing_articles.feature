@ui @backend @blog @articles
Feature: Browsing articles
    In order to see all articles in the admin panel
    As an Administrator
    I want to browse articles

    Background:
        Given there is a title "foo"
        And I am logged in as an administrator

    Scenario: Browsing articles in the admin panel
        When I want to browse articles
        Then there should be 1 article in the list
        And I should see the article "foo" in the list
