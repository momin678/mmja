<?php

namespace App\Http\Controllers\backend;

use App\Fifo;
use App\Http\Controllers\Controller;
use App\ItemList;
use App\PartyInfo;
use App\StockTransection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    public function inventory_valuation_summary(){
        $customers = PartyInfo::where('pi_type', 'Supplier')->paginate(25);
        $items= ItemList::all();

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

    public function inventory_ageing_report(){
        $items= ItemList::all(); 
        return view('backend.inventoryReport.inventory-ageing-report', compact('items'));
    }

    public function ageing_classification(){
        $items= ItemList::all(); 
        return view('backend.inventoryReport.ageing-classification', compact('items'));
    }

    public function stock_summary_report(){
        
        
        $starttDate= date('Y-m-').'01';
        $endDate= date('Y-m-').'31';

        $items= ItemList::all(); 
        return view('backend.inventoryReport.stock-summary-report', compact('items'));
    }

    public function product_sales_cost(){
        $items= ItemList::all(); 
        return view('backend.inventoryReport.product-sales-cost', compact('items'));
    }

    public function abc_classification(){
        $items= ItemList::all();
        $total_value=0;
        foreach($items as $item){
            $avg_cost_price= $item->inventory_value_avg();
            $inv_qty= $item->inventory_qty();
            $cumulative_value= $avg_cost_price*$inv_qty;
            $total_value= $total_value + $cumulative_value;
        }
        $total_inventory_value= $total_value; 
        return view('backend.inventoryReport.abc-classification', compact('items','total_inventory_value'));
    }
}
