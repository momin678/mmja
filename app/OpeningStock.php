<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpeningStock extends Model
{
    public function item()
    {
        return $this->belongsTo('App\ItemList', 'item_id');
    }
}
