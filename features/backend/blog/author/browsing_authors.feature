@ui @backend @blog @authors
Feature: Browsing authors
    In order to see all authors in the admin panel
    As an Administrator
    I want to browse authors

    Background:
        Given there is a name "foo"
        And I am logged in as an administrator

    Scenario: Browsing authors in the admin panel
        When I want to browse authors
        Then there should be 1 author in the list
        And I should see the author "foo" in the list
