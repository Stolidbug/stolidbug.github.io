@api @blog @categories
Feature: Browsing categories through the API
    As an administrator
    I want to browse categories

    Background: Fixtures
        Given I am logged in as an administrator

    Scenario: Browsing categories
        Given I already have a category "foo"
        When I want to browse categories
        Then there should be "1" categories in the list
        And I should see the category "foo" in the list

