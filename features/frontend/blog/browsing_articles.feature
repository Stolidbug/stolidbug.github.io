@ui @frontend @blog
Feature: Browsing articles in the frontend
    In order to see all articles in the homepage
    I want to browse articles

    Background:
        Given there is a title "foo"

    Scenario: I go to the homepage
        When I want to browse articles in the frontend
        Then there should be 1 article in the list in the homepage
        And I should see the article "foo" in the list in the homepage
