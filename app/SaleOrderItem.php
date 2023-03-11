<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleOrderItem extends Model
{
    use  SoftDeletes;

    public function item()
    {
        return $this->belongsTo(ItemList::class);
    }
    public function deliverItem()
    {
        return $this->hasMany(DeliveryItem::class,'sale_order_item_id');
    }

    public function deliverQuantity()
    {
        return $this->hasMany(DeliveryItem::class,'sale_order_item_id')->sum('quantity');
    }

}
