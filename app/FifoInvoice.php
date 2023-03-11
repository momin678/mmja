<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FifoInvoice extends Model
{
    public function fifo()
    {
        return $this->belongsTo(Fifo::class,'fifo_id');
    }
}
