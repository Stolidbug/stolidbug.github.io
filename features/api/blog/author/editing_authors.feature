@api @blog @authors
Feature: Editing a name in api
    As an administrator
    I want to edit a name in api
    So that I can edit a name in api

    Background: Fixtures
        Given I am logged in as an administrator

    Scenario: Editing a author in api
        Given I already have a author "foo"
        And I want to edit this author
        When I change its name to "Comedies"
        And I save it
        Then I should be notified that it has been successfully edited
        And I should see the author "Comedies" in the list
