<?php

declare(strict_types=1);

namespace App\UI\API\Blog\Article\State\Processor\Add;

final class Payload
{
    public function __construct(
        private readonly string $title,
        private readonly string $content,
        private readonly string $slug,
        private readonly array $categories,
        private readonly array $authors,
        private readonly string $image,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}
