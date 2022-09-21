<?php declare(strict_types=1);

namespace App\State;

use ApiPlatform\State\Pagination\PaginatorInterface;
use Traversable;

final class MoviesPaginator implements \IteratorAggregate, PaginatorInterface
{
    public function __construct(
        private array $items,
        private int $currentPage,
        private int $totalItems,
        private int $itemsPerPage,
        private int $lastPage,
    ) {}

    public function getLastPage(): float
    {
        return $this->lastPage;
    }

    public function getTotalItems(): float
    {
        return $this->totalItems;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getCurrentPage(): float
    {
        return $this->currentPage;
    }

    public function getItemsPerPage(): float
    {
        return $this->itemsPerPage;
    }

    public function getIterator(): Traversable
    {
        yield from $this->items;
    }
}
