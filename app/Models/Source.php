<?php

namespace App\Models;

use App\Traits\GetEloquentTableNameTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class Source extends Model
{
    use GetEloquentTableNameTrait;

    protected $table = 'source';

    // Rel relation
    public function rel()
    {
        return $this->hasMany('App\Models\Rel', 'cx', 'cx');
    }
}
