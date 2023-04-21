@ui @frontend @webpage
Feature: Show the page
    In order to see the page

    Background:
        Given I already have a page "foo"

    Scenario: Show the page
        When I am on the "foo" page
        Then I should see the "foo" page
