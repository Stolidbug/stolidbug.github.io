@contact @frontend
Feature: Contact form
    As a user,
    I want to be able to send a message to the site administrator
    So that I can ask questions or report issues

    Scenario: Send a valid message
        Given I am on the contact form page
        When I fill in the "name" field with "John Doe"
        And I fill in the "email" field with "john.doe@example.com"
        And I fill in the "message" field with "Hello, I have a question about your site."
        And I fill in the "captchaQuestion" field with "4 + 2"
        And I fill in the "userAnswer" field with "6"
        And I click the "send" button
        And I should see a notification "frontend.contact.create.form.send.label"
