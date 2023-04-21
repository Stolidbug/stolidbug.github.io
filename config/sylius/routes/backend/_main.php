<?php

declare(strict_types=1);

use App\UI\Backend\Dashboard\Controller\Dashboard;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator
        ->add('app_backend_dashboard', '/')
        ->defaults([
            '_controller' => Dashboard\Action::class,
            'template' => 'backend/index.html.twig',
        ])
    ;

    $routingConfigurator
        ->import('partial.php')
        ->prefix('/_partial')
    ;

    $routingConfigurator
        ->import('security.php')
    ;
};
