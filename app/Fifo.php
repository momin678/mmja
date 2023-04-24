<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fifo extends Model
{
    //
    protected $fillable=['unit_cost_price'];

    public function purchase_info(){
        return $this->belongsTo(Purchase::class,'purchase_id');
    }

    public function item_info(){
        return $this->belongsTo(ItemList::class,'item_id');
    }

    public function getTotalAmountAttribute(){
        return $this->quantity*$this->unit_cost_price;
    }
}
