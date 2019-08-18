<?php
declare(strict_types=1);

namespace App\Helpers;


class Sort
{
    protected $column;
    protected $order;
    protected $allowedSortFields;

    public function __construct(array $allowedSortFields)
    {
        $this->allowedSortFields = $allowedSortFields;
    }

    public function isSorting(string $column): ?string
    {
        if ($this->getSortingColumn() === $column) {
            return $this->order;
        }

        return null;
    }

    public function getSortingColumn(): ?string
    {
        return $this->column;
    }

    public function hasSort(string $column): bool
    {
        return in_array($column, $this->allowedSortFields);
    }

    public function set(string $column = null, string $order = null): bool
    {
        if ($column === null) {
            return false;
        }
        $order = $order ?? 'asc';
        if ($this->hasSort($column) && in_array($order, ['asc', 'desc'])) {
            $this->column = $column;
            $this->order = $order;

            return true;
        }

        return false;
    }
}