<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'assets' => [
            'packages' => [
                'backend' => [
                    'json_manifest_path' => '%kernel.project_dir%/public/backend/build/manifest.json',
                ],
                'frontend' => [
                    'json_manifest_path' => '%kernel.project_dir%/public/assets/frontend/manifest.json',
                ],
            ],
        ],
    ]);
};
