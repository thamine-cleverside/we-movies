<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Gender as GenderResource;
use App\Entity\Gender;
use App\Repository\GenderRepository;

final class GenderProvider implements ProviderInterface
{
    public function __construct(private GenderRepository $genderRepository)
    {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|iterable|null
    {
        /** @var Gender $entity */
        $entities = $this->genderRepository->findAll();

        return array_map(fn($entity) => new GenderResource($entity->getId(), $entity->getTitle()), $entities);
    }
}
