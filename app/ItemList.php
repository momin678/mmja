<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ItemList extends Model
{
    protected $table = "items";
    protected $fillable = ['style_id', 'group_no', 'group_name', 'barcode', 'item_name', 'brand_id', 'country', 'unit', 'description', 'sell_price', 'vat_rate', 'vat_amount', 'total_amount'];
    
    public function purchaseItem(){
        return $this->hasMany(PurchaseDetail::class, 'item_id');
    }
    
    public function brandName(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function groupName(){
        return $this->belongsTo(Group::class, 'group_no');
    }
    public function style(){
        return $this->belongsTo(Style::class, 'style_id');
    }

    // Tarek Start

    public function itemOpenningStock()
    {
        return $this->hasOne('App\OpeningStock','item_id');
    }

    public function itemOpenningStockMonth($month)
    {
        return $this->hasMany(OpeningStockRecord::class,'item_id')->where('month',$month)->first();
    }


    public function itemStockPurchase()
    {
        return $this->hasMany('App\StockTransection', 'item_id');
    }

    public function itemStockQuantityPurch($itm)
    {
        $purchase=StockTransection::where('item_id', $itm->id)->where('stock_effect', 1)->sum('quantity');
        return $purchase;
    }

    public function thisMontItemPurch($itm)
    {
        $purchase=StockTransection::where('item_id', $itm->id)->where('stock_effect', 1)->whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year)->sum('quantity');
        return $purchase;
    }

    public function MontItemPurch($itm,$month)
    {
        $year=substr($month, 0, 4);
        $month=substr($month, 5, 8);
        $purchase=StockTransection::where('item_id', $itm->id)
        ->where('stock_effect', 1)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->sum('quantity');
        return $purchase;
    }


    public function itemStockQuantitySale($itm)
    {
        $purchase=StockTransection::where('item_id', $itm->id)->where('stock_effect', -1)->sum('quantity');
        return $purchase;
    }


    public function thisMonthItemSale($itm)
    {
        $purchase=StockTransection::where('item_id', $itm->id)->where('stock_effect', -1)->whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year)->sum('quantity');
        return $purchase;
    }

    public function MonthItemSale($itm,$month)
    {
        $year=substr($month, 0, 4);
        $month=substr($month, 5, 8);
        $purchase=StockTransection::where('item_id', $itm->id)
        ->where('stock_effect', -1)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->sum('quantity');
        return $purchase;
    }

    public function thisMonthItemSaleReturn($itm)
    {
        $saleReturn=StockTransection::where('item_id', $itm->id)->where('tns_type_code',"T")->where('stock_effect', 1)->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('quantity');
        return $saleReturn;
    }


    public function MonthItemSaleReturn($itm,$month)
    {
        $year=substr($month, 0, 4);
        $month=substr($month, 5, 8);
        $saleReturn=StockTransection::where('item_id', $itm->id)
        ->where('tns_type_code',"T")
        ->where('stock_effect', 1)
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->sum('quantity');

        return $saleReturn;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function vatRate()
    {
        return $this->belongsTo(VatRate::class,'vat_rate');
    }


    public function todayOpeningStock()
    {
        $all= $this->hasMany(StockTransection::class,'item_id')->where('date','<', date('Y-m-d'))->get();
        $purchase=$all->where('tns_type_code','P')->sum('quantity');
        $sale=$all->where('tns_type_code','S')->sum('quantity');
        $saleReturn=$all->where('tns_type_code','T')->sum('quantity');
       return $purchase-$sale+$saleReturn;
    }

    public function dateOpeningStock($date)
    {
        $all= $this->hasMany(StockTransection::class,'item_id')->where('date','<', $date)->get();
        $purchase=$all->where('tns_type_code','P')->sum('quantity');
        $sale=$all->where('tns_type_code','S')->sum('quantity');
        $saleReturn=$all->where('tns_type_code','T')->sum('quantity');
       return $purchase-$sale+$saleReturn;
    }


    public function saleToday()
    {
       return $this->hasMany(StockTransection::class,'item_id')->whereDate('date', date('Y-m-d'))->where('tns_type_code','S')->sum('quantity');
    }
    public function saleAmountToday()
    {
       return $this->hasMany(StockTransection::class,'item_id')->whereDate('date', date('Y-m-d'))->where('tns_type_code','S')->sum('cost_price');
    }

    public function purchaseToday2()
    {
      
       return $this->hasMany(StockTransection::class,'item_id')->whereDate('date', date('Y-m-d'))->where('tns_type_code','P');
    }

    public function saleAmountDate($date)
    {
       return $this->hasMany(StockTransection::class,'item_id')->whereDate('date', $date)->where('tns_type_code','S')->sum('cost_price');
    }

    public function saleAmountDateRange($from,$to)
    {
       return $this->hasMany(StockTransection::class,'item_id')->whereDate('date','>=', $from)->whereDate('date','<=', $to)->where('tns_type_code','S')->sum('cost_price');
    }

    public function todaySaleRate()
    {
       $totalQty= $this->hasMany(StockTransection::class,'item_id')->whereDate('date', date('Y-m-d'))->where('tns_type_code','S')->sum('quantity');
       $totalSaleAmount= $this->hasMany(StockTransection::class,'item_id')->whereDate('date', date('Y-m-d'))->where('tns_type_code','S')->sum('cost_price');
        return $totalSaleAmount/$totalQty;
    }

    public function dateSale($date)
    {
       return $this->hasMany(StockTransection::class,'item_id')->whereDate('date', $date)->where('tns_type_code','S')->sum('quantity');
    }

    public function saleRange($from,$to)
    {
       return $this->hasMany(StockTransection::class,'item_id')->whereDate('date','>=', $from)->whereDate('date','<=', $to)->where('tns_type_code','S')->sum('quantity');
    }

    public function purchaseToday()
    {
       return $this->hasMany(StockTransection::class,'item_id')->whereDate('date', date('Y-m-d'))->where('tns_type_code','P')->sum('quantity');

    }

    public function datePurchase($date)
    {
       return $this->hasMany(StockTransection::class,'item_id')->whereDate('date', $date)->where('tns_type_code','P')->sum('quantity');
    }

    public function purchaseRange($from,$to)
    {
       return $this->hasMany(StockTransection::class,'item_id')->whereDate('date','>=', $from)->whereDate('date','<=', $to)->where('tns_type_code','P')->sum('quantity');
    }


    public function itemStock()
    {
        $all= $this->hasMany(StockTransection::class,'item_id')->get();
        $purchase=$all->where('tns_type_code','P')->sum('quantity');
        $sale=$all->where('tns_type_code','S')->sum('quantity');
        $saleReturn=$all->where('tns_type_code','T')->sum('quantity');
       return $purchase-$sale+$saleReturn;
    }

    public function dateItemStock($date)
    {
        $all= $this->hasMany(StockTransection::class,'item_id')->where('date','<=', $date)->get();
        $purchase=$all->where('tns_type_code','P')->sum('quantity');
        $sale=$all->where('tns_type_code','S')->sum('quantity');
        $saleReturn=$all->where('tns_type_code','T')->sum('quantity');
       return $purchase-$sale+$saleReturn;
    }
    
     public function avail_stock()
    {
        return $this->hasOne(Stock::class,'item_id');
    }


    // Tarek End


}
