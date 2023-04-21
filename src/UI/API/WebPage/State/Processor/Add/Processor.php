<?php

declare(strict_types=1);

namespace App\UI\API\WebPage\State\Processor\Add;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Page;
use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\PageRepository;
use App\Content\WebPage\Shared\Infrastructure\Sylius\Factory\PageFactory;
use Webmozart\Assert\Assert;

final class Processor implements ProcessorInterface
{
    public function __construct(
        private readonly PageFactory $pageFactory,
        private readonly PageRepository $pageRepository,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, Payload::class);

        Assert::notNull($data->getName());
        Assert::notNull($data->getContent());
        Assert::notNull($data->getAuthor());
        Assert::notNull($data->getStatus());
        Assert::notNull($data->getSlug());

        /** @var Page $page */
        $page = $this->pageFactory->createNew();
        $page->setName($data->getName());
        $page->setContent($data->getContent());
        $page->setAuthor($data->getAuthor());
        $page->setStatus($data->getStatus());
        $page->setSlug($data->getSlug());

        $this->pageRepository->add($page);

        return $page;
    }
}
