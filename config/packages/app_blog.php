<?php

declare(strict_types=1);

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Author;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Category;
use App\Content\Blog\Shared\Infrastructure\Sylius\Factory\ArticleFactory;
use App\Content\Blog\Shared\Infrastructure\Sylius\Factory\AuthorFactory;
use App\Content\Blog\Shared\Infrastructure\Sylius\Factory\CategoryFactory;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services
        ->set(ArticleFactory::class)
        ->decorate('app.factory.blog_article')
        ->arg('$className', Article::class);

    $services
        ->set(AuthorFactory::class)
        ->decorate('app.factory.blog_author')
        ->arg('$className', Author::class);

    $services
        ->set(CategoryFactory::class)
        ->decorate('app.factory.blog_category')
        ->arg('$className', Category::class);
};
