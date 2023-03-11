<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Http\Controllers\Controller;
use App\ItemList;
use App\OpeningStock;
use App\OpeningStockRecord;
use App\Style;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockPositionController extends Controller
{
    public function stockPosition()
    {
        $brands=Brand::latest()->get();
        // $styles=Style::whereDoesntHave('itemsSpecialSize')->get();
        // dd($styles,$styles->itemsSpecialSize);
        return view('backend.stock.stockPosition', compact('brands'));
    }

    public function stockPosition2(Request $request)
    {
        $from = null;
        $to = null;
        $date = null;
        if($request->has('from')){
            $from=$request->from;
            $to=$request->to;
        }
        elseif($request->has('date')){
            $date=$request->date;
        }

        $styles=Style::all();
        return view('backend.stock.stockPosition2', compact('styles','date','from','to'));
    }

    public function printStockPosition2()
    {
        $date=null;
        $from=null;
        $to=null;
        $styles=Style::all();
        return view('backend.pdf.stockPositionPrint2', compact('styles','date','from','to'));
    }

    public function printStockPosition2Date($date)
    {

        $from=null;
        $to=null;
        $styles=Style::all();
        return view('backend.pdf.stockPositionPrint2', compact('styles','date','from','to'));
    }

    public function printStockPosition2Range($from,$to)
    {
        $date=null;
        $styles=Style::all();
        return view('backend.pdf.stockPositionPrint2', compact('styles','date','from','to'));
    }



    public function stockReportWithP()
    {
        $brands=Brand::latest()->get();
        return view('backend.stock.stockReportWithP', compact('brands'));
    }


    public function searchStockPosition(Request $request)
    {
        $month=$request->month;
        if($month==Carbon::now()->format('Y-m'))
        {
            return redirect()->route('stockPosition');
        }
        $brands=Brand::latest()->get();
        return view('backend.stock.stockPositionMonth', compact('brands','month'));
    }

    public function searchStockPositionDate(Request $request)
    {
        $time = strtotime($request->date);
        $searchDate = date('m/d/Y',$time);
        $date=$request->date;
        $brands=Brand::latest()->get();
        return view('backend.stock.stockPositionDate', compact('brands','date','searchDate'));
    }

    public function searchStockPositionRange(Request $request)
    {
        $timefrom = strtotime($request->from);
        $searchDatefrom = date('m/d/Y',$timefrom);
        $timeto = strtotime($request->to);
        $searchDateto = date('m/d/Y',$timeto);
        $from=$request->from;
        $to=$request->to;
        $brands=Brand::latest()->get();
        return view('backend.stock.stockPositionRange', compact('brands','from', 'to','searchDatefrom','searchDateto'));
    }


    public function searchStockPositionDateP(Request $request)
    {
        $time = strtotime($request->date);
        $searchDate = date('m/d/Y',$time);
        $date=$request->date;
        $brands=Brand::latest()->get();
        return view('backend.stock.stockPositionDateP', compact('brands','date','searchDate'));

    }

    public function searchStockPositionRangeP(Request $request)
    {
        $timefrom = strtotime($request->from);
        $searchDatefrom = date('m/d/Y',$timefrom);
        $timeto = strtotime($request->to);
        $searchDateto = date('m/d/Y',$timeto);
        $from=$request->from;
        $to=$request->to;
        $brands=Brand::latest()->get();
        return view('backend.stock.stockPositionRangeP', compact('brands','from', 'to','searchDatefrom','searchDateto'));

    }


    public function printStockPosition()
    {
        $brands=Brand::latest()->get();
        return view('backend.pdf.stockPosition', compact('brands'));
    }



    public function printStockPositionDate($date)
    {
        $date=$date;
        $brands=Brand::latest()->get();
        // dd(1);
        return view('backend.pdf.stockPositionDate', compact('brands','date'));
    }


    public function printStockPositionRange($from, $to)
    {

        $brands=Brand::latest()->get();
        return view('backend.pdf.stockPositionRange', compact('brands','from', 'to'));
    }

    public function printStockPositionP()
    {
        $brands=Brand::latest()->get();
        return view('backend.pdf.stockPositionP', compact('brands'));
    }

    public function printStockPositionDateP($date)
    {
        $date=$date;
        $brands=Brand::latest()->get();
        // dd(1);
        return view('backend.pdf.stockPositionDateP', compact('brands','date'));
    }


    public function printStockPositionRangeP($from, $to)
    {

        $brands=Brand::latest()->get();
        return view('backend.pdf.stockPositionRangeP', compact('brands','from', 'to'));
    }
    
     public function available_stock()
    {
        $brands=Brand::latest()->get();
        return view('backend.stock.available-stock', compact('brands'));

    }
}
