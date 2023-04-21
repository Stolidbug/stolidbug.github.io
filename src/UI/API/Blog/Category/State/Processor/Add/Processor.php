<?php

declare(strict_types=1);

namespace App\UI\API\Blog\Category\State\Processor\Add;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\CategoryRepository;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Category;
use App\Content\Blog\Shared\Infrastructure\Sylius\Factory\CategoryFactory;
use Webmozart\Assert\Assert;

final class Processor implements ProcessorInterface
{
    public function __construct(
        private readonly CategoryFactory $categoryFactory,
        private readonly CategoryRepository $categoryRepository,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, Payload::class);

        Assert::notNull($data->getName());
        Assert::notNull($data->getSlug());

        /** @var Category $category */
        $category = $this->categoryFactory->createNew();
        $category->setName($data->getName());
        $category->setSlug($data->getslug());

        $this->categoryRepository->add($category);

        return $category;
    }
}
