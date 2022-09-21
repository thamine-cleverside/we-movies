<?php declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Provider\MovieProvider;

final class MoviesProvider implements ProviderInterface
{

    public function __construct(private MovieProvider $movieProvider)
    {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|iterable|null
    {
        $filters = $context['filters'] ?? [];

        $gender = $filters['gender'] ?? [];

        $currentPage = $filters['page'] ?? 1;

        return $this->movieProvider->getPaginatedMovies((int)$currentPage, $gender);
    }
}
