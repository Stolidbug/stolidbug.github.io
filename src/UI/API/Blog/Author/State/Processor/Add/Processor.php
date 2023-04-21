<?php

declare(strict_types=1);

namespace App\UI\API\Blog\Author\State\Processor\Add;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\AuthorRepository;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Author;
use App\Content\Blog\Shared\Infrastructure\Sylius\Factory\AuthorFactory;
use Webmozart\Assert\Assert;

final class Processor implements ProcessorInterface
{
    public function __construct(
        private readonly AuthorFactory $authorFactory,
        private readonly AuthorRepository $authorRepository,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, Payload::class);

        Assert::notNull($data->getName());
        Assert::notNull($data->getSlug());

        /** @var Author $author */
        $author = $this->authorFactory->createNew();
        $author->setName($data->getName());
        $author->setSlug($data->getSlug());

        $this->authorRepository->add($author);

        return $author;
    }
}
