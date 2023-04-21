<?php

declare(strict_types=1);

namespace App\Content\Blog\Shared\Infrastructure\Persistence\Fixture\Factory;

use App\Content\Blog\Shared\Infrastructure\Identity\CategoryIdGenerator;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\CategoryRepository;
use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Category;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Category>
 *
 * @method Category|Proxy create(array|callable $attributes = [])
 * @method static Category|Proxy createOne(array $attributes = [])
 * @method static Category|Proxy find(object|array|mixed $criteria)
 * @method static Category|Proxy findOrCreate(array $attributes)
 * @method static Category|Proxy first(string $sortedField = 'id')
 * @method static Category|Proxy last(string $sortedField = 'id')
 * @method static Category|Proxy random(array $attributes = [])
 * @method static Category|Proxy randomOrCreate(array $attributes = [])
 * @method static CategoryRepository|RepositoryProxy repository()
 * @method static Category[]|Proxy[] all()
 * @method static Category[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Category[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Category[]|Proxy[] findBy(array $attributes)
 * @method static Category[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Category[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 */
final class CategoryFactory extends ModelFactory
{
    public function __construct(
        private readonly CategoryIdGenerator $generator,
    ) {
        parent::__construct();
    }

    public function withName(string $name): self
    {
        return $this->addState(['name' => $name]);
    }

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
        return Category::class;
    }
}
