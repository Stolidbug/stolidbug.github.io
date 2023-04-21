<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Security;

use Monofony\Bridge\Behat\Crud\AbstractCreatePage;

class CreatePage extends AbstractCreatePage
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'sylius_backend_admin_user_create';
    }

    public function enable(): void
    {
        $this->getElement('enabled')->check();
    }

    public function specifyUsername(?string $username): void
    {
        $this->getElement('name')->setValue($username);
    }

    public function specifyEmail(?string $email): void
    {
        $this->getElement('email')->setValue($email);
    }

    public function specifyPassword(?string $password): void
    {
        $this->getElement('password')->setValue($password);
    }

    public function specifyLocale(?string $localeCode): void
    {
        $this->getElement('locale_code')->selectOption($localeCode);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'email' => '#app_backend_admin_user_email',
            'enabled' => '#app_backend_admin_user_enabled',
            'locale_code' => '#app_backend_admin_user_localeCode',
            'name' => '#app_backend_admin_user_username',
            'password' => '#app_backend_admin_user_plainPassword',
        ]);
    }
}