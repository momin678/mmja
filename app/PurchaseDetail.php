<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    public function itemName(){
        return $this->belongsTo(ItemList::class, 'item_id');
    }
    public function brandName(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function groupName(){
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function vatRate(){
        return $this->belongsTo(VatRate::class, 'vat_rate');
    }
    public function receive_qrt($po_no, $item_id){
        $gr_lists = GoodsReceived::where("po_no", $po_no)->get();
        $total_receive_qty = 0;
        foreach($gr_lists as $gr){
            $item_qty = GoodsReceivedDetails::Where("goods_received_no", $gr->goods_received_no)->where("item_id", $item_id)->first();
            $total_receive_qty += $item_qty->received_qty;
        }
        return $total_receive_qty;
    }
    
     public function rcvdItem($g_no,$item_id)
    {

       $quantity=GoodsReceivedDetails::where('goods_received_no', $g_no)->where('item_id',$item_id)->sum('received_qty');
       return $quantity;
    }
}
