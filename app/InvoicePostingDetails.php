<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoicePostingDetails extends Model
{
    public function itemName(){
        return $this->belongsTo(ItemList::class, "item_id");
    }
}
