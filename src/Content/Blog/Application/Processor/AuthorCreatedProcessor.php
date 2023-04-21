<?php

declare(strict_types=1);

namespace App\Content\Blog\Application\Processor;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\AuthorRepository;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Author;
use App\Content\Blog\Shared\Infrastructure\Sylius\Factory\AuthorFactory;
use App\Security\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\User\AdminUser;
use App\Shared\Infrastructure\Slugger\SluggerInterface;
use Webmozart\Assert\Assert;

class AuthorCreatedProcessor
{
    public function __construct(
        private readonly AuthorFactory $authorFactory,
        private readonly AuthorRepository $authorRepository,
        private readonly SluggerInterface $slugger,
    ) {
    }

    public function process(AdminUser $administrator): void
    {
        $username = $administrator->getUsername();
        Assert::notNull($username);

        /** @var Author $author */
        $author = $this->authorFactory->createNew();
        $author->setName($username);
        $author->setSlug($this->slugger::slugify($username));

        $this->authorRepository->add($author);
    }
}
