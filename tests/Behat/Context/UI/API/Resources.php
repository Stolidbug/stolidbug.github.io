<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\UI\API;

enum Resources: string
{
    case WEBPAGE_PAGES = 'pages';
    case BLOG_CATEGORIES = 'categories';
    case BLOG_AUTHORS = 'authors';
    case BLOG_ARTICLES = 'articles';
}
