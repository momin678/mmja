<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucher extends Model
{
    public function partInfo(){
        return $this->belongsTo(PartyInfo::class, 'supplier_id');
    }
}
