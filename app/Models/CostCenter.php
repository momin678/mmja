<?php

namespace App\Models;

use App\Journal;
use App\JournalTemp;
use App\ProjectDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostCenter extends Model
{
    use  SoftDeletes;

    public function project()
    {
        return $this->belongsTo(ProjectDetail::class, 'project_id');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class,'cost_center_id');
    }

    public function tempJournal(){
        $all= $this->hasMany(JournalTemp::class, 'project_id')->get();
        return $all->count();
    }

    public function journalCount(){
        $all= $this->hasMany(Journal::class, 'project_id')->get();
        return $all->count();
    }

}
