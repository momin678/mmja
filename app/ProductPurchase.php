<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    public function projectName(){
        return $this->belongsTo(ProjectDetail::class, 'project_id');
    }
}
