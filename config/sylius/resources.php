<?php

declare(strict_types=1);

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Author;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Category;
use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Page;
use App\UI\Backend\Blog\Form\Type\ArticleType;
use App\UI\Backend\Blog\Form\Type\AuthorType;
use App\UI\Backend\Blog\Form\Type\CategoryType;
use App\UI\Backend\WebPage\Form\Type\PageType;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('sylius_resource', [
        'mapping' => [
            'paths' => [
                '%kernel.project_dir%/src/Security/Shared/Infrastructure/Persistence/Doctrine/ORM/Entity',
                '%kernel.project_dir%/src/Content/WebPage/Shared/Infrastructure/Persistence/Doctrine/ORM/Entity',
                '%kernel.project_dir%/src/Content/Blog/Shared/Infrastructure/Persistence/Doctrine/ORM/Entity',
            ],
        ],
        'resources' => [
            'app.webpage_page' => [
                'classes' => [
                    'model' => Page::class,
                    'form' => PageType::class,
                ],
            ],
            'app.blog_article' => [
                'classes' => [
                    'model' => Article::class,
                    'form' => ArticleType::class,
                ],
            ],
            'app.blog_author' => [
                'classes' => [
                    'model' => Author::class,
                    'form' => AuthorType::class,
                ],
            ],
            'app.blog_category' => [
                'classes' => [
                    'model' => Category::class,
                    'form' => CategoryType::class,
                ],
            ],
        ],
    ]);
};
