<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfitCenter extends Model
{
    use  SoftDeletes;


    public function projects($pc_code)
    {
       $pj=ProjectDetail::where('pc_code',$pc_code)->get();
       return $pj;
    }
}
