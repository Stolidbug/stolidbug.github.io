@ui @backend @blog @category
Feature: Browsing categories
    In order to see all categories in the admin panel
    As an Administrator
    I want to browse categories

    Background:
        Given there is a name "Games"
        And I am logged in as an administrator

    Scenario: Browsing authors in the admin panel
        When I want to browse categories
        Then there should be 1 category in the list
        And I should see the category "Games" in the list
