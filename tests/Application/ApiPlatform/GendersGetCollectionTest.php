<?php

namespace App\Tests\Application\ApiPlatform;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Provider\MovieProvider;
use App\Provider\TheMovieDbMapper;
use App\Provider\TheMovieDbProvider;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Zenstruck\Foundry\Test\ResetDatabase;

class GendersGetCollectionTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldGetAllGenders(): void
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

        $response = $client->request('GET', 'api/genders');
        $data = $response->toArray();

        self::assertResponseIsSuccessful();

        self::assertEquals(4, $data['hydra:totalItems']);
        self::assertCount(4, $data['hydra:member']);
        self::assertArraySubset(['id' => 28, 'title' => 'Action'], $data['hydra:member'][0]);
        self::assertArraySubset(['id' => 12, 'title' => 'Adventure'], $data['hydra:member'][1]);
        self::assertArraySubset(['id' => 16, 'title' => 'Animation'], $data['hydra:member'][2]);
        self::assertArraySubset(['id' => 35, 'title' => 'Comedy'], $data['hydra:member'][3]);
    }

    private function getProviderResponse(): string
    {
        return json_encode([
            "genres" => [
                [
                    "id" => 28,
                    "name" => "Action",
                ],
                [
                    "id" => 12,
                    "name" => "Adventure",
                ],
                [
                    "id" => 16,
                    "name" => "Animation",
                ],
                [
                    "id" => 35,
                    "name" => "Comedy",
                ],
            ],
        ]);
    }
}
