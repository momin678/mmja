<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryNoteSale extends Model
{
    public function deliveryNote()
    {
        return $this->belongsTo(DeliveryNote::class, 'delivery_note_id');
    }
    public function saleOrder()
    {
        return $this->belongsTo(SaleOrder::class,'sale_order_id');

    }
}
