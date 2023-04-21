<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\UI\Cli;

use Behat\Behat\Context\Context;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class DefaultContext implements Context
{
    protected Application $application;

    protected static ?CommandTester $sharedTester = null;

    protected Command $command;

    protected mixed $questionHelper;

    public function __construct(protected KernelInterface $kernel)
    {
    }

    public function setTester(?CommandTester $tester): void
    {
        static::$sharedTester = $tester;
    }

    public function getTester(): ?CommandTester
    {
        return static::$sharedTester;
    }

    protected function getEntityManager(): ObjectManager
    {
        return $this->getService('doctrine')->getManager();
    }

    protected function getService(string $id): ?object
    {
        return $this->getContainer()->get($id);
    }

    protected function getContainer(): ContainerInterface
    {
        return $this->kernel->getContainer();
    }
}
