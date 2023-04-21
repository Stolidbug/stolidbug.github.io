<?php

declare(strict_types=1);

namespace App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\ResourceRepositoryTrait;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class AuthorRepository extends ServiceEntityRepository implements RepositoryInterface
{
    use ResourceRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function anonymizingAuthor(string $newName, string $oldName, string $newSlug): void
    {
        $this->createQueryBuilder('author')
            ->update()
            ->set('author.name', ':newName')
            ->set('author.slug', ':newSlug')
            ->where('author.name = :oldName')
            ->setParameters([
                'newName' => $newName,
                'newSlug' => $newSlug,
                'oldName' => $oldName,
            ])
            ->getQuery()
            ->execute()
        ;
    }
}
