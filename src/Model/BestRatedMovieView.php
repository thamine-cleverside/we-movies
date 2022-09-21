<?php declare(strict_types=1);

namespace App\Model;

final class BestRatedMovieView
{
    public function __construct(
        public int $id,
        public string $title,
        public string $trailer,
        public string $cover,
        public float $ratingAverage,
        public int $ratingNumber,
    ) {
    }

    public static function fromDatabase(array $result): self
    {
        return new self(
            $result['id'],
            $result['title'],
            $result['trailer'],
            $result['cover'],
            (float)$result['rating_average'],
            $result['rating_number'],
        );
    }
}
