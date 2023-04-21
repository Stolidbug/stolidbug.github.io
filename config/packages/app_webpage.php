<?php

declare(strict_types=1);

use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Page;
use App\Content\WebPage\Shared\Infrastructure\Sylius\Factory\PageFactory;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services
        ->set(PageFactory::class)
        ->decorate('app.factory.webpage_page')
        ->arg('$className', Page::class)
    ;
};
