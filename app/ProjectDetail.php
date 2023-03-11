<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectDetail extends Model
{
    use  SoftDeletes;

    protected $guarded=[];



    public function profitCenter($profit_pc_code)
    {
        $profiteCenter=ProfitCenter::where('pc_code',$profit_pc_code)->first();
        return $profiteCenter;
    }

    public function purchasess()
    {
        return $this->hasMany(Purchase::class, 'project_id');
    }


    public function purchase($id,$itm)
    {
        $count=0;
        $project=ProjectDetail::where('id',$id)->first();
        $pPurchase=$project->purchasess;
        foreach($pPurchase as $purch)
        {
           $ind_count=$purch->itemStock($itm);
           $count=$count+$ind_count;
        }
        return $count;
    }



    public function invoicess()
    {
        return $this->hasMany(Invoice::class, 'project_id');
    }


    public function invoice($id,$itm)
    {
        $count=0;
        $project=ProjectDetail::where('id',$id)->first();
        $pInvoice=$project->invoicess;
        foreach($pInvoice as $invoice)
        {
           $ind_count=$invoice->itemStock($itm);
           $count=$count+$ind_count;
        }
        return $count;
    }

    public function stockCheck($id, $itm)
    {
        $total_purchase=$this->purchase($id, $itm);
        $total_sell=$this->invoice($id,$itm);
        return $total_purchase - $total_sell;
    }
}
