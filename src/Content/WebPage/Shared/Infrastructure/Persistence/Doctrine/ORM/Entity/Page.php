<?php

declare(strict_types=1);

namespace App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Content\WebPage\Shared\Domain\Identifier\PageId;
use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\PageRepository;
use App\Shared\Infrastructure\Clock\Clock;
use App\UI\API\WebPage\State\Processor\Add;
use App\UI\Backend\Routes;
use App\UI\Backend\WebPage\Controller\ReadPage\Action;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Annotation\SyliusCrudRoutes;
use Sylius\Component\Resource\Annotation\SyliusRoute;
use Sylius\Component\Resource\Model\ResourceInterface;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Table(name: 'webpage_page')]
#[SyliusCrudRoutes(
    alias: 'app.webpage_page',
    path: '/admin/webpage/page',
    section: 'backend',
    redirect: 'index',
    templates: 'backend/crud/',
    grid: 'app_backend_webpage',
    except: ['show'],
    vars: [
        'all' => [
            'templates' => [
                'form' => 'backend/page/_form.html.twig',
            ],
            'icon' => 'users',
            'subheader' => 'backend.webpage.ui.page.subheader',
        ],
        'index' => [
            'header' => 'backend.webpage.ui.page.index.title',
        ],
        'create' => [
            'header' => 'backend.webpage.ui.page.create.title',
        ],
        'update' => [
            'header' => 'backend.webpage.ui.page.update.title',
        ],
    ],
)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Put(),
        new Post(
            input: Add\Payload::class,
            processor: Add\Processor::class,
        ),
        new Patch(),
        new Delete(),
    ],
)]
#[SyliusRoute(
    name: Routes::BACKEND_WEBPAGE_PAGE_SHOW['name'],
    path: Routes::BACKEND_WEBPAGE_PAGE_SHOW['path'],
    methods: ['GET'],
    controller: Action::class,
    template: 'backend/page/show.html.twig',
)]
class Page implements ResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: Types::GUID)]
    private string $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $publicationDate;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    public function __construct(PageId $id)
    {
        $this->id = $id->getValue();
        $this->publicationDate = (new Clock())->now();
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
