@api @blog @authors
Feature: Browsing authors through the API
    As an administrator
    I want to browse authors

    Background: Fixtures
        Given I am logged in as an administrator

    Scenario: Browsing authors
        Given I already have a author "Jhon"
        When I want to browse authors
        Then there should be "1" authors in the list
        And I should see the author "Jhon" in the list

