@ui @frontend @blog
Feature: Show the page
    In order to see the page

    Background:
        Given there is a title "foo"

    Scenario: Show the page
        When I am on the "foo" article
        Then I should see the "foo" article
