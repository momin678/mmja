<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchseDetailTemp extends Model
{
    public function itemName(){
        return $this->belongsTo(ItemList::class, 'item_id');
    }
    public function brandName(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function groupName(){
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function vatRate(){
        return $this->belongsTo(VatRate::class, 'vat_rate');
    }
}
