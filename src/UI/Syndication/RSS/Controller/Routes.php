<?php

declare(strict_types=1);

namespace App\UI\Syndication\RSS\Controller;

final class Routes
{
    public const RSS_READ_ARTICLES = ['path' => '/rss/articles', 'name' => 'syndication_rss_article'];
    public const RSS_READ_CATEGORY = ['path' => '/rss/category/{slug}', 'name' => 'syndication_rss_category'];
}
