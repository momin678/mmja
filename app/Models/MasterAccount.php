<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterAccount extends Model
{
    use  SoftDeletes;
    public function accType()
    {
        return $this->belongsTo('App\Models\MstACType', 'mst_ac_type');

    }


}
