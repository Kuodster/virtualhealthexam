<?php
declare(strict_types=1);

namespace App\Interfaces;


use App\Helpers\Sort;
use Illuminate\Pagination\Paginator;

interface CollectionRepositoryInterface
{
    public function getData(): array;

    public function setSort(string $column, string $order): void;

    public function getSort(): Sort;

    public function getPaginator(): Paginator;
}