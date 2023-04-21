<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import(__DIR__ . '/../src/UI/Frontend/Controller/**/Action.php', 'annotation');
    $routingConfigurator->import(__DIR__ . '/../src/UI/Backend/**/Controller/**/Action.php', 'annotation');
    $routingConfigurator->import(__DIR__ . '/../src/UI/Syndication/**/Controller/**/Action.php', 'annotation');
    $routingConfigurator->import('../src/Kernel.php', 'annotation');
};
