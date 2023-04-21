<?php

declare(strict_types=1);

namespace App\UI\Backend\WebPage\Grid;

use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Page;
use Sylius\Bundle\GridBundle\Builder\Action\CreateAction;
use Sylius\Bundle\GridBundle\Builder\Action\DeleteAction;
use Sylius\Bundle\GridBundle\Builder\Action\ShowAction;
use Sylius\Bundle\GridBundle\Builder\Action\UpdateAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\BulkActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\MainActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\DateTimeField;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class PageGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public static function getName(): string
    {
        return 'app_backend_webpage';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder

            ->addField(
                StringField::create('name')
                    ->setLabel($this->translate('name.label'))
                    ->setSortable(true),
            )
            ->addField(
                StringField::create('content')
                    ->setLabel($this->translate('content.label'))
                    ->setSortable(true),
            )
            ->addField(
                StringField::create('author')
                    ->setLabel($this->translate('author.label'))
                    ->setSortable(true),
            )
            ->addField(
                StringField::create('slug')
                        ->setLabel($this->translate('slug.label'))
                    ->setSortable(true),
            )
            ->addField(
                TwigField::create('status', '@SyliusUi/Grid/Field/enabled.html.twig')
                    ->setLabel($this->translate('status.label'))
                    ->setSortable(true),
            )
            ->addField(
                DateTimeField::create('publicationDate')
                    ->setLabel('sylius.ui.publication_date'),
            )
            ->addActionGroup(
                MainActionGroup::create(
                    CreateAction::create(),
                ),
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    ShowAction::create(),
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
        return Page::class;
    }

    private function translate(string $key): string
    {
        return sprintf('backend.webpage.ui.page.fields.%s', $key);
    }
}
