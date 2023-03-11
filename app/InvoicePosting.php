<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoicePosting extends Model
{
    public function projectInfo(){
        return $this->belongsTo(ProjectDetail::class, 'project_id');
    }
    public function partInfo(){
        return $this->belongsTo(PartyInfo::class, 'supplier_id');
    }
}
