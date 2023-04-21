<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('api_platform', [
        'title' => 'Monofony API',
        'mapping' => [
            'paths' => [
                '%kernel.project_dir%/src/Security/Shared/Infrastructure/Persistence/Doctrine/ORM/Entity',
                '%kernel.project_dir%/src/Content/WebPage/Shared/Infrastructure/Persistence/Doctrine/ORM/Entity',
                '%kernel.project_dir%/src/Content/Blog/Shared/Infrastructure/Persistence/Doctrine/ORM/Entity',
            ],
        ],
        'patch_formats' => [
            'json' => [
                'application/merge-patch+json',
            ],
        ],
        'swagger' => [
            'versions' => [3],
        ],
    ]);
};
