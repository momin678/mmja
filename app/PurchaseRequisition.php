<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequisition extends Model
{
    public function partInfo(){
        return $this->belongsTo(PartyInfo::class, 'supplier_id');
    }
    public function projectInfo(){
        return $this->belongsTo(ProjectDetail::class, 'project_id');
    }
    public function payMode(){
        return $this->belongsTo(PayMode::class, 'pay_mode');
    }
    public function payTerm(){
        return $this->belongsTo(PayTerm::class, 'pay_term');
    }
    public function pr_info(){
        return $this->hasOne(Purchase::class, "pr_id");
    }
}
