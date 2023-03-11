<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Group;
use App\ItemList;
use App\ItemPurchase;
use App\ItemStock;
use App\PartyInfo;
use App\PayMode;
use App\PayTerm;
use App\ProductPurchase;
use App\ProjectDetail;
use App\Purchase;
use App\PurchseDetailTemp;
use App\TempItemStore;
use App\Unit;
use App\VatRate;
use App\Http\Controllers\Controller;
use App\PurchaseRequisition;
use App\PurchaseRequisitionDetail;
use Illuminate\Http\Request;

class PurchaseDetailTempController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        $units = Unit::all();
        $vatRates = VatRate::all();
        $projects = ProjectDetail::all();
        $suppliers = PartyInfo::where('pi_type', "Supplier")->get();
        $payMode = PayMode::all();
        $payTerms = PayTerm::all();
        $groups = Group::all();
        $itemLists = ItemList::all();
        $pr_lists = PurchaseRequisition::where('status', 2)->get();
        $product_purchases = Purchase::orderBy('id', 'asc')->paginate(15);
        return view('backend.item-purchase.index', compact('product_purchases', 'brands', 'units', 'vatRates', 'projects', 'suppliers', 'payMode', 'payTerms', 'groups', 'itemLists', 'pr_lists'));
    }
    public function po_filter(Request $request)
    {
        if($request->filter_value){
            $filter_value = $request->filter_value;
        }else{
            $filter_value = [];
        }
        $product_purchases = Purchase::whereIn("status", $filter_value)->get();
        return view('backend.item-purchase.filter-value', compact('product_purchases'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id);
        $purchase_info = Purchase::find($id);
        $purchase_items = PurchseDetailTemp::where('purchase_no', $purchase_info->purchase_no)->get();
        $payMode = PayMode::all();
        $payTerms = PayTerm::all();
        $product_purchases = Purchase::orderBy('id', 'asc')->paginate(15);
        return view('backend.item-purchase.show', compact('purchase_info', 'purchase_items', 'payMode', 'payTerms', 'product_purchases'));
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
    public function supplier_information(Request $request)
    {
        $supplier_information = PartyInfo::find($request->supplier_id);
        return response()->json($supplier_information);
    }
    public function temporary_item_list_stor(Request $request)
    {
        $request->validate([
            'purchase_no' => 'required',
            'item_list_id' => 'required',
            'purchase_rate' => 'required',
            'quantity' => 'required',
            'vat_rate' => 'required',
            'vat_amount' => 'required',
            'total_amount' => 'required',
        ]);
        $exit_item = PurchseDetailTemp::where("purchase_no", $request->purchase_no)->where("item_id",$request->item_list_id)->first();
        if($exit_item){
            $exit_item->purchase_rate = $request->purchase_rate;
            $exit_item->vat_rate = $request->vat_rate;
            $exit_item->vat_amount = $request->vat_amount;
            $exit_item->total_amount = $request->total_amount;
            $save = $exit_item->save();
        }else{
            $item_info = ItemList::find($request->item_list_id);
            $temp_item_store = new PurchseDetailTemp;
            $temp_item_store->purchase_no = $request->purchase_no;
            $temp_item_store->brand_id = $item_info->brand_id;
            $temp_item_store->group_id = $item_info->group_no;
            $temp_item_store->item_id = $request->item_list_id;
            $temp_item_store->purchase_rate = $request->purchase_rate;
            $temp_item_store->quantity = $request->quantity;
            $temp_item_store->unit = $request->unit;
            $temp_item_store->vat_rate = $request->vat_rate;
            $temp_item_store->vat_amount = $request->vat_amount;
            $temp_item_store->total_amount = $request->total_amount;
            $save = $temp_item_store->save();
        }
        if ($save) {
            $temp_items = PurchseDetailTemp::where('purchase_no', $request->purchase_no)->get();
            return view('backend.ajax.tempList', compact('temp_items'));
        } else {
            return response()->json(['error' => 'Item List is not submitted!']);
        }
    }
    public function temp_item_delete(PurchseDetailTemp $id)
    {
        $id->delete();
        return back();
    }
    public function purchase_print($id){
        $purchase_info = Purchase::find($id);
        $supplier_info = PartyInfo::find($purchase_info->supplier_id);
        $purchase_items = PurchseDetailTemp::where('purchase_no', $purchase_info->purchase_no)->get();
        $product_purchases = Purchase::orderBy('id', 'asc')->paginate(15);
        return view('backend.item-purchase.purchase-print-pdf', compact('purchase_info', 'purchase_items', 'product_purchases', 'supplier_info'));
    }
    public function pr_print($id){
        $purchase_info = PurchaseRequisition::find($id);
        $purchase_items = PurchaseRequisitionDetail::where('purchase_no', $purchase_info->purchase_no)->get();
        $product_purchases = Purchase::orderBy('id', 'asc')->paginate(15);
        return view('backend.pdf.pr-print', compact('purchase_info', 'purchase_items', 'product_purchases'));
    }
    public function delete_previouse_temp_item(Request $request){
        $id = $request->purchase_no;
        $Purchase = Purchase::find($id);
        if($Purchase == null){
            PurchseDetailTemp::whereIn('purchase_no',explode(",", $id))->delete();
        }
        $temp_items = PurchseDetailTemp::where('purchase_no', $request->purchase_no)->get();
        return view('backend.ajax.tempList', compact('temp_items'));
    }
}
