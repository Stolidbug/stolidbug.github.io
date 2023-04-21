<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Security\Shared\Infrastructure\Persistence\Fixture\Factory\AdminUserFactory;
use Behat\Behat\Context\Context;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Webmozart\Assert\Assert;

final class ApiSecurityContext implements Context
{
    public function __construct(
        private readonly SharedStorageInterface $sharedStorage,
        private JWTTokenManagerInterface $jwtTokenManager,
        private readonly AdminUserFactory $userFactory,
        private readonly UserRepositoryInterface $adminUserRepository,
    ) {
    }

    /**
     * @Given I am logged in as an administrator
     */
    public function iAmLoggedInAsAnAdministrator(): void
    {
        $user = $this->userFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
        ])
            ->disableAutoRefresh();

        $this->sharedStorage->set('token', $this->jwtTokenManager->create($user->object()));
        $this->sharedStorage->set('administrator', $user->object());
    }

    /**
     * @Given /^I am logged in as "([^"]+)" administrator$/
     */
    public function iAmLoggedInAsAdministrator($email): void
    {
        $user = $this->adminUserRepository->findOneByEmail($email);
        Assert::notNull($user);

        $this->securityService->logIn($user);

        $this->sharedStorage->set('administrator', $user);
    }
}
