<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\GoodsReceivedDetails;
use App\Http\Controllers\Controller;
use App\ItemList;
use App\PurchaseReturnDetail;
use Illuminate\Http\Request;

class PurchaseReturnDetailController extends Controller
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
    public function purchase_return_item_store(Request $request){
        $request->validate([
            'item_id'=>'required',
            'return_qty'=>'required',
            'comment'=>'required',
        ]);
        $return_item = new PurchaseReturnDetail;
        $return_item->purchase_return_no = $request->purchase_return_no;
        $return_item->item_id = $request->item_id;
        $return_item->received_qty = $request->received_qty;
        $return_item->return_qty = $request->return_qty;
        $return_item->comment = $request->comment;
        $save = $return_item->save();
        if ($save) {
            $temp_items = PurchaseReturnDetail::where('purchase_return_no', $request->purchase_return_no)->get();
            return view('backend.ajax.return_tempList', compact('temp_items'));
        } else {
            return response()->json(['error' => 'Item List is not add!']);
        }
    }
    public function pt_item_barcode(Request $request){
        $item_barcode = ItemList::find($request->item_id);
        $brands = Brand::find($item_barcode->brand_id);
        $goods_received_no = GoodsReceivedDetails::where("goods_received_no", $request->goods_received_no)->where("item_id", $request->item_id)->first();
        return [$brands,$item_barcode,$goods_received_no];
    }
    public function temp_return_item_list_delete(PurchaseReturnDetail $id){
        $id->delete();
        return back();
    }
}
