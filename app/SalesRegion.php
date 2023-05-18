<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesRegion extends Model
{
    protected $table = 'sales_regions';

    public function sales_count(){
        
        $all= $this->hasMany(Invoice::class, 'sales_region_id')->get();
        return $all->count();
    }

    public function sales_amount(){
        $all= $this->hasMany(Invoice::class, 'sales_region_id')->get();
        return $all->sum('total_amount');
    }

    public function sales_with_tax(){
        $all= $this->hasMany(Invoice::class, 'sales_region_id')->get();
        return $all->sum('grand_total');
    }
}
