<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItemTemp extends Model
{
    //

    public function item()
    {
        // return 1;
        return $this->belongsTo(ItemList::class);
    }
}
