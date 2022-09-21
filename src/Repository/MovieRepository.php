<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Model\BestRatedMovieView;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

final class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private Connection $connection)
    {
        parent::__construct($registry, Movie::class);
    }

    public function getMoviesForPagination(int $page, int $itemByPage, array $genders = []): array
    {
        $query = sprintf(<<<'SQL'
select movie.id, movie.title, movie.description, movie.year, movie.cover, movie.trailer, 
       json_array_length(movie.rating) as rating_number,
                   COALESCE((select ROUND(AVG(CAST(elem->> 'stars' as integer)), 2)
                    from json_array_elements(movie.rating) as elem
                   ), 0) as rating_average, 
       array_agg(gender.title) as genders
            from movie
            inner join movie_gender on movie.id = movie_gender.movie_id %s
            left join gender on gender.id = movie_gender.gender_id
            group by movie.id
            order by rating_average DESC, rating_number DESC
            limit :limit
            offset :offset
SQL
            , !empty($genders) ? sprintf("and movie_gender.gender_id IN(%s)", implode(',', $genders)) : "");

        $statement = $this->connection->prepare($query);

        $statement->bindValue('limit', NULL);
        $statement->bindValue('offset', 0);
        $totalItems = $statement->executeQuery()->rowCount();

        $statement->bindValue('limit', $itemByPage);
        $statement->bindValue('offset', ($page - 1) * $itemByPage);
        $items = $statement->executeQuery()->fetchAllAssociative();

        $lastPage = (int) ceil($totalItems / $itemByPage);

        return [
            'items' => $items,
            'totalItems' => $totalItems,
            'lastPage' => $lastPage,
        ];
    }

    public function getBestRated(): ?BestRatedMovieView
    {
        $result = $this->connection->fetchAssociative("
        select movie.id, movie.title, movie.description, movie.year, movie.cover, movie.trailer, 
       json_array_length(movie.rating) as rating_number,
                   COALESCE((select ROUND(AVG(CAST(elem->> 'stars' as integer)), 2)
                    from json_array_elements(movie.rating) as elem
                   ), 0) as rating_average
            from movie
            group by movie.id
            order by rating_average DESC, rating_number DESC
            limit 1");

        if (!is_array($result)) {
            return null;
        }

        return BestRatedMovieView::fromDatabase($result);
    }
}
