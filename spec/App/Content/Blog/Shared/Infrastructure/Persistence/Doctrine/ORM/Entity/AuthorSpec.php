<?php

declare(strict_types=1);

namespace spec\App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity;

use App\Content\Blog\Shared\Domain\Identifier\AuthorId;
use App\Content\Blog\Shared\Infrastructure\Identity\AuthorIdGenerator;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Author;
use App\Shared\Infrastructure\Generator\UuidGenerator;
use PhpSpec\ObjectBehavior;

class AuthorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Author::class);
    }

    public function let(AuthorIdGenerator $generator): void
    {
        $authorId = new AuthorId(UuidGenerator::generate());
        $this->beConstructedWith($authorId);
    }

    public function it_should_have_a_name(): void
    {
        $this->setName('joe');
        $this->getName()->shouldReturn('joe');
    }

    public function it_should_not_have_a_name(): void
    {
        $this->getName()->shouldReturn(null);
    }

    public function it_should_have_a_slug(): void
    {
        $this->setSlug('author-slug');
        $this->getSlug()->shouldReturn('author-slug');
    }

    public function it_should_not_have_a_slug(): void
    {
        $this->getSlug()->shouldReturn(null);
    }
}
