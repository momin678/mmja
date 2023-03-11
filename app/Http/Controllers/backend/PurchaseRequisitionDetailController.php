<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\ItemList;
use App\ProjectDetail;
use App\PurchaseRequisition;
use App\PurchaseRequisitionDetail;
use App\PurchseDetailTemp;
use Illuminate\Http\Request;

class PurchaseRequisitionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function purchase_requisition_item_store(Request $request){
        
        $request->validate([
            'purchase_no' => 'required',
            'item_list_id' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
        ]);
        $item_exit = PurchaseRequisitionDetail::where("purchase_no", $request->purchase_no)->where("item_id", $request->item_list_id)->first();
        if($item_exit){
            $item_exit->quantity = $request->quantity;
            $item_exit->unit = $request->unit;
            $save = $item_exit->save();
        }else{
            $item_info = ItemList::find($request->item_list_id);
            $temp_item_store = new PurchaseRequisitionDetail;
            $temp_item_store->purchase_no = $request->purchase_no;
            $temp_item_store->item_id = $request->item_list_id;
            $temp_item_store->item_barcode = $item_info->barcode;
            $temp_item_store->style_code = $item_info->style->style_no;
            $temp_item_store->quantity = $request->quantity;
            $temp_item_store->unit = $request->unit;
            $save = $temp_item_store->save();
        }
        if ($save) {
            $temp_items = PurchaseRequisitionDetail::where('purchase_no', $request->purchase_no)->get();
            return view('backend.purchase-requisition.purchaseRequisitionDetail', compact('temp_items'));
        } else {
            return response()->json(['error' => 'Item List is not submitted!']);
        }
    }
    public function pr_item_delete(PurchaseRequisitionDetail $id){
        $id->delete();
        // $desableid = 75;
        return back()->with(['desableid' => '75']);
    }
    public function item_qty_get(Request $request){
        $item_price = ItemList::find($request->item_id)->total_amount;
        $purchase_info = PurchaseRequisition::find($request->purchase_no);
        $temp_items = PurchaseRequisitionDetail::where('item_id', $request->item_id)->where('purchase_no', $purchase_info->purchase_no)->first();
        return [$temp_items->quantity, $item_price];
    }
    public function project_name_get(Request $request){
        $purchase_info = PurchaseRequisition::find($request->purchase_no);
        $project_info = ProjectDetail::find($purchase_info->project_id);
        return $project_info;
    }    
    public function delete_previouse_pr_item_one(Request $request)
    {
        $id = PurchaseRequisitionDetail::find($request->id);
        $save = $id->delete();
        if ($save) {
            $temp_items = PurchaseRequisitionDetail::where('purchase_no', $request->purchase_no)->get();
            return view('backend.purchase-requisition.purchaseRequisitionDetail', compact('temp_items'));
        } else {
            return response()->json(['error' => 'Item List is not delete!']);
        }
    }
}
