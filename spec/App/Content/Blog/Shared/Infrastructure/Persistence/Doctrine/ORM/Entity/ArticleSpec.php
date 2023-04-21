<?php

declare(strict_types=1);

namespace spec\App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity;

use App\Content\Blog\Shared\Domain\Identifier\ArticleId;
use App\Content\Blog\Shared\Domain\Identifier\CategoryId;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Category;
use App\Shared\Infrastructure\Clock\Clock;
use App\Shared\Infrastructure\Generator\UuidGenerator;
use PhpSpec\ObjectBehavior;

class ArticleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Article::class);
    }

    public function let(): void
    {
        $articleId = new ArticleId(UuidGenerator::generate());
        $this->beConstructedWith($articleId);
    }

    public function it_should_have_a_title(): void
    {
        $this->setTitle('title');
        $this->getTitle()->shouldReturn('title');
    }

    public function it_should_have_a_content(): void
    {
        $this->setContent('content');
        $this->getContent()->shouldReturn('content');
    }

    public function it_should_have_a_created_at_date(): void
    {
        $createdAt = (new Clock())->now();
        $this->setCreatedAt($createdAt);
        $this->getCreatedAt()->shouldReturn($createdAt);
    }

    public function it_should_have_an_updated_at_date(): void
    {
        $updatedAt = (new Clock())->now();
        $this->setUpdatedAt($updatedAt);
        $this->getUpdatedAt()->shouldReturn($updatedAt);
    }

    public function it_should_have_a_slug(): void
    {
        $this->setSlug('slug');
        $this->getSlug()->shouldReturn('slug');
    }

    public function it_should_have_categories(): void
    {
        $category1 = new Category(new CategoryId(UuidGenerator::generate()));
        $category2 = new Category(new CategoryId(UuidGenerator::generate()));

        $this->addCategory($category1);
        $this->addCategory($category2);

        $this->getCategories()->shouldHaveCount(2);
        $this->getCategories()->shouldContain($category1);
        $this->getCategories()->shouldContain($category2);
    }

    public function it_should_remove_a_category(): void
    {
        $category1 = new Category(new CategoryId(UuidGenerator::generate()));
        $category2 = new Category(new CategoryId(UuidGenerator::generate()));

        $this->addCategory($category1);
        $this->addCategory($category2);

        $this->removeCategory($category1);

        $this->getCategories()->shouldHaveCount(1);
        $this->getCategories()->shouldContain($category2);
        $this->getCategories()->shouldNotContain($category1);
    }
}
