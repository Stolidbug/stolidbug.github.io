@ui @backend @blog @articles
Feature: Editing a article
    In order to change information about a article
    As an Administrator
    I want to be able to edit a article

    Background:
        Given there is a title "foo"
        And I am logged in as an administrator

    Scenario: Renaming a article
        When I want to edit this article
        And I change its title to "Toto a la plage"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the article "Toto" should appear in the list
