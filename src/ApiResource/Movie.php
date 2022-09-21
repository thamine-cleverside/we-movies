<?php declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Filter\MovieFilter;
use App\State\MoviesProvider;

#[ApiResource(
    operations: [
        new GetCollection(provider: MoviesProvider::class)
    ]
)]
#[ApiFilter(MovieFilter::class)]
final class Movie
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $year,
        public string $genders,
        public float $ratingAverage,
        public int $ratingNumber,
        public string $cover,
        public ?string $trailer,
    ) {}
}
