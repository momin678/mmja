<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\GoodsReceived;
use App\Group;
use App\Http\Controllers\Controller;
use App\Purchase;
use App\PurchaseDetail;
use App\PurchaseRequisition;
use App\PurchaseRequisitionDetail;
use App\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $from = null;
        $to = null;
        $date = null;
        $sizes = Group::all();
        if($request->has('from')){
            $gd_receiveds = GoodsReceived::orderBy("id", "DESC")->whereDate('date','>=',$request->from)->whereDate('date','<=',$request->to)->get();
            $from=$request->from;
            $to=$request->to;
        }
        elseif($request->has('date')){
            $gd_receiveds = GoodsReceived::orderBy("id", "DESC")->whereDate('date',$request->date)->get();
            $date=$request->date;
        }
        else
        {
            $gd_receiveds = GoodsReceived::orderBy("id", "DESC")->where('date',date('Y-m-d'))->get();
        }

        $styles = Style::all();
        $colors = Brand::all();



        return view("backend.purchase-summary.index", compact('gd_receiveds','date','from','to'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function purchase_summary_print(Request $request){
        // dd($request);
        $styles = Style::all();
        $sizes = Group::all();
        $colors = Brand::all();

        $purchases = Purchase::latest();
        if($request->has('from_date')){
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            // $purchases = $purchases->whereBetween('date', ['2022-08-20', '2022-08-26']);
            $purchases = $purchases->whereBetween('date', [$from_date, $to_date]);
        }
        if($request->has('date')){
            $date = $request->date;
            $purchases = $purchases->where('date', $date);
        }
        $purchases = $purchases->get()->groupBy(function($item){ return $item->date; });
        return view("backend.purchase-summary.purchase-summary-print", compact('purchases', 'styles', 'colors', 'sizes'));
    }
    public function po_update(){
        $pr_list = PurchaseRequisition::all();
        foreach($pr_list as $pr){
            $pr_items = PurchaseRequisitionDetail::where('purchase_no', $pr->purchase_no)->get();
            foreach($pr_items as $item){
                $po = Purchase::where('pr_id', $pr->id)->first();
                $one_po_item = PurchaseDetail::where("purchase_no", $po->purchase_no)->where("item_id", $item->item_id)->first();
                $style = Style::where("style_no", $item->style_code)->first();
                $one_po_item->style_id = $style->id;
                $one_po_item->save();
            }
        }
    }

   public function searchDailyPurch(Request $request)
    {

        $date=$request->date;
        return view('backend.purchase-summary.purchase-summery-date', compact('date'));
    }


    public function searchDailyPurchageRange(Request $request)
    {
        // dd($request->all());
        $timefrom = strtotime($request->from);
        $searchDatefrom = date('m/d/Y',$timefrom);
        $timeto = strtotime($request->to);
        $searchDateto = date('m/d/Y',$timeto);
        $from=$request->from;
        $to=$request->to;
        $brands=Brand::latest()->get();
        return view('backend.purchase-summary.purchase-summery-range', compact('brands','from', 'to','searchDatefrom','searchDateto'));
    }


    public function printPurchaseSummery()
    {
        $date=null;
        $from=null;
        $to=null;
        $gd_receiveds = GoodsReceived::orderBy("id", "DESC")->where('date',date('Y-m-d'))->get();
        return view('backend.purchase-summary.index-print',compact('gd_receiveds','date','from','to'));
    }

       public function printPurchaseSummeryDate($date)
    {

        $from=null;
        $to=null;
        $gd_receiveds = GoodsReceived::orderBy("id", "DESC")->where('date',$date)->get();
        return view('backend.purchase-summary.index-print',compact('gd_receiveds','date','from','to'));
    }

    public function printPurchaseSummeryRange($from,$to)
    {
        $date=null;
        $gd_receiveds = GoodsReceived::orderBy("id", "DESC")->whereDate('date','>=',$from)->whereDate('date','<=',$to)->get();
        return view('backend.purchase-summary.index-print',compact('gd_receiveds','date','from','to'));
    }


}
