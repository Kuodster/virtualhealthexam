<?php
declare(strict_types=1);

namespace App\Services;


use App\Traits\WithCollectionCaching;

class QueryCollectionWithCacheService extends QueryCollectionService
{
    use WithCollectionCaching;
}