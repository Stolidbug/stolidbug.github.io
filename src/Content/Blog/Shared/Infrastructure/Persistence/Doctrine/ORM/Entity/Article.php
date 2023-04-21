<?php

declare(strict_types=1);

namespace App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Content\Blog\Shared\Domain\Identifier\ArticleId;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\ArticleRepository;
use App\Shared\Infrastructure\Clock\Clock;
use App\UI\API\Blog\Article\State\Processor\Add;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Annotation\SyliusCrudRoutes;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[UniqueEntity('slug')]
#[ORM\Table(name: 'blog_article')]
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
#[SyliusCrudRoutes(
    alias: 'app.blog_article',
    path: '/admin/blog/article',
    section: 'backend',
    redirect: 'index',
    templates: 'backend/crud',
    grid: 'app_backend_blog_article',
    except: ['show'],
    vars: [
        'all' => [
            'icon' => 'users',
            'subheader' => 'backend.blog.ui.article.subheader',
            'templates' => [
                'form' => 'backend/blog/article/_form.html.twig',
            ],
        ],
        'index' => [
            'header' => 'backend.blog.ui.article.index.title',
        ],
        'create' => [
            'header' => 'backend.blog.ui.article.create.title',
        ],
        'update' => [
            'header' => 'backend.blog.ui.article.update.title',
        ],
    ],
)]
class Article implements ResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: Types::GUID)]
    private string $id;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'articles')]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'articles')]
    private Collection $authors;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct(ArticleId $id)
    {
        $this->id = $id->getValue();
        $this->createdAt = (new Clock())->now();
        $this->categories = new ArrayCollection();
        $this->authors = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        $this->authors->removeElement($author);

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $imageFilename): self
    {
        $this->image = $imageFilename;

        return $this;
    }
}
