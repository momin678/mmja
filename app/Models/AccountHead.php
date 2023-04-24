<?php

namespace App\Models;

use App\AccountType;
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

    public function accType(){
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    public function acAmountCalculate(){
        return $this->hasMany(JournalRecord::class, 'account_head_id')->where('transaction_type', 'DR');
    }
}
