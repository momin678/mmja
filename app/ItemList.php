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

    public function inventory_value_avg($date=null){
        // Agerage purchase price

        if($date !=null){
            $items= $this->hasMany(StockTransection::class,'item_id')->where('date', '<=', $date)->orderBy('date','asc')->get();
        }else{
            $items= $this->hasMany(StockTransection::class,'item_id')->orderBy('date','asc')->get();
        }
        
        
        $quantity=0;
        $value=0;
        $avg_price=0;
        $str='';
        foreach($items as $item){
            
            if($item->tns_type_code=='P'){
                $purchase_value= $item->quantity * $item->purchase_rate; 
                $quantity= $quantity+ $item->quantity;
                $value= $value + $purchase_value;
                $str= $str.'='.$value;
                // $avg_price = $value/ $quantity;
                $avg_price = $quantity==0 ? 0 : ($value / $quantity);
            }elseif($item->tns_type_code=='S'){
                $quantity= $quantity- $item->quantity;
                $sales_cost= $item->quantity * $avg_price;
                $value= $value-$sales_cost;
                $str= $str.'='.$value;
                $avg_price = $quantity==0 ? 0 : ($value / $quantity);
            }elseif($item->tns_type_code=='T'){
                $product_value= $item->quantity * $avg_price; 
                $quantity= $quantity+ $item->quantity;
                $value= $value+ $product_value;
                $str= $str.'='.$value;
                $avg_price = $quantity==0 ? 0 : ($value / $quantity);
            }
        }

        // $avg_price == ($value / $quantity);

        $avg_price = $quantity==0 ? 0 : ($value / $quantity);

        return $avg_price;
    }

    public function stockIn()
    {
        $all= $this->hasMany(StockTransection::class,'item_id')->get();
        $purchase=$all->where('tns_type_code','P')->sum('quantity');
        return $purchase;
    }

    public function stockInDate($startDate,$endDate)
    {
        $all= $this->hasMany(StockTransection::class,'item_id')->where('date','>=', $startDate)->where('date','<=', $endDate)->get();
        $purchase=$all->where('tns_type_code','P')->sum('quantity');
        return $purchase;
    }

    public function stockOut()
    {
        $all= $this->hasMany(StockTransection::class,'item_id')->get();
        $sale=$all->where('tns_type_code','S')->sum('quantity');
        return $sale;
    }

    public function stockOutDate($startDate,$endDate)
    {
        $all= $this->hasMany(StockTransection::class,'item_id')->where('date','>=', $startDate)->where('date','<=', $endDate)->get();
        $sale=$all->where('tns_type_code','S')->sum('quantity');
        return $sale;
    }

    public function inventory_age($day1, $day2=null){
        if($day2 ==null){
            return $this->hasMany(Fifo::class,'item_id')->where('created_at', '<=', Carbon::now()->subDays($day1))->sum('remaining');            
        }else{
            return $this->hasMany(Fifo::class,'item_id')->where('created_at', '<=', Carbon::now()->subDays($day1))->where('created_at', '>=', Carbon::now()->subDays($day2))->sum('remaining');
        }
        
    }

    public function inventory_avg_price($day1,$day2=null){
        if($day2 == null){
            $all= $this->hasMany(Fifo::class,'item_id')->where('created_at', '<=', Carbon::now()->subDays($day1))->get();
        }else{
            $all= $this->hasMany(Fifo::class,'item_id')->where('created_at', '<=', Carbon::now()->subDays($day1))->where('created_at', '>=', Carbon::now()->subDays($day2))->get();
        }        
        
        $total_amount= $all->sum('total_amount');
        $total_quantity= $all->sum('quantity');
        return  $total_quantity == 0 ? 0 : (number_format($total_amount / $total_quantity,2)); 
    }

    public function avg_sales_price(){
        $all= $this->hasMany(InvoiceItem::class, 'item_id')->get();
        $total_sales_price= $all->sum('total_unit_price');
        $total_vat= $all->sum('vat_amount');
        $total_sales_price= $total_sales_price+ $total_vat;
        $quantity= $all->sum('quantity');

        $avg_sales_price= $quantity==0 ? 0 : ($total_sales_price / $quantity);
        return $avg_sales_price;
    }

    public function total_sales(){
        $all= $this->hasMany(InvoiceItem::class, 'item_id')->get();
        $total_sales_price= $all->sum('total_unit_price');
        $total_vat= $all->sum('vat_amount');
        $total_sales_price= $total_sales_price+ $total_vat;
        
        return $total_sales_price;
    }

    public function sales_qty(){
        $all= $this->hasMany(InvoiceItem::class, 'item_id')->get();
        $sales_qty= $all->sum('quantity');
        
        return $sales_qty;
    }

    public function inventory_qty(){
        $all= $this->hasMany(Fifo::class,'item_id')->get();
        $total_quantity= $all->sum('remaining');
        return $total_quantity;
    }

    


    // Tarek End


}
