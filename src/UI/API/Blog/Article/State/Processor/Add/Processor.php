<?php

declare(strict_types=1);

namespace App\UI\API\Blog\Article\State\Processor\Add;

use ApiPlatform\Api\IriConverterInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\ArticleRepository;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Author;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Category;
use App\Content\Blog\Shared\Infrastructure\Sylius\Factory\ArticleFactory;
use Webmozart\Assert\Assert;

final class Processor implements ProcessorInterface
{
    public function __construct(
        private readonly ArticleFactory $articleFactory,
        private readonly ArticleRepository $articleRepository,
        private readonly IriConverterInterface $iriConverter,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, Payload::class);

        Assert::notNull($data->getTitle());
        Assert::notNull($data->getContent());
        Assert::notNull($data->getSlug());
        Assert::notNull($data->getCategories());
        Assert::notNull($data->getAuthors());

        /** @var Article $article */
        $article = $this->articleFactory->createNew();
        $article->setTitle($data->getTitle());
        $article->setContent($data->getContent());
        $article->setSlug($data->getSlug());
        $article->setImage($data->getImage());

        foreach ($data->getCategories() as $category) {
            /** @var Category $categoryEntity */
            $categoryEntity = $this->iriConverter->getResourceFromIri($category);
            $article->addCategory($categoryEntity);
        }

        foreach ($data->getAuthors() as $author) {
            /** @var Author $authorEntity */
            $authorEntity = $this->iriConverter->getResourceFromIri($author);
            $article->addAuthor($authorEntity);
        }

        $this->articleRepository->add($article);

        return $article;
    }
}
