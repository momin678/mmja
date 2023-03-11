<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Group;
use App\Http\Controllers\Controller;
use App\ItemList;
use App\PartyInfo;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\Purchase;
use App\PurchaseDetail;
use App\PurchaseRequisition;
use App\PurchaseRequisitionDetail;
use App\PurchaseReturnDetail;
use App\PurchseDetail;
use App\Style;
use App\TempPRNO;
use App\Unit;
use App\VatRate;
use Illuminate\Http\Request;

class PurchaseDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temp_po = '';                                                    
        $exit_temp_no = TempPRNO::whereDate('created_at', '=', date('Y-m-d'))->max('po_no');
        if($exit_temp_no){
            $temp_po = $exit_temp_no+1;
        }else {
            $temp_po = date("Ymd").'01';
        }
        $new_po_no = new TempPRNO;
        $new_po_no->po_no = $temp_po;
        $new_po_no->save();

        $brands = Brand::all();
        $units = Unit::all();
        $vatRates = VatRate::all();
        $projects = ProjectDetail::all();
        $suppliers = PartyInfo::where('pi_type', "Supplier")->get();
        $payMode = PayMode::all();
        $payTerms = PayTerm::all();
        $groups = Group::all();
        $itemLists = ItemList::all();
        $pr_lists = PurchaseRequisition::whereDoesntHave('pr_info')->where('status', 2)->get();
        $product_purchases = Purchase::orderBy('id', 'DESC')->paginate(15);
        return view('backend.item-purchase.index', compact('product_purchases', 'brands', 'units', 'vatRates', 'projects', 'suppliers', 'payMode', 'payTerms', 'groups', 'itemLists', 'pr_lists', 'new_po_no'));
    }
    public function po_filter(Request $request)
    {
        if($request->filter_value){
            $filter_value = $request->filter_value;
        }else{
            $filter_value = [];
        }
        $product_purchases = Purchase::whereIn("status", $filter_value)->orderBy('id', 'DESC')->get();
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
        $purchase_info = Purchase::find($id);
        $purchase_items = PurchaseDetail::where('purchase_no', $purchase_info->purchase_no)->get();
        $payMode = PayMode::all();
        $payTerms = PayTerm::all();
        $product_purchases = Purchase::orderBy('id', 'DESC')->paginate(15);
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
    public function po_item_store(Request $request){
        $request->validate([
            'purchase_no' => 'required',
            'item_list_id' => 'required',
            'purchase_rate' => 'required',
            'quantity' => 'required',
            'vat_rate' => 'required',
            'vat_amount' => 'required',
            'total_amount' => 'required',
        ]);
        $items = PurchaseRequisitionDetail::where("purchase_no", $request->pr_no)->where("style_code", $request->style_id)->get();
        if($items){
            foreach($items as $value){
                $exit_item = PurchaseDetail::where("purchase_no", $request->purchase_no)->where("item_id", $value->item_id)->first();
                $vat_rate = VatRate::find($request->vat_rate)->value;
                $total = $request->purchase_rate * $value->quantity;
                $vat_amount = ($total * $vat_rate) / 100;
                $total_amount_with_amount = $total + $vat_amount;

                if($exit_item){
                    $exit_item->purchase_rate = $request->purchase_rate;
                    $exit_item->vat_rate = $request->vat_rate;
                    $exit_item->vat_amount = $vat_amount;
                    $exit_item->total_amount = $total_amount_with_amount;
                    $save = $exit_item->save();
                }else{
                    $item_info = ItemList::find($value->item_id);
                    $temp_item_store = new PurchaseDetail;
                    $temp_item_store->purchase_no = $request->purchase_no;
                    $temp_item_store->brand_id = $item_info->brand_id;
                    $temp_item_store->group_id = $item_info->group_no;
                    $temp_item_store->style_id = $item_info->style_id;
                    $temp_item_store->item_id = $value->item_id;
                    $temp_item_store->purchase_rate = $request->purchase_rate;
                    $temp_item_store->quantity = $value->quantity;
                    $temp_item_store->unit = $value->unit;
                    $temp_item_store->vat_rate = $request->vat_rate;
                    $temp_item_store->vat_amount = $vat_amount;
                    $temp_item_store->total_amount = $total_amount_with_amount;
                    $save = $temp_item_store->save();
                }
            }
            $temp_items = PurchaseDetail::where('purchase_no', $request->purchase_no)->get();
            return view('backend.item-purchase.tempList', compact('temp_items'));
            
        }else{
            return response()->json(['error' => 'Item List is not submitted!']);
        }
        
    }
    public function all_po_item_delete(Request $request){
        $purchase_no = $request->purchase_no;
        $purchaseTemp = Purchase::where("purchase_no", $purchase_no)->first();
        if($purchaseTemp == null){
            PurchaseDetail::whereIn('purchase_no',explode(",", $purchase_no))->delete();
        }
        $temp_items = PurchaseDetail::where('purchase_no', $request->purchase_no)->get();
        return view('backend.item-purchase.tempList', compact('temp_items'));
    }
    public function one_po_item_delete(Request $request){
        $id = PurchaseDetail::find($request->id);
        $save = $id->delete();
        if ($save) {
            $temp_items = PurchaseDetail::where('purchase_no', $request->purchase_no)->get();
            return view('backend.item-purchase.tempList', compact('temp_items'));
        } else {
            return response()->json(['error' => 'Item List is not submitted!']);
        }
    }
    public function one_po_item_edit(Request $request){
        $item_info = PurchaseDetail::find($request->id);
        $item = ItemList::find($item_info->item_id);
        $style_info = Style::find($item->style_id);
        return response()->json([$item, $style_info, $item_info]);
    }
    public function supplier_information(Request $request)
    {
        $supplier_information = PartyInfo::find($request->supplier_id);
        return response()->json($supplier_information);
    }
    public function purchase_print($id){
        $purchase_info = Purchase::find($id);
        $supplier_info = PartyInfo::find($purchase_info->supplier_id);
        $purchase_items = PurchaseDetail::where('purchase_no', $purchase_info->purchase_no)->get();
        return view('backend.item-purchase.purchase-print-pdf', compact('purchase_info', 'purchase_items', 'supplier_info'));
    }
    public function pr_print($id){
        $purchase_info = PurchaseRequisition::find($id);
        $purchase_items = PurchaseRequisitionDetail::where('purchase_no', $purchase_info->purchase_no)->get();
        return view('backend.pdf.pr-print', compact('purchase_info', 'purchase_items'));
    }
    public function delete_previouse_temp_item(Request $request){
        $id = $request->purchase_no;
        $Purchase = Purchase::find($id);
        if($Purchase == null){
            PurchaseDetail::whereIn('purchase_no',explode(",", $id))->delete();
        }
        $temp_items = PurchaseDetail::where('purchase_no', $request->purchase_no)->get();
        return view('backend.ajax.tempList', compact('temp_items'));
    }
}
