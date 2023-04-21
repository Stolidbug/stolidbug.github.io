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
use App\Content\Blog\Shared\Domain\Identifier\AuthorId;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\AuthorRepository;
use App\UI\API\Blog\Author\State\Processor\Add;
use App\UI\Backend\Blog\Controller\ReadAuthor\Action;
use App\UI\Backend\Routes;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Annotation\SyliusCrudRoutes;
use Sylius\Component\Resource\Annotation\SyliusRoute;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
#[ORM\Table(name: 'blog_author')]
#[UniqueEntity('slug')]
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
    alias: 'app.blog_author',
    path: '/admin/blog/author',
    section: 'backend',
    redirect: 'index',
    templates: 'backend/crud',
    grid: 'app_backend_blog_author',
    except: ['show'],
    vars: [
        'all' => [
            'icon' => 'users',
            'subheader' => 'backend.blog.ui.author.subheader',
            'templates' => [
                'form' => 'backend/blog/author/_form.html.twig',
            ],
        ],
        'index' => [
            'header' => 'backend.blog.ui.author.index.title',
        ],
        'create' => [
            'header' => 'backend.blog.ui.author.create.title',
        ],
        'update' => [
            'header' => 'backend.blog.ui.author.update.title',
        ],
    ],
)]
#[SyliusRoute(
    name: Routes::BACKEND_BLOG_AUTHOR_SHOW['name'],
    path: Routes::BACKEND_BLOG_AUTHOR_SHOW['path'],
    methods: ['GET'],
    controller: Action::class,
    template: 'backend/blog/author/show.html.twig',
)]
class Author implements ResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: Types::GUID)]
    private string $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'authors')]
    private Collection $articles;

    public function __construct(AuthorId $id)
    {
        $this->id = $id->getValue();
        $this->articles = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name ?? '';
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->addAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            $article->removeAuthor($this);
        }

        return $this;
    }
}
