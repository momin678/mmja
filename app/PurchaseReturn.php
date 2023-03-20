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
    public function returnAmount($return_no, $purchase_no){
        $items = PurchaseReturnDetail::where('purchase_return_no', $return_no)->get();
        $totalAmount=0;
        foreach($items as $item){
            $po_item = PurchaseDetail::where('purchase_no', $purchase_no)->first();
            $vat = VatRate::find($po_item->vat_rate);
            $amount = $po_item->purchase_rate*$item->return_qty;
            $vatAmount = ($amount*$vat->value)/100;
            $totalAmount += $vatAmount+$amount;
        }
        return $totalAmount;
    }
}
