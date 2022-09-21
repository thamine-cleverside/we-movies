<?php declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Api\FilterInterface;

final class MovieFilter implements FilterInterface
{

    public function getDescription(string $resourceClass): array
    {
        return [
            'gender[]' => [
                'property' => 'type',
                'type' => 'array',
                'required' => false,
                'is_collection' => true,
            ],
        ];
    }
}
