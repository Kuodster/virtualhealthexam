<?php
declare(strict_types=1);

namespace App\Services;


use App\Interfaces\CollectionRepositoryInterface;
use App\Helpers\Sort;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Pagination\Paginator;

abstract class BaseCollectionService implements CollectionRepositoryInterface
{
    const DEFAULT_LIMIT = 50;

    /* @var $query \Illuminate\Database\Eloquent\Builder */
    protected $query;

    /* @var $paginator Paginator */
    protected $paginator;

    /* @var $sort Sort */
    protected $sort;

    protected abstract function setQuery(): void;

    public function __construct()
    {
        // Prepare initial query
        $this->setQuery();
        // Set allowed sort fields
        $this->sort = new Sort($this->getAllowedSortFields());
    }

    protected function getAllowedSortFields(): array
    {
        return [];
    }

    public function setSort(string $column = null, string $order = null): void
    {
        if ($this->sort->set($column, $order)) {
            $this->query->orderBy($column, $order);
        }
    }

    public function getSort(): Sort
    {
        return $this->sort;
    }

    // Get data to display
    public function getData(): array
    {
        return $this->prepareData();
    }

    public function getPaginator(): Paginator
    {
        return $this->paginator;
    }

    protected function paginateItems(): PaginatorContract
    {
        // Call Laravel's base pagination on the query object and return the paginator
        return $this->query->simplePaginate(self::DEFAULT_LIMIT);
    }

    // Execute the query and process the data
    protected function prepareData(): array
    {
        $this->paginator = $this->paginateItems();
        $data = $this->normalizeData($this->paginator->items());

        return $data;
    }

    // Do additional data processing if needed
    protected function normalizeData(array $items): array
    {
        return $items;
    }
}