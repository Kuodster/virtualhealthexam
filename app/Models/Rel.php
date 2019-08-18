<?php

namespace App\Models;

use App\Traits\GetEloquentTableNameTrait;
use Illuminate\Database\Eloquent\Model;

class Rel extends Model
{
    use GetEloquentTableNameTrait;

    protected $table = 'rel';

    // Source relation
    public function source()
    {
        return $this->hasMany('App\Models\Source', 'cx', 'cx');
    }
}
