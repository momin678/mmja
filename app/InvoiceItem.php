<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    use  SoftDeletes;

    public function item()
    {
        // return 1;
        return $this->belongsTo(ItemList::class);
    }

    public function fifoInvoiceItem($inv,$item)
    {
        $fifoInvItm=FifoInvoice::where('invoice_id',$inv)->where('item_id',$itm)->get();
        return $fifoInvItm;
    }

}
