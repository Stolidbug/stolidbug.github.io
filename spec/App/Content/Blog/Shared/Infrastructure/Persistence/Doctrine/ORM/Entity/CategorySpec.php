<?php

declare(strict_types=1);

namespace spec\App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity;

use App\Content\Blog\Shared\Domain\Identifier\CategoryId;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Category;
use App\Shared\Infrastructure\Generator\UuidGenerator;
use PhpSpec\ObjectBehavior;

class CategorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Category::class);
    }

    public function let(): void
    {
        $categoryId = new CategoryId(UuidGenerator::generate());
        $this->beConstructedWith($categoryId);
    }

    public function it_should_have_a_name(): void
    {
        $this->setName('Science');
        $this->getName()->shouldReturn('Science');
    }

    public function it_should_not_have_a_name(): void
    {
        $this->getName()->shouldReturn(null);
    }

    public function it_should_have_a_slug(): void
    {
        $this->setSlug('category-slug');
        $this->getSlug()->shouldReturn('category-slug');
    }

    public function it_should_not_have_a_slug(): void
    {
        $this->getSlug()->shouldReturn(null);
    }
}
