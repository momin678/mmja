<?php

namespace App;

use App\Models\MstACType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MstCatType extends Model
{
    use  SoftDeletes;

    public function hasTypes()
    {
        return $this->hasMany(MstACType::class, 'cat_type');

    }

}
