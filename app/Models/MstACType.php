<?php

namespace App\Models;

use App\MstCatType;
use Illuminate\Database\Eloquent\Model;

class MstACType extends Model
{
    public function category()
    {
        return $this->belongsTo('App\MstCatType', 'cat_type');

    }
}
