<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleOrder extends Model
{
    use  SoftDeletes;

    public function partyInfo($pi)
    {
        $pi=PartyInfo::where('pi_code',$pi)->first();
        return $pi;
    }

    public function items($sale_order_no)
    {
        $items=SaleOrderItem::where('sale_order_no', $sale_order_no)->orderBy('barcode','ASC')->get();
        return $items;
    }

    public function taxbleSup($sale_order_no)
    {
        return $this->items($sale_order_no)->sum('total_unit_price');
    }

    public function vat($sale_order_no)
    {
        return $this->items($sale_order_no)->sum('vat_amount');
    }

    public function grossTotal($sale_order_no)
    {
        return $this->items($sale_order_no)->sum('cost_price');
    }

    public function itemStock($itm)
    {
        return $this->hasMany(StockTransection::class, 'transection_id')->where('item_id',$itm)->where('stock_effect', -1)->sum('quantity');
    }

    public function deliveryNoteSale()
    {
        return $this->hasOne(DeliveryNoteSale::class, 'sale_order_id');
    }

    public function hasTaxInvoice()
    {
        return $this->hasOne(SaleInvoice::class, 'sale_order_id');
    }

    public function project()
    {
        return $this->belongsTo(ProjectDetail::class,'project_id');
    }

    public function saleItemQuantity()
    {
        return $this->hasMany(SaleOrderItem::class,'sale_order_id')->sum('quantity');
    }

    public function deliverItemQuantity()
    {
        return $this->hasMany(DeliveryItem::class,'sale_order_id')->sum('quantity');
    }

    public function dNote()
    {
        return $this->hasOne(DeliveryNoteSale::class,'sale_order_id');
    }

}
