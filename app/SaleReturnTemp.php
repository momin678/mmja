<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleReturnTemp extends Model
{
    public function item()
    {
        return $this->belongsTo(ItemList::class);
    }

    public function itemPrice($invoice,$item)
    {

        $inItem=InvoiceItem::where('invoice_no',$invoice)->where('item_id',$item)->first();

        return $inItem;
    }
}
