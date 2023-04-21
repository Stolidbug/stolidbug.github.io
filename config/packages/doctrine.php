<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('doctrine', [
        'dbal' => [
            'url' => '%env(resolve:DATABASE_URL)%',
        ],
        'orm' => [
            'auto_generate_proxy_classes' => true,
            'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
            'auto_mapping' => true,
            'mappings' => [
                'Security' => [
                    'is_bundle' => false,
                    'type' => 'attribute',
                    'dir' => '%kernel.project_dir%/src/Security/Shared/Infrastructure/Persistence/Doctrine/ORM/Entity',
                    'prefix' => 'App\Security\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity',
                    'alias' => 'Security',
                ],
                'WebPage' => [
                    'is_bundle' => false,
                    'type' => 'attribute',
                    'dir' => '%kernel.project_dir%/src/Content/WebPage/Shared/Infrastructure/Persistence/Doctrine/ORM/Entity',
                    'prefix' => 'App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity',
                    'alias' => 'WebPage',
                ],
                'Blog' => [
                    'is_bundle' => false,
                    'type' => 'attribute',
                    'dir' => '%kernel.project_dir%/src/Content/Blog/Shared/Infrastructure/Persistence/Doctrine/ORM/Entity',
                    'prefix' => 'App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity',
                    'alias' => 'Blog',
                ],
            ],
        ],
    ]);

    if ('test' === $containerConfigurator->env()) {
        $containerConfigurator->extension('doctrine', [
            'dbal' => [
                'dbname_suffix' => '_test%env(default::TEST_TOKEN)%',
            ],
        ]);
    }

    if ('prod' === $containerConfigurator->env()) {
        $containerConfigurator->extension('doctrine', [
            'orm' => [
                'auto_generate_proxy_classes' => false,
                'query_cache_driver' => [
                    'type' => 'pool',
                    'pool' => 'doctrine.system_cache_pool',
                ],
                'result_cache_driver' => [
                    'type' => 'pool',
                    'pool' => 'doctrine.result_cache_pool',
                ],
            ],
        ]);

        $containerConfigurator->extension('framework', [
            'cache' => [
                'pools' => [
                    'doctrine.result_cache_pool' => [
                        'adapter' => 'cache.app',
                    ],
                    'doctrine.system_cache_pool' => [
                        'adapter' => 'cache.system',
                    ],
                ],
            ],
        ]);
    }
};
