<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartyInfo extends Model
{
    use  SoftDeletes;

    public function journals()
    {
        return $this->hasMany(Journal::class,'party_info_id');
    }
    public function purchase(){
        return $this->hasMany(Purchase::class, 'supplier_id');
    }
    public function paidAmount(){
        return $this->hasMany(PaymentVoucher::class, 'supplier_id');
    }
}
