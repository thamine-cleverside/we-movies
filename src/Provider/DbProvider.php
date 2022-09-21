<?php declare(strict_types=1);

namespace App\Provider;

use App\ApiResource\Gender as GenderResource;
use App\Repository\GenderRepository;
use App\Repository\MovieRepository;
use App\State\MoviesPaginator;

final class DbProvider implements MovieProvider
{
    private const ITEM_PER_PAGE = 20;

    public function __construct(
        private MovieRepository $movieRepository,
        private DbMapper $dbMapper,
        private GenderRepository $genderRepository,
    ) {}

    public function getPaginatedMovies(int $page, array $genders = []): MoviesPaginator
    {
        $result = $this->movieRepository->getMoviesForPagination($page, self::ITEM_PER_PAGE, $genders);

        return new MoviesPaginator(
            array_map(fn(array $entity) => $this->dbMapper->movieFromDb($entity), $result['items']),
            $page,
            $result['totalItems'],
            self::ITEM_PER_PAGE,
            $result['lastPage']
        );
    }

    /**
     * @return array<GenderResource>
     */
    public function getGenders(): array
    {
        $result = $this->genderRepository->findAll();

        return array_map(fn($entity) => new GenderResource($entity->getId(), $entity->getTitle()), $result);
    }
}
