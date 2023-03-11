<?php

namespace App;

use App\Models\AccountHead;
use App\Models\CostCenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
    use  SoftDeletes;
    public function records(){
        return $this->hasMany(JournalRecord::class);
    }
    public function project()
    {
        return $this->belongsTo(ProjectDetail::class, 'project_id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }

    public function cost_center()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }

    public function PartyInfo()
    {
        return $this->belongsTo(PartyInfo::class, 'party_info_id');
    }

    public function party()
    {
        return $this->belongsTo(PartyInfo::class, 'party_info_id');
    }

    public function accHead()
    {
        return $this->belongsTo(AccountHead::class, 'ac_head_id');
    }

    public function taxRate()
    {
        return $this->belongsTo(VatRate::class, 'tax_rate');
    }

    public function creditPartyInfo()
    {
        return $this->belongsTo(PartyInfo::class, 'credit_party_info');
    }

    public function dateJournal($date,$partyInfo)
    {
        $count=0;
        $journals=Journal::whereDate('date',$date)->where('party_info_id',$partyInfo->id)->get();
        foreach($journals as $j)
        {
            $count=$count+$j->records->count();
        }

        return $count;

    }

    // work by mominul
    public function voucher_type(){
        return $this->hasOne(DebitCreditVoucher::class,'journal_id');
    }
}
