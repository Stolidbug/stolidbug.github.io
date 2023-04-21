<?php

declare(strict_types=1);

namespace App\Content\Blog\Shared\Infrastructure\Persistence\Fixture\Factory;

use App\Content\Blog\Shared\Infrastructure\Identity\ArticleIdGenerator;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\ArticleRepository;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Article>
 *
 * @method Article|Proxy create(array|callable $attributes = [])
 * @method static Article|Proxy createOne(array $attributes = [])
 * @method static Article|Proxy find(object|array|mixed $criteria)
 * @method static Article|Proxy findOrCreate(array $attributes)
 * @method static Article|Proxy first(string $sortedField = 'id')
 * @method static Article|Proxy last(string $sortedField = 'id')
 * @method static Article|Proxy random(array $attributes = [])
 * @method static Article|Proxy randomOrCreate(array $attributes = [])
 * @method static ArticleRepository|RepositoryProxy repository()
 * @method static Article[]|Proxy[] all()
 * @method static Article[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Article[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Article[]|Proxy[] findBy(array $attributes)
 * @method static Article[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Article[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 */
final class ArticleFactory extends ModelFactory
{
    public function __construct(
        private readonly ArticleIdGenerator $generator,
    ) {
        parent::__construct();
    }

    public function withTitle(string $title): self
    {
        return $this->addState(['title' => $title]);
    }

    protected function getDefaults(): array
    {
        return [
            'id' => $this->generator->nextIdentity(),
            'content' => self::faker()->text(255),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'slug' => self::faker()->slug(),
            'title' => self::faker()->text(10),
            'updatedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    protected static function getClass(): string
    {
        return Article::class;
    }
}
