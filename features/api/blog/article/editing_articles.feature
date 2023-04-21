@api @blog @articles
Feature: Editing a title in api
    As an administrator
    I want to edit a title in api
    So that I can edit a title in api

    Background: Fixtures
        Given I am logged in as an administrator

    Scenario: Editing a Article in api
        Given I already have a article "Toto a la plage"
        And I want to edit this article
        When I change its title to "Toto a la montagne"
        And I save it
        Then I should be notified that it has been successfully edited
        And I should see the article "Toto a la montagne" in the list
