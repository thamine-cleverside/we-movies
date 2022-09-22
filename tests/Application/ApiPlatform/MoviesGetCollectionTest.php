<?php

namespace App\Tests\Application\ApiPlatform;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Provider\MovieProvider;
use App\Provider\TheMovieDbMapper;
use App\Provider\TheMovieDbProvider;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class MoviesGetCollectionTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    /**
     * @test
     */
    public function shouldGetMovies(): void
    {
        $client = static::createClient();

        $httpClient = new MockHttpClient([
            new MockResponse($this->getProviderResponse(), ['http_code' => 200])
        ]);

        $movieProvider = new TheMovieDbProvider(
            $httpClient,
            self::getContainer()->get(TheMovieDbMapper::class)
        );

        self::getContainer()->set(MovieProvider::class, $movieProvider);

        $response = $client->request('GET', 'api/movies?page=1');
        $data = $response->toArray();

        self::assertResponseIsSuccessful();

        self::assertEquals(2, $data['hydra:totalItems']);
        self::assertCount(2, $data['hydra:member']);

        self::assertArraySubset(['id' => 810693, 'title' => 'Jujutsu Kaisen 0'], $data['hydra:member'][0]);
        self::assertArraySubset(['id' => 756999, 'title' => 'The Black Phone'], $data['hydra:member'][1]);
    }

    /**
     * @test
     */
    public function shouldGetMoviesPaginated(): void
    {
        $client = static::createClient();

        $httpClient = new MockHttpClient([
            new MockResponse($this->getProviderResponsePaginated(), ['http_code' => 200])
        ]);

        $movieProvider = new TheMovieDbProvider(
            $httpClient,
            self::getContainer()->get(TheMovieDbMapper::class)
        );

        self::getContainer()->set(MovieProvider::class, $movieProvider);

        $response = $client->request('GET', 'api/movies?page=1');
        $data = $response->toArray();

        self::assertResponseIsSuccessful();

        self::assertEquals(703478, $data['hydra:totalItems']);
        self::assertCount(20, $data['hydra:member']);

        self::assertEquals('/api/movies?page=1', $data['hydra:view']['hydra:first']);
        self::assertEquals('/api/movies?page=35174', $data['hydra:view']['hydra:last']);
        self::assertEquals('/api/movies?page=2', $data['hydra:view']['hydra:next']);
    }

    private function getProviderResponse(): string
    {
        return json_encode([
            "page" => 1,
            "total_pages" => 1,
            "total_results" => 2,
            "results" => [
                [
                    "adult" => false,
                    "backdrop_path" => "/geYUecpFI2AonDLhjyK9zoVFcMv.jpg",
                    "genre_ids" => [
                        0 => 16,
                        1 => 28,
                        2 => 14,
                    ],
                    "id" => 810693,
                    "original_language" => "ja",
                    "original_title" => "劇場版 呪術廻戦 0",
                    "overview" => "Yuta Okkotsu is a nervous high school",
                    "popularity" => 1964.522,
                    "poster_path" => "/3pTwMUEavTzVOh6yLN0aEwR7uSy.jpg",
                    "release_date" => "2021-12-24",
                    "title" => "Jujutsu Kaisen 0",
                    "video" => false,
                    "vote_average" => 7.9,
                    "vote_count" => 308,
                ],
                [
                    "adult" => false,
                    "backdrop_path" => "/AfvIjhDu9p64jKcmohS4hsPG95Q.jpg",
                    "genre_ids" => [
                    0 => 27,
                    1 => 53,
                    ],
                    "id" => 756999,
                    "original_language" => "en",
                    "original_title" => "The Black Phone",
                    "overview" => "Finney Blake, a shy but clever 1",
                    "popularity" => 1184.862,
                    "poster_path" => "/lr11mCT85T1JanlgjMuhs9nMht4.jpg",
                    "release_date" => "2022-06-22",
                    "title" => "The Black Phone",
                    "video" => false,
                    "vote_average" => 7.9,
                    "vote_count" => 2542,
                ]
            ],
        ]);
    }

    private function getProviderResponsePaginated(int $total = 20): string
    {
        $elements = [];
        for ($index = 0; $index < $total; $index++) {
            $elements[] = [
                "adult" => false,
                "backdrop_path" => "/geYUecpFI2AonDLhjyK9zoVFcMv.jpg",
                "genre_ids" => [
                    0 => 16,
                    1 => 28,
                    2 => 14,
                ],
                "id" => 810693,
                "original_language" => "ja",
                "original_title" => "劇場版 呪術廻戦 0",
                "overview" => "Yuta Okkotsu is a nervous high school",
                "popularity" => 1964.522,
                "poster_path" => "/3pTwMUEavTzVOh6yLN0aEwR7uSy.jpg",
                "release_date" => "2021-12-24",
                "title" => "Jujutsu Kaisen 0",
                "video" => false,
                "vote_average" => 7.9,
                "vote_count" => 308,
                ];
        }

        return json_encode([
            "page" => 1,
            "total_pages" => 35174,
            "total_results" => 703478,
            "results" => $elements
        ]);
    }
}
