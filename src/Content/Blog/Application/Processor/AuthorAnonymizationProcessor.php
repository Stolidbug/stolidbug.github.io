<?php

declare(strict_types=1);

namespace App\Content\Blog\Application\Processor;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\AuthorRepository;
use App\Security\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\User\AdminUser;
use App\Shared\Infrastructure\Generator\UuidGenerator;

class AuthorAnonymizationProcessor
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
    ) {
    }

    public function process(AdminUser $administrator): void
    {
        $newName = 'Anon';
        $newSlug = 'anon-' . UuidGenerator::generate();
        $oldName = $administrator->getUsername();

        if ($oldName === null) {
            return;
        }

        $this->authorRepository->anonymizingAuthor(
            $newName,
            $oldName,
            $newSlug,
        );
    }
}
