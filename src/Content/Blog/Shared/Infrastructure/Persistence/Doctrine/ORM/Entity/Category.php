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
use App\Content\Blog\Shared\Domain\Identifier\CategoryId;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\CategoryRepository;
use App\UI\API\Blog\Category\State\Processor\Add;
use App\UI\Backend\Blog\Controller\ReadCategory\Action;
use App\UI\Backend\Routes;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Annotation\SyliusCrudRoutes;
use Sylius\Component\Resource\Annotation\SyliusRoute;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'blog_category')]
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
    alias: 'app.blog_category',
    path: '/admin/blog/category',
    section: 'backend',
    redirect: 'index',
    templates: 'backend/crud',
    grid: 'app_backend_blog_category',
    except: ['show'],
    vars: [
        'all' => [
            'icon' => 'users',
            'subheader' => 'backend.blog.ui.category.subheader',
            'templates' => [
                'form' => 'backend/blog/category/_form.html.twig',
            ],
        ],
        'index' => [
            'header' => 'backend.blog.ui.category.index.title',
        ],
        'create' => [
            'header' => 'backend.blog.ui.category.create.title',
        ],
        'update' => [
            'header' => 'backend.blog.ui.category.update.title',
        ],
    ],
)]
#[SyliusRoute(
    name: Routes::BACKEND_BLOG_CATEGORY_SHOW['name'],
    path: Routes::BACKEND_BLOG_CATEGORY_SHOW['path'],
    methods: ['GET'],
    controller: Action::class,
    template: 'backend/blog/category/show.html.twig',
)]
class Category implements ResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: Types::GUID)]
    private string $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'categories')]
    private Collection $articles;

    public function __construct(CategoryId $id)
    {
        $this->id = $id->getValue();
        $this->articles = new ArrayCollection();
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

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->addCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            $article->removeCategory($this);
        }

        return $this;
    }
}
