<?php

namespace App;

use App\Models\AccountHead;
use App\Models\MasterAccount;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public function master_account(){
        return $this->belongsTo(MasterAccount::class,'master_acount_id','mst_ac_code');
    }

    public function account_head(){
        return $this->belongsTo(AccountHead::class,'account_head_id');
    }

    public function party(){
        return $this->belongsTo(PartyInfo::class,'party_info_id');
    }
}
