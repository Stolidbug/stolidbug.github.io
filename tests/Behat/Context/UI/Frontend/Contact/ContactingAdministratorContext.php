<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\UI\Frontend\Contact;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactingAdministratorContext extends MinkContext implements Context
{
    public function __construct(
        readonly TranslatorInterface $translator,
    ) {
    }

    /**
     * @Given I am on the contact form page
     */
    public function iAmOnTheContactFormPage(): void
    {
        $this->visitPath('/contact.html');
        $this->assertPageAddress('/contact.html');
    }

    /**
     * @When I fill in the :label field with :content
     */
    public function iFillInTheFieldWith($label, $content): void
    {
        $fieldId = 'contact_' . $label;
        if ($label === 'captchaQuestion') {
            $fieldId = 'contact_captchaQuestion';
        } elseif ($label === 'userAnswer') {
            $fieldId = 'contact_captchaUserAnswer';
        }

        $this->fillField($fieldId, $content);
        $this->assertSession()->fieldValueEquals($fieldId, $content);
    }

    /**
     * @When I click the :button button
     */
    public function iClickTheButton($button): void
    {
        $this->pressButton('contact-' . $button);
    }

    /**
     * @Then I should see a notification :notificationMessage
     *
     */
    public function iShouldSeeANotification($notificationMessage): void
    {
        $translatedMessage = $this->translator->trans($notificationMessage);
        $this->assertSession()->pageTextContains($translatedMessage);
    }
}
