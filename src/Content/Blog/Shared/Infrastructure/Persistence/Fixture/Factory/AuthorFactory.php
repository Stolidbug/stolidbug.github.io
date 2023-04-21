<?php

declare(strict_types=1);

namespace App\Content\Blog\Shared\Infrastructure\Persistence\Fixture\Factory;

use App\Content\Blog\Shared\Infrastructure\Identity\AuthorIdGenerator;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\AuthorRepository;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Author;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<\App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Author>
 *
 * @method Author|Proxy create(array|callable $attributes = [])
 * @method static Author|Proxy createOne(array $attributes = [])
 * @method static Author|Proxy find(object|array|mixed $criteria)
 * @method static Author|Proxy findOrCreate(array $attributes)
 * @method static Author|Proxy first(string $sortedField = 'id')
 * @method static Author|Proxy last(string $sortedField = 'id')
 * @method static Author|Proxy random(array $attributes = [])
 * @method static Author|Proxy randomOrCreate(array $attributes = [])
 * @method static AuthorRepository|RepositoryProxy repository()
 * @method static Author[]|Proxy[] all()
 * @method static Author[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Author[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Author[]|Proxy[] findBy(array $attributes)
 * @method static Author[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Author[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 */
final class AuthorFactory extends ModelFactory
{
    public function __construct(
        private readonly AuthorIdGenerator $generator,
    ) {
        parent::__construct();
    }

    public function withName(string $name): self
    {
        return $this->addState(['name' => $name]);
    }

    public function withTitle(string $title): self
    {
        return $this->addState(['title' => $title]);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'id' => $this->generator->nextIdentity(),
            'name' => self::faker()->name(),
            'slug' => self::faker()->slug(),
        ];
    }

    protected static function getClass(): string
    {
        return Author::class;
    }
}
