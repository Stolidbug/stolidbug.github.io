<?php

declare(strict_types=1);

namespace App\UI\Frontend\Controller;

final class Routes
{
    public const FRONTEND_INDEX = ['path' => '/', 'name' => 'app_frontend_homepage'];

    public const FRONTEND_INFO = ['path' => '/info.html/{slug}.html', 'name' => 'app_frontend_info'];

    public const FRONTEND_CONTACT = ['path' => '/contact.html', 'name' => 'app_frontend_contact'];

    public const FRONTEND_WEBPAGE_PAGE_SHOW = ['path' => '/{slug}.html', 'name' => 'app_frontend_webpage_page_show'];

    public const FRONTEND_BLOG_SHOW_ARTICLE = ['path' => '/blog/article/{slug}.html', 'name' => 'app_frontend_blog_article_show'];

    public const FRONTEND_BLOG_LAST_READ_ARTICLES = ['path' => '/blog/last-read-articles.html', 'name' => 'app_frontend_blog_last_read_articles'];

    public const FRONTEND_MYSTERY_NUMBER = ['path' => '/mystery-number.html', 'name' => 'app_frontend_mystery_number'];
}
