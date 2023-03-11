<?php

namespace App;

use App\Models\AccountHead;
use App\Models\MasterAccount;
use Illuminate\Database\Eloquent\Model;

class JournalRecordsTemp extends Model
{
    public function journal(){
        return $this->belongsTo(JournalTemp::class);
    }

    public function ac_head(){
        return $this->belongsTo(AccountHead::class,'account_head_id');
    }

    public function master_ac(){
        return $this->belongsTo(MasterAccount::class,'master_account_id');
    }
}
