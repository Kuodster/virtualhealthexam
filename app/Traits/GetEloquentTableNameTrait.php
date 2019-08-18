<?php

declare(strict_types=1);

namespace App\Traits;

/*
 * Eloquent doesn't have a static function to get table name by default
 */

trait GetEloquentTableNameTrait
{
    public static function getTableName(): string
    {
        return (new self)->getTable();
    }
}