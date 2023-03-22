<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
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
    public function prInfo(){
        return $this->belongsTo(PurchaseRequisition::class, 'pr_id');
    }
    public function purchase_details(){
        return $this->hasMany(PurchaseDetail::class, 'purchase_no', 'purchase_no');
    }
    public function gr_details(){
        return $this->hasOne(GoodsReceived::class, "po_no", 'purchase_no');
    }
    public function gr_details_check($po_no){
        $gr_list = GoodsReceived::where("po_no", $po_no)->where("status", 1)->get();
        $total_qty = 0;
        foreach($gr_list as $gr_no){
            $gr_qty = GoodsReceivedDetails::where('goods_received_no', $gr_no->goods_received_no)->sum('received_qty');
            $total_qty += $gr_qty;
        }
        return $total_qty;
    }
    //  work by tarek
    public function stocks()
    {
        return $this->hasMany(StockTransection::class, 'transection_id');
    }
    public function itemStock($itm)
    {
        // return $itm;
        return $this->hasMany(StockTransection::class, 'transection_id')->where('item_id',$itm)->where('stock_effect',1)->sum('quantity');
    }
    public function paid_amount(){
        return $this->hasMany(PaymentVoucher::class, 'po_no', 'purchase_no');
    }
}
