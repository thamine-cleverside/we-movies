<?php declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\State\GenderProvider;

#[ApiResource(
    operations: [
        new GetCollection(provider: GenderProvider::class)
    ]
)]
final class Gender
{
    public function __construct(public int $id, public string $title)
    {}
}
