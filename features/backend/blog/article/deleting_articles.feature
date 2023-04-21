@ui @backend @blog @articles
Feature: Deleting a article
    In order to get rid of deprecated articles
    As an Administrator
    I want to be able to delete a article

    Background:
        Given there is a title "Toto"
        And I am logged in as an administrator

    Scenario: Deleting a article
        Given I am browsing articles
        When I delete article with title "Toto"
        Then I should be notified that it has been successfully deleted
        And there should not be "Toto" article anymore
