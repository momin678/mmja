<?php

namespace App\Http\Controllers\backend;

use App\GoodsReceived;
use App\GoodsReceivedDetails;
use App\Http\Controllers\Controller;
use App\PayMode;
use App\PayTerm;
use App\Purchase;
use App\PurchaseDetail;
use App\PurchaseTemp;
use App\PurchseDetailTemp;
use App\TempPRNO;
use Illuminate\Http\Request;

class GoodsReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::orderBy("id", "desc")->paginate(15);
        $goods_received = GoodsReceived::orderBy("id", "desc")->paginate(15);
        return view('backend.goods-received.index', compact('purchases', 'goods_received'));
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
        $exit_gr_no = GoodsReceived::whereDate("created_at", "=", date("Y-m-d"))->max("temp_goods_received_no");
        $temp_gr_no = '';
        if($exit_gr_no){
            $temp_gr_no = $exit_gr_no+1;
        }else{
            $temp_gr_no = date("Ymd").'01';
        }
        $new_gr_no = $temp_gr_no."GR";
        $id = Purchase::where("purchase_no", $request->purchase_no)->first();
        $goods_received = new GoodsReceived;
        $goods_received->goods_received_no = $new_gr_no;
        $goods_received->temp_goods_received_no = $temp_gr_no;
        $goods_received->challan_number = $request->challan_number;
        $goods_received->po_no = $id->purchase_no;
        $goods_received->pr_no = $request->pr_id;
        $goods_received->date = $request->date;
        $goods_received->project_id =  $id->project_id;
        $goods_received->supplier_id = $id->supplier_id;
        $goods_received->save();
        $items_ids = $request->item_id;
        $qtys = $request->qty;
        foreach($items_ids as $key => $item_id){
            $item = PurchaseDetail::where('purchase_no', $request->purchase_no)->where('item_id', $item_id)->first();
            $goods_received_details = new GoodsReceivedDetails;
            $goods_received_details->goods_received_no = $new_gr_no;   
            $goods_received_details->item_id = $item_id;   
            $goods_received_details->received_qty = $qtys[$key];   
            $goods_received_details->pandding_qty = $item->quantity - $qtys[$key];   
            $goods_received_details->save();
        }
        $notification = array(
            'message' => 'Receive Save Successful!',
            'alert-type' => 'success'
        );
        
        return redirect('goods-received')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase_info = Purchase::find($id);
        $purchase_items = PurchaseDetail::where('purchase_no', $purchase_info->purchase_no)->get();
        $gr_info = GoodsReceived::where('po_no', $purchase_info->purchase_no)->pluck('goods_received_no');
        $payMode = PayMode::all();
        $payTerms = PayTerm::all();
        $goods_received = GoodsReceived::orderBy("id", "desc")->paginate(15);
        return view('backend.goods-received.show', compact('purchase_info', 'purchase_items', 'payMode', 'payTerms', 'goods_received', 'gr_info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase_info = Purchase::find($id);
        $purchase_items = PurchaseDetail::where('purchase_no', $purchase_info->purchase_no)->get();
        $gr_info = GoodsReceived::where('po_no', $purchase_info->purchase_no)->pluck('goods_received_no');
        $payMode = PayMode::all();
        $payTerms = PayTerm::all();
        $goods_received = GoodsReceived::orderBy("id", 'desc')->paginate(15);
        return view('backend.goods-received.edit', compact('purchase_info', 'purchase_items', 'payMode', 'payTerms', 'goods_received', 'gr_info'));
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
    public function gr_details(GoodsReceived $id){
        $gr_info = $id;
        $goods_received_details = GoodsReceivedDetails::where('goods_received_no', $id->goods_received_no)->get();
        $payMode = PayMode::all();
        $payTerms = PayTerm::all();
        $goods_received = GoodsReceived::orderBy("id", "desc")->paginate(20);
        return view('backend.goods-received.gr-details', compact('gr_info', 'goods_received_details', 'payMode', 'payTerms', 'goods_received'));
    }
    public function gr_print(GoodsReceived $id){
        $gr_info = $id;
        $goods_received_details = GoodsReceivedDetails::where('goods_received_no', $id->goods_received_no)->get();
        $payMode = PayMode::all();
        $payTerms = PayTerm::all();
        return view('backend.goods-received.gr-pdf-print', compact('gr_info', 'goods_received_details', 'payMode', 'payTerms'));
    }
    public function gr_list_show(Request $request){
        if($request->po_filter_value){
            $po_filter_value = $request->po_filter_value;
        }else{
            $po_filter_value = [''];
        }
        $purchaseRequisitions = GoodsReceived::whereIn("status", $po_filter_value)->get();
        return view("backend.goods-received.gr-list-show", compact("purchaseRequisitions"));
    }
}
