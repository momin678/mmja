<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{
    public function deliverySale()
    {
        return $this->hasOne(DeliveryNoteSale::class,'delivery_note_id');
    }

    public function deliveryItem($dn,$item)
    {
        dd($dn,$item);
    }

    public function DInvoice()
    {
        return $this->hasOne(Invoice::class,'delivery_note_id');
    }


}
