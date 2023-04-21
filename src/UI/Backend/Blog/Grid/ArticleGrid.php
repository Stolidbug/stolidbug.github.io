<?php

declare(strict_types=1);

namespace App\UI\Backend\Blog\Grid;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use Sylius\Bundle\GridBundle\Builder\Action\CreateAction;
use Sylius\Bundle\GridBundle\Builder\Action\DeleteAction;
use Sylius\Bundle\GridBundle\Builder\Action\UpdateAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\BulkActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\MainActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\DateTimeField;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class ArticleGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public function __construct()
    {
        // TODO inject services if required
    }

    public static function getName(): string
    {
        return 'app_backend_blog_article';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->addFilter(StringFilter::create('search', ['title', 'content', 'slug']))
            ->addField(
                StringField::create('title')
                    ->setLabel($this->translate('title.label'))
                    ->setSortable(true),
            )
            ->addField(
                StringField::create('content')
                    ->setLabel($this->translate('content.label'))
                    ->setSortable(true),
            )
            ->addField(
                DateTimeField::create('createdAt')
                    ->setLabel($this->translate('createdAt.label')),
            )
            ->addField(
                DateTimeField::create('updatedAt')
                    ->setLabel($this->translate('updatedAt.label')),
            )
            ->addField(
                StringField::create('slug')
                    ->setLabel($this->translate('slug.label'))
                    ->setSortable(true),
            )
            ->addField(
                TwigField::create('categories', 'backend/grid/field/categories.html.twig')
                    ->setLabel($this->translate('label.categories.label')),
            )
            ->addField(
                TwigField::create('authors', 'backend/grid/field/authors.html.twig')
                    ->setLabel($this->translate('authors.label')),
            )
            ->addActionGroup(
                MainActionGroup::create(
                    CreateAction::create(),
                ),
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    // ShowAction::create(),
                    UpdateAction::create(),
                    DeleteAction::create(),
                ),
            )
            ->addActionGroup(
                BulkActionGroup::create(
                    DeleteAction::create(),
                ),
            )
        ;
    }

    public function getResourceClass(): string
    {
        return Article::class;
    }

    private function translate(string $key): string
    {
        return sprintf('backend.blog.ui.article.grid.fields.%s', $key);
    }
}
