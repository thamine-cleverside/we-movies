<?php declare(strict_types=1);

namespace App\Provider;

use App\ApiResource\Gender as GenderResource;
use App\State\MoviesPaginator;

interface MovieProvider
{
    public function getPaginatedMovies(int $page, array $genders = []): MoviesPaginator;

    /**
     * @return array<GenderResource>
     */
    public function getGenders(): array;
}
