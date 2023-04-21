<?php

declare(strict_types=1);

namespace App\UI\Backend;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Monofony\Component\Admin\Menu\AdminMenuBuilderInterface;

final class MenuBuilder implements AdminMenuBuilderInterface
{
    public function __construct(
        private readonly FactoryInterface $factory,
    ) {
    }

    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $this->addConfigurationSubMenu($menu);

        return $menu;
    }

    private function addConfigurationSubMenu(ItemInterface $menu): void
    {
        $configuration = $menu
            ->addChild('configuration')
            ->setLabel('sylius.ui.configuration')
        ;

        $configuration
            ->addChild('backend_admin_user', [
                'route' => 'sylius_backend_admin_user_index',
            ])
            ->setLabel('sylius.ui.admin_users')
            ->setLabelAttribute('icon', 'lock')
        ;

        $configuration = $menu
            ->addChild('webpage')
            ->setLabel('WebPage')
        ;

        $configuration
            ->addChild('backend_webpage_page', [
                'route' => 'app_backend_webpage_page_index',
            ])
            ->setLabel('backend.webpage.ui.page.index.title')
            ->setLabelAttribute('icon', 'book')
        ;

        $blog = $menu
            ->addChild('blog_backend')
            ->setLabel('sylius.ui.blog')
        ;

        $blog
            ->addChild('app_backend_blog_article', [
                'route' => 'app_backend_blog_article_index',
            ])
            ->setLabel('sylius.ui.article')
            ->setLabelAttribute('icon', 'file text')
        ;

        $blog
            ->addChild('app_backend_blog_author', [
                'route' => 'app_backend_blog_author_index',
            ])
            ->setLabel('sylius.ui.author')
            ->setLabelAttribute('icon', 'user')
        ;

        $blog
            ->addChild('app_backend_blog_category', [
                'route' => 'app_backend_blog_category_index',
            ])
            ->setLabel('sylius.ui.category')
            ->setLabelAttribute('icon', 'folder')
        ;
    }
}
