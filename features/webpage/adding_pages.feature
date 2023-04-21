@ui @webpage
Feature: Manage pages
    In order to display pages for my website
    As an administrator
    I want to manage my webpages

    Background: Fixtures
        Given I am logged in as an administrator

    @backend @api
    Scenario: Browsing pages
        When I want to browse pages
        And there must be no page in the list

    @backend @api
    Scenario: Adding a new page
        Given I want to create a new page
        And there is a page "foo"
        Then I add it
        Then I should be notified that it has been successfully created
        And I should see the page "foo" in the list

    @backend @api
    Scenario: Browsing pages
        Given I already have a page "foo"
        When I want to browse pages
        Then there should be "1" page in the list
        And I should see the page "foo" in the list

    @backend @api
    Scenario: Renaming a page
        Given I already have a page "foo"
        And I want to edit this page
        When I change its name to "Toto a la plage"
        And I save it
        Then I should be notified that it has been successfully edited
        And I should see the page "Toto a la plage" in the list

    @backend @api
    Scenario: Deleting a page
        Given I already have a page "foo"
        When I delete page with name "foo"
        Then I should be notified that it has been successfully deleted
        And there should not have any "foo" page anymore
