<?php

namespace App\Http\Controllers\backend;

use App\Fifo;
use App\Http\Controllers\Controller;
use App\ItemList;
use App\PartyInfo;
use App\StockTransection;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    public function inventory_valuation_summary(){
        $customers = PartyInfo::where('pi_type', 'Supplier')->paginate(25);
        $items= ItemList::all();
        // return $items;


        // $items= StockTransection::where('item_id',160)->get();
        
        // $quantity=0;
        // $value=0;
        // $avg_price=0;
        // foreach($items as $item){
            
        //     if($item->tns_type_code=='P'){
        //         $purchase_value= $item->quantity * $item->purchase_rate; 
        //         $quantity= $quantity+ $item->quantity;
        //         $value= $value + $purchase_value;
        //         $avg_price = $value/ $quantity;
        //     }elseif($item->tns_type_code=='S'){
        //         $quantity= $quantity- $item->quantity;
        //         $sales_cost= $item->quantity * $avg_price;
        //         $value= $value-$sales_cost;
        //         $avg_price = $value/ $quantity;
        //     }elseif($item->tns_type_code=='T'){
        //         $product_value= $item->quantity * $avg_price; 
        //         $quantity= $quantity+ $item->quantity;
        //         $value= $value+ $product_value;
        //         $avg_price = $value/ $quantity;
        //     }
            
        //     echo 'Type:'.$item->tns_type_code.'Each Qty:'. $item->quantity .' Total qty: '.$quantity.' Value: '.$value.'=='. $avg_price.'<br>';
        // }
        

        // return $avg_price;


        return view('backend.inventoryReport.inventory-valuation-summary', compact('customers','items'));
    }
    
    public function inventory_summary(){
        $items= ItemList::all();
        return view('backend.inventoryReport.inventory-summary', compact('items'));
    }

    public function fifo_cost_lost_tracking(){
        // $items=Fifo::paginate(25);
        $items=Fifo::all();
        return view('backend.inventoryReport.fifo-cost-lot-tracking', compact('items')); 
    }
}
