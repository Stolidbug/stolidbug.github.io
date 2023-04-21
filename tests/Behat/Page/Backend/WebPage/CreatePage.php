<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\WebPage;

use Monofony\Bridge\Behat\Behaviour\NamesIt;
use Monofony\Bridge\Behat\Crud\AbstractCreatePage;

final class CreatePage extends AbstractCreatePage
{
    use NamesIt;
    public function getRouteName(): string
    {
        return 'app_backend_webpage_page_create';
    }

    public function specifyContent(string $content): void
    {
        $this->getDocument()->fillField('Content', $content);
    }

    public function specifyAuthor(string $author): void
    {
        $this->getDocument()->fillField('Author', $author);
    }

    public function specifySlug(string $slug): void
    {
        $this->getDocument()->fillField('Slug', $slug);
    }

    public function specifyPublished(): void
    {
        $this->getDocument()->checkField('Status', true);
    }
}
