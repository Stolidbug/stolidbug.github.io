@api @blog @articles
Feature: Browsing articles through the API
    As an administrator
    I want to browse articles

    Background: Fixtures
        Given I am logged in as an administrator

    Scenario: Browsing articles
        Given I already have a article "Jhon a la plage"
        When I want to browse articles
        Then there should be "1" articles in the list
        And I should see the article "Jhon a la plage" in the list

