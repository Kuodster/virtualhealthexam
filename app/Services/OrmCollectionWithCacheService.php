<?php
declare(strict_types=1);

namespace App\Services;


use App\Traits\WithCollectionCaching;

class OrmCollectionWithCacheService extends OrmCollectionService
{
    use WithCollectionCaching;
}