<?php

declare(strict_types=1);

namespace App\UI\Backend;

final class Routes
{
    public const BACKEND_GENERATOR_SLUG = ['path' => '/admin/_partial/blog/generate-slug/{data}', 'name' => 'app_backend_blog_generate_slug'];
    public const BACKEND_WEBPAGE_PAGE_SHOW = ['path' => '/admin/webpage/page/{id}', 'name' => 'app_backend_webpage_page_show'];
    public const BACKEND_BLOG_CATEGORY_SHOW = ['path' => '/admin/blog/category/{slug}', 'name' => 'blog_backend_category_show'];
    public const BACKEND_BLOG_AUTHOR_SHOW = ['path' => '/admin/blog/author/{slug}', 'name' => 'blog_backend_author_show'];
}
