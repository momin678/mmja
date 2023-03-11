<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['brand_id', 'name', 'origin'];

    
    // Tarek Start
    
    public function items()
    {
        return $this->hasMany(ItemList::class);
    }

    public function stockPositionCheck($brand,$style)
    {
        $items=ItemList::where('brand_id',$brand->id)->where('style_id',$style->id)->get();
        foreach($items as $item)
        {
            if($item->todayOpeningStock() > 0)
            {
                return true;
            }
            if($item->itemStock() > 0)
            {
                return true;
            }
            if($item->saleToday() > 0)
            {
                return true;
            }
        }
        return false;
    }

    public function stockPositionCheckDate($brand,$style,$date)
    {
        $items=ItemList::where('brand_id',$brand->id)->where('style_id',$style->id)->get();
        foreach($items as $item)
        {
            if($item->dateOpeningStock($date) > 0)
            {
                return true;
            }
            if($item->dateItemStock($date) > 0)
            {
                return true;
            }
            if($item->dateSale($date) > 0)
            {
                return true;
            }
        }
        return false;
    }

    public function stockPositionCheckRange($brand,$style,$from,$to)
    {
        $items=ItemList::where('brand_id',$brand->id)->where('style_id',$style->id)->get();
        foreach($items as $item)
        {
            if($item->dateOpeningStock($from) > 0)
            {
                return true;
            }
            if($item->saleRange($from,$to) > 0)
            {
                return true;
            }
            if($item->dateItemStock($to) > 0)
            {
                return true;
            }
        }
        return false;
    }

    public function colorItemSaleRate($style,$brand)
    {
        // dd($style, $brand);
        $totalQty=0;
        $totalAmount=0;
        $items=ItemList::where('style_id', $style->id)->where('brand_id',$brand->id)->get();
        foreach($items as $item)
        {
            $totalQty=$totalQty+$item->saleToday();
            $totalAmount=$totalAmount+$item->saleAmountToday();
        }

        if($totalQty==0)
        {
            return 0;
        }
        return $totalAmount/$totalQty;
    }


    public function colorItemPurchaseRate($style,$brand)
    {
        // dd($style, $brand);
        // return 1;
        $totalQty=0;
        $totalAmount=0;
        $items=ItemList::where('style_id', $style->id)->where('brand_id',$brand->id)->get();
        foreach($items as $item)
        {
            $totalQty=$totalQty+$item->purchaseToday();

            $allPurch=StockTransection::where('item_id',$item->id)->whereDate('date', date('Y-m-d'))->where('tns_type_code','P')->get();


            foreach($allPurch as $purch)
            {

                $ppp=Purchase::where('id',$purch->transection_id)->first();;
                // dd($ppp);
                $purch_details=PurchaseDetail::where('purchase_no',$ppp->purchase_no)->where('item_id',$purch->item_id)->first();
                $vat_value=VatRate::where('id',$purch_details->vat_rate)->first()->value;

                $rate=$purch_details->purchase_rate+(($purch_details->purchase_rate*$vat_value)/100);
                // dd($rate);
                $stock_amount=$rate*$purch->quantity;
                $totalAmount=$totalAmount+ $stock_amount;
            }
        }


        if($totalQty==0)
        {
            return 0;
        }
        return $totalAmount/$totalQty;
    }


    public function colorItemSaleAmount($style,$brand)
    {
        // dd($style, $brand);
        $totalAmount=0;
        $items=ItemList::where('style_id', $style->id)->where('brand_id',$brand->id)->get();
        foreach($items as $item)
        {
            $totalAmount=$totalAmount+$item->saleAmountToday();
        }


        return $totalAmount;
    }


    public function colorItemSaleRateDate($style,$brand,$date)
    {
        $totalQty=0;
        $totalAmount=0;
        $items=ItemList::where('style_id', $style->id)->where('brand_id',$brand->id)->get();
        foreach($items as $item)
        {
            $totalQty=$totalQty+$item->dateSale($date);
            $totalAmount=$totalAmount+$item->saleAmountDate($date);
        }

        if($totalQty==0)
        {
            return 0;
        }
        return $totalAmount/$totalQty;
    }

    public function colorItemPurchaseRateDate($style,$brand,$date)
    {
        $totalQty=0;
        $totalAmount=0;
        $items=ItemList::where('style_id', $style->id)->where('brand_id',$brand->id)->get();
        foreach($items as $item)
        {
            $totalQty=$totalQty+$item->datePurchase($date);
            $allPurch=StockTransection::where('item_id',$item->id)->whereDate('date', $date)->where('tns_type_code','P')->get();


            foreach($allPurch as $purch)
            {

                $ppp=Purchase::where('id',$purch->transection_id)->first();;
                // dd($ppp);
                $purch_details=PurchaseDetail::where('purchase_no',$ppp->purchase_no)->where('item_id',$purch->item_id)->first();
                $vat_value=VatRate::where('id',$purch_details->vat_rate)->first()->value;

                $rate=$purch_details->purchase_rate+(($purch_details->purchase_rate*$vat_value)/100);
                // dd($rate);
                $stock_amount=$rate*$purch->quantity;
                $totalAmount=$totalAmount+ $stock_amount;
            }
        }

        if($totalQty==0)
        {
            return 0;
        }
        return $totalAmount/$totalQty;
    }



    public function colorItemPurchaseRateDateRange($style,$brand,$from,$to)
    {
        $totalQty=0;
        $totalAmount=0;
        $items=ItemList::where('style_id', $style->id)->where('brand_id',$brand->id)->get();
        foreach($items as $item)
        {
            $totalQty=$totalQty+$item->purchaseRange($from,$to);
            $allPurch=StockTransection::where('item_id',$item->id)->whereDate('date','>=', $from)->whereDate('date','<=', $to)->where('tns_type_code','P')->get();


            foreach($allPurch as $purch)
            {

                $ppp=Purchase::where('id',$purch->transection_id)->first();;
                // dd($ppp);
                $purch_details=PurchaseDetail::where('purchase_no',$ppp->purchase_no)->where('item_id',$purch->item_id)->first();
                $vat_value=VatRate::where('id',$purch_details->vat_rate)->first()->value;

                $rate=$purch_details->purchase_rate+(($purch_details->purchase_rate*$vat_value)/100);
                // dd($rate);
                $stock_amount=$rate*$purch->quantity;
                $totalAmount=$totalAmount+ $stock_amount;
            }
        }

        if($totalQty==0)
        {
            return 0;
        }
        return $totalAmount/$totalQty;
    }

    public function colorItemSaleRateDateRange($style,$brand,$from,$to)
    {
        $totalQty=0;
        $totalAmount=0;
        $items=ItemList::where('style_id', $style->id)->where('brand_id',$brand->id)->get();
        foreach($items as $item)
        {
            $totalQty=$totalQty+$item->saleRange($from,$to);
            $totalAmount=$totalAmount+$item->saleAmountDateRange($from,$to);
        }

        if($totalQty==0)
        {
            return 0;
        }
        return $totalAmount/$totalQty;
    }


    public function colorItemSaleAmountDate($style,$brand,$date)
    {
        // dd($style, $brand);
        $totalAmount=0;
        $items=ItemList::where('style_id', $style->id)->where('brand_id',$brand->id)->get();
        foreach($items as $item)
        {
            $totalAmount=$totalAmount+$item->saleAmountDate($date);
        }


        return $totalAmount;
    }

    // Tarek End


}
