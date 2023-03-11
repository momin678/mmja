<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceTemp extends Model
{
    //
     public function quantity()
    {
        return $this->hasMany(InvoiceItemTemp::class,'invoice_no','invoice_no')->sum('quantity');
    }
}
