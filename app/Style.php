<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $table = 'styles';
    protected $fillable = ['style_name', 'style_no'];
    public function items()
    {
        return $this->hasMany(ItemList::class,'style_id');
    }
    
    //Tarek Start


    public function itemsSpecialSize()
    {
        return $this->hasMany(ItemList::class,'style_id');
    }

    public function styleSTockPositionCheck($style)
    {
        $items= ItemList::where('style_id',$style->id)->get();
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



    public function styleSTockPositionCheckDate($style,$date)
    {
        $items= ItemList::where('style_id',$style->id)->get();
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


    public function styleStockPositionCheckRange($style,$from,$to)
    {
        $items= ItemList::where('style_id',$style->id)->get();
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


    public function styleItemSaleRate()
    {
        // dd($style, $brand);
        $totalQty=0;
        $totalAmount=0;
        $items= $this->hasMany(ItemList::class, 'style_id');
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

    public function colorSaleCount($date,$id)
    {
        $count=0;
        $items=ItemList::where('style_id',$id)->select('brand_id')->distinct()->get();

        foreach($items as $item)
        {
            $itms=ItemList::where('brand_id',$item->brand_id)->where('style_id',$id)->get();
            $c=0;
            foreach($itms as $itm)
            {
                if($itm->dateSale($date)>0)
                    {
                        $c=1;
                        break;
                    }
            }
            $count=$count+$c;
        }
        return $count;
    }

    public function colorPurchaseCount($date,$id)
    {
        $count=0;
        $items=ItemList::where('style_id',$id)->select('brand_id')->distinct()->get();

        foreach($items as $item)
        {
            $itms=ItemList::where('brand_id',$item->brand_id)->where('style_id',$id)->get();
            $c=0;
            foreach($itms as $itm)
            {
                if($itm->datePurchase($date)>0)
                    {
                        $c=1;
                        break;
                    }
            }
            $count=$count+$c;
        }
        return $count;
    }

    public function colorSaleCountRange($from,$to,$id)
    {
        $count=0;
        $items=ItemList::where('style_id',$id)->select('brand_id')->distinct()->get();

        foreach($items as $item)
        {
            $itms=ItemList::where('brand_id',$item->brand_id)->where('style_id',$id)->get();
            $c=0;
            foreach($itms as $itm)
            {
                if($itm->saleRange($from,$to)>0)
                    {
                        $c=1;
                        break;
                    }
            }
            $count=$count+$c;
        }
        return $count;
    }


    public function colorPurchaseCountRange($from,$to,$id)
    {
        $count=0;
        $items=ItemList::where('style_id',$id)->select('brand_id')->distinct()->get();

        foreach($items as $item)
        {
            $itms=ItemList::where('brand_id',$item->brand_id)->where('style_id',$id)->get();
            $c=0;
            foreach($itms as $itm)
            {
                if($itm->purchaseRange($from,$to)>0)
                    {
                        $c=1;
                        break;
                    }
            }
            $count=$count+$c;
        }
        return $count;
    }

    public function colorSaleCountToday($id)
    {
        $count=0;
        $items=ItemList::where('style_id',$id)->select('brand_id')->distinct()->get();
        foreach($items as $item)
        {
            $c=0;
            $itms=ItemList::where('brand_id',$item->brand_id)->where('style_id',$id)->get();
            foreach($itms as $itm)
            {
                if($itm->saleToday()>0)
                {
                    $c=1;
                    break;
                }
            }
            $count=$count + $c;
        }
        return $count;
    }





    public function colorPurchaseCountToday($id)
    {
        $count=0;
        $items=ItemList::where('style_id',$id)->select('brand_id')->distinct()->get();
        foreach($items as $item)
        {
            $c=0;
            $itms=ItemList::where('brand_id',$item->brand_id)->where('style_id',$id)->get();
            foreach($itms as $itm)
            {
                if($itm->purchaseToday()>0)
                {
                    $c=1;
                    break;
                }
            }
            $count=$count + $c;
        }
        return $count;
    }
    
    public function styleRate()
    {
        return $this->hasMany(ItemList::class,'style_id')->first()->total_amount;
    }



    public function styleOpeningStock()
    {
        $opening=0;
        $items =$this->hasMany(ItemList::class,'style_id')->get();
        foreach($items as $item)
        {
            $opening = $opening + $item->todayOpeningStock();
        }

        return $opening;
    }

    public function styleOpeningStockDate($date)
    {
        $opening=0;
        $items =$this->hasMany(ItemList::class,'style_id')->get();
        foreach($items as $item)
        {
            $opening = $opening + $item->dateOpeningStock($date);
        }

        return $opening;
    }



    public function stylePurchaseStock()
    {
        $purchase=0;
        $items =$this->hasMany(ItemList::class,'style_id')->get();
        foreach($items as $item)
        {
            $purchase = $purchase + $item->purchaseToday();
        }

        return $purchase;
    }

    public function stylePurchaseStockDate($date)
    {
        $purchase=0;
        $items =$this->hasMany(ItemList::class,'style_id')->get();
        foreach($items as $item)
        {
            $purchase = $purchase + $item->datePurchase($date);
        }

        return $purchase;
    }

    public function stylePurchaseStockRange($from,$to)
    {
        $purchase=0;
        $items =$this->hasMany(ItemList::class,'style_id')->get();
        foreach($items as $item)
        {
            $purchase = $purchase + $item->purchaseRange($from,$to);
        }

        return $purchase;
    }

    public function styleTotalStock()
    {
        return $this->styleOpeningStock() + $this->stylePurchaseStock();
    }


    public function styleSale()
    {
        $sale=0;
        $items =$this->hasMany(ItemList::class,'style_id')->get();
        foreach($items as $item)
        {
            $sale = $sale + $item->saleToday();
        }

        return $sale;
    }

    public function styleSaleDate($date)
    {
        $sale=0;
        $items =$this->hasMany(ItemList::class,'style_id')->get();
        foreach($items as $item)
        {
            $sale = $sale + $item->dateSale($date);
        }

        return $sale;
    }

    public function styleSaleRange($from,$to)
    {
        $sale=0;
        $items =$this->hasMany(ItemList::class,'style_id')->get();
        foreach($items as $item)
        {
            $sale = $sale + $item->saleRange($from,$to);
        }

        return $sale;
    }

    public function styleCurrentStock()
    {
        $cstock=0;
        $items =$this->hasMany(ItemList::class,'style_id')->get();
        foreach($items as $item)
        {
            $cstock = $cstock + $item->itemStock();
        }

        return $cstock;
    }

    public function styleCurrentStockDate($date)
    {
        $cstock=0;
        $items =$this->hasMany(ItemList::class,'style_id')->get();
        foreach($items as $item)
        {
            $cstock = $cstock + $item->dateItemStock($date);
        }

        return $cstock;
    }

    
    //Tarek end
}
