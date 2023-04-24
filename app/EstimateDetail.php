<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimateDetail extends Model
{
    public function partyInfo(){
        return $this->belongsTo(PartyInfo::class, 'customer_id');
    }
}
