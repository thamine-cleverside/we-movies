<?php declare(strict_types=1);

namespace App\Provider;

use App\ApiResource\Movie;
use App\ApiResource\Movie as MovieResource;

final class DbMapper
{
    public function movieFromDb(array $data): Movie
    {
        return new MovieResource(
            $data['id'],
            $data['title'],
            $data['description'],
            \DateTimeImmutable::createFromFormat('Y-m-d', $data['year'])->format('Y'),
            $data['genders'],
            (float)$data['rating_average'],
            (int)$data['rating_number'],
            $data['cover'],
            $data['trailer'],
        );
    }
}
