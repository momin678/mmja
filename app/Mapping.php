<?php

namespace App;

use App\Models\AccountHead;
use Illuminate\Database\Eloquent\Model;

class Mapping extends Model
{
    protected $fillable = ['fld_txn_type', 'fld_txn_mode', 'fld_ac_code', 'fld_ac_name'];
    public function accountHead(){
        return $this->belongsTo(AccountHead::class, 'fld_ac_name');
    }
}
