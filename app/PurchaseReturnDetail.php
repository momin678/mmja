<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetail extends Model
{
    public function itemName(){
        return $this->belongsTo(ItemList::class, "item_id");
    }
}
