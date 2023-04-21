@ui @frontend @webpage
Feature: Browsing pages in the frontend
    In order to see all pages in the homepage
    I want to browse pages

    Background:
        Given I already have a page "foo"

    Scenario: I go to the homepage
        When I want to browse pages in the frontend
        Then there should be 1 page in the list in the homepage
        And I should see the page "foo" in the list in the homepage
