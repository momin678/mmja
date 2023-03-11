<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsReceived extends Model
{
    public function projectInfo(){
        return $this->belongsTo(ProjectDetail::class, 'project_id');
    }
    public function partInfo(){
        return $this->belongsTo(PartyInfo::class, 'supplier_id');
    }
    public function gr_qty_count(){
        return $this->hasMany(GoodsReceivedDetails::class, "goods_received_no", "goods_received_no");
    }
    public function total_gr_count(){
        // return $this->hasMany(GoodsReceived::class, "po_no", "purchase_no");
        return 100;
    }
    public function invoice_posting_check(){
        return $this->hasOne(InvoicePosting::class, "goods_received_no", "goods_received_no");
    }
    
    //work by tarek
    public function normalItemCheeck()
    {

        $po=Purchase::where('purchase_no',$this->po_no)->first();
        if(PurchaseDetail::where('purchase_no',$po->purchase_no)->where('group_id','>',10)->where('group_id','<',18)->count()>0)
        {
            return true;
        }
    }

    public function abnormalItemCheeck()
    {

        $po=Purchase::where('purchase_no',$this->po_no)->first();
        if(PurchaseDetail::where('purchase_no',$po->purchase_no)->where('group_id','>',17)->where('group_id','<',24)->count()>0)
        {
            return true;
        }
    }
}
