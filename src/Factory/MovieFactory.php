<?php

namespace App\Factory;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Movie>
 *
 * @method static Movie|Proxy createOne(array $attributes = [])
 * @method static Movie[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Movie|Proxy find(object|array|mixed $criteria)
 * @method static Movie|Proxy findOrCreate(array $attributes)
 * @method static Movie|Proxy first(string $sortedField = 'id')
 * @method static Movie|Proxy last(string $sortedField = 'id')
 * @method static Movie|Proxy random(array $attributes = [])
 * @method static Movie|Proxy randomOrCreate(array $attributes = [])
 * @method static Movie[]|Proxy[] all()
 * @method static Movie[]|Proxy[] findBy(array $attributes)
 * @method static Movie[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Movie[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static MovieRepository|RepositoryProxy repository()
 * @method Movie|Proxy create(array|callable $attributes = [])
 */
final class MovieFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }



    protected function getDefaults(): array
    {
        return [
            'title' => self::faker()->text(40),
            'year' => self::faker()->dateTime(),
            'description' => self::faker()->realText(),
            'cover' => self::faker()->imageUrl(480, 640),
            'trailer' => 'http://techslides.com/demos/sample-videos/small.mp4',
            'rating' => self::generateRating(self::faker()->numberBetween(2, 950)),
            'producer' => [],
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Movie $movie): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Movie::class;
    }

    private static function generateRating(int $number): array
    {
        $ratings = [];

        for ($index = 0; $index < $number; $index++) {
            $ratings[$index]['stars'] = self::faker()->numberBetween(0, 5);
        }

        return $ratings;
    }
}
