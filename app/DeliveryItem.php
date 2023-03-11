<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryItem extends Model
{
    public function saleItem()
    {
        return $this->belongsTo(SaleOrderItem::class,'sale_order_item_id');
    }
}
