<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Http\Controllers\Controller;
use App\ItemList;
use App\OpeningStock;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockPositionController extends Controller
{
    public function stockPosition()
    {
        // dd(Carbon::now()->format('Y-m-d'));

        $stockP=OpeningStock::whereMonth('date','!=', Carbon::now()->month)->first();
       if($stockP)
       {
        $stockOp=OpeningStock::whereMonth('date','!=', Carbon::now()->month)->get();

        foreach($stockOp as $st)
       {

        $st->date=Carbon::now()->format('Y-m-d');

        $st->quantity=($st->item->itemStockQuantityPurch($st->item)) - ($st->item->itemStockQuantitySale($st->item));
        $st->save();
       }

       }
        $brands=Brand::latest()->paginate(50);
        return view('backend.stock.stockPosition', compact('brands'));
    }
}
