<?php

namespace App\Models;

use App\JournalRecord;
use Illuminate\Database\Eloquent\Model;

class AccountHead extends Model
{
    public function masterAccount(){
        return $this->belongsTo(MasterAccount::class, 'master_account_id');
    }
    public function acAmount(){
        return $this->hasMany(JournalRecord::class, 'account_head_id');
    }
}
