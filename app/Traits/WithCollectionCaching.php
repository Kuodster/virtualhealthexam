<?php
declare(strict_types=1);

namespace App\Traits;


use Illuminate\Container\Container;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

trait WithCollectionCaching
{
    protected function paginateItems(): PaginatorContract
    {
        $pageName = 'page';
        $page = Paginator::resolveCurrentPage($pageName);
        $perPage = self::DEFAULT_LIMIT;

        // Append limit/offset to query
        $this->query
            ->skip(($page - 1) * $perPage)
            ->take($perPage + 1);

        // Generate cache key to look for
        $cacheKey = md5(json_encode([$this->query->toSql(), $this->query->getBindings()]));

        $items = Cache::remember($cacheKey, 600, function () {
            return $this->query->get();
        });

        return Container::getInstance()->makeWith(Paginator::class, [
            'items' => $items,
            'perPage' => $perPage,
            'currentPage' => $page,
            'options' => [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        ]);
    }
}