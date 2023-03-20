<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    public function projectInfo(){
        return $this->belongsTo(ProjectDetail::class, 'project_id');
    }
    public function partInfo(){
        return $this->belongsTo(PartyInfo::class, 'supplier_id');
    }
    public function notification(){
        return $this->belongsTo(Notification::class, 'purchase_id')->where('state', "PT Editor");
    }
}
