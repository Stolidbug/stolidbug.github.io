@ui @backend @blog @authors
Feature: Deleting a author
    In order to get rid of deprecated authors
    As an Administrator
    I want to be able to delete a author

    Background:
        Given there is a name "Toto"
        And I am logged in as an administrator

    Scenario: Deleting a author
        Given I am browsing authors
        When I delete author with name "Toto"
        Then I should be notified that it has been successfully deleted
        And there should not be "Toto" author anymore
