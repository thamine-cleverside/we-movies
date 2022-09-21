<?php declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Movie as MovieResource;
use App\Repository\MovieRepository;

final class MoviesProvider implements ProviderInterface
{
    private const ITEM_PER_PAGE = 20;

    public function __construct(private MovieRepository $movieRepository)
    {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|iterable|null
    {
        $filters = $context['filters'] ?? [];

        $gender = $filters['gender'] ?? [];

        $currentPage = $filters['page'] ?? 1;

        $result = $this->movieRepository->getMoviesForPagination((int)$currentPage, self::ITEM_PER_PAGE, $gender);

        return new MoviesPaginator(
            array_map(
                fn(array $entity) => new MovieResource(
                    $entity['id'],
                    $entity['title'],
                    $entity['description'],
                    \DateTimeImmutable::createFromFormat('Y-m-d', $entity['year'])->format('Y'),
                    $entity['genders'],
                    (float)$entity['rating_average'],
                    (int)$entity['rating_number'],
                    $entity['cover'],
                    $entity['trailer'],
                ),
                $result['items']
            ),
            (int)$currentPage,
            $result['totalItems'],
            self::ITEM_PER_PAGE,
            $result['lastPage']
        );
    }
}
