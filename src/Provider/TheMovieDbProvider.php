<?php declare(strict_types=1);

namespace App\Provider;

use App\ApiResource\Gender;
use App\ApiResource\Gender as GenderResource;
use App\State\MoviesPaginator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class TheMovieDbProvider implements MovieProvider
{
    private const POPULAR_MOVIES_URL = '/3/movie/popular';
    private const GENDER_LIST_URL = '/3/genre/movie/list';
    private const ITEM_PER_PAGE = 20;

    public function __construct(
        private HttpClientInterface $theMovieDbClient,
        private TheMovieDbMapper  $theMovieDbMapper
    ) {}

    public function getPaginatedMovies(int $page, array $genders = []): MoviesPaginator
    {
        $response = $this->theMovieDbClient->request('GET', self::POPULAR_MOVIES_URL, [
            'query' => ['page' => $page]
        ]);

        $data = $response->toArray();

        return new MoviesPaginator(
            array_map(fn(array $item) => $this->theMovieDbMapper->toResource($item), $data['results']),
            $data['page'],
            $data['total_results'],
            self::ITEM_PER_PAGE,
            $data['total_pages'],
        );
    }

    /**
     * @return array<GenderResource>
     */
    public function getGenders(): array
    {
        $response = $this->theMovieDbClient->request(
            'GET',
            self::GENDER_LIST_URL
        );

        $data = $response->toArray()['genres'];

        return array_map(fn(array $item) => new Gender($item['id'], $item['name']), $data);
    }
}
