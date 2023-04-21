<?php

declare(strict_types=1);

namespace App\Content\WebPage\Shared\Infrastructure\Persistence\Fixture\Factory;

use App\Content\WebPage\Shared\Infrastructure\Identity\PageIdGenerator;
use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Page;
use App\Content\WebPage\Shared\Infrastructure\Persistence\Doctrine\ORM\PageRepository;
use App\Content\WebPage\Shared\Infrastructure\Persistence\Page\Status;
use App\Shared\Infrastructure\Slugger\SluggerInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Page>
 *
 * @method Page|Proxy create(array|callable $attributes = [])
 * @method static Page|Proxy createOne(array $attributes = [])
 * @method static Page|Proxy find(object|array|mixed $criteria)
 * @method static Page|Proxy findOrCreate(array $attributes)
 * @method static Page|Proxy first(string $sortedField = 'id')
 * @method static Page|Proxy last(string $sortedField = 'id')
 * @method static Page|Proxy random(array $attributes = [])
 * @method static Page|Proxy randomOrCreate(array $attributes = [])
 * @method static PageRepository|RepositoryProxy repository()
 * @method static Page[]|Proxy[] all()
 * @method static Page[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Page[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Page[]|Proxy[] findBy(array $attributes)
 * @method static Page[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Page[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 */
final class PageFactory extends ModelFactory
{
    public function __construct(
        private readonly PageIdGenerator $generator,
        private readonly SluggerInterface $slugger,
    ) {
        parent::__construct();
    }

    public function withName(string $name): self
    {
        return $this->addState(['name' => $name]);
    }

    protected function getDefaults(): array
    {
        /** @var string $name */
        $name = self::faker()->words(3, true);

        return [
            'id' => $this->generator->nextIdentity(),
            'author' => self::faker()->name(),
            'name' => $name,
            'content' => self::faker()->text(),
            'status' => Status::PUBLISHED['status'],
            'slug' => $this->slugger::slugify($name),
        ];
    }

    protected static function getClass(): string
    {
        return Page::class;
    }
}
