<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Provider\MovieProvider;

final class GenderProvider implements ProviderInterface
{
    public function __construct(private MovieProvider $movieProvider)
    {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|iterable|null
    {
        return $this->movieProvider->getGenders();
    }
}
