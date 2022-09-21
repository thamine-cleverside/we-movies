<?php declare(strict_types=1);

namespace App\Provider;

use App\ApiResource\Movie;

final class TheMovieDbMapper
{
    public function __construct(private $theMovieDbMediasUri)
    {
    }

    public function toResource(array $data): Movie
    {
        return new Movie(
            $data['id'],
            $data['title'],
            $data['overview'],
            \DateTimeImmutable::createFromFormat('Y-m-d', $data['release_date'])->format('Y'),
            '',
            $data['vote_average'],
            $data['vote_count'],
            sprintf('%s%s',$this->theMovieDbMediasUri, $data['poster_path']),
            null,
        );
    }
}
