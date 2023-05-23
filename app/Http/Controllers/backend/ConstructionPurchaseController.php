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
use App\TempPRNO;
use App\Unit;
use App\VatRate;
use Illuminate\Http\Request;

class ConstructionPurchaseController extends Controller
{
    public function index(){
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
        $product_purchases = Purchase::orderBy('id', 'DESC')->paginate(15);
        return view('backend.construction-purchase.index', compact('product_purchases', 'brands', 'units', 'vatRates', 'projects', 'suppliers', 'payMode', 'payTerms', 'groups', 'itemLists', 'new_po_no'));
    }
    public function const_raw_po_item_store(Request $request){
        $request->validate([
            'purchase_no' => 'required',
            'item_list_id' => 'required',
            'purchase_rate' => 'required',
            'quantity' => 'required',
            'vat_rate' => 'required',
            'vat_amount' => 'required',
            'total_amount' => 'required',
        ]);
        $item_info = ItemList::find($request->item_list_id);
        $exit_item = PurchaseDetail::where("purchase_no", $request->purchase_no)->where("item_id", $request->item_list_id)->first();
        if($exit_item){
            $exit_item->purchase_rate = $request->purchase_rate;
            $exit_item->quantity = $request->quantity;
            $exit_item->vat_rate = $request->vat_rate;
            $exit_item->vat_amount = $request->vat_amount;
            $exit_item->total_amount = $request->total_amount;
            $save = $exit_item->save();
        }else{
            $temp_item_store = new PurchaseDetail();
            $temp_item_store->purchase_no = $request->purchase_no;
            $temp_item_store->brand_id = $item_info->brand_id;
            $temp_item_store->group_id = $item_info->group_no;
            $temp_item_store->style_id = $item_info->style_id;
            $temp_item_store->item_id = $request->item_list_id;
            $temp_item_store->purchase_rate = $request->purchase_rate;
            $temp_item_store->quantity = $request->quantity;
            $temp_item_store->unit = $item_info->unit;
            $temp_item_store->vat_rate = $request->vat_rate;
            $temp_item_store->vat_amount = $request->vat_amount;
            $temp_item_store->total_amount = $request->total_amount;
            $save = $temp_item_store->save();
        }
        $temp_items = PurchaseDetail::where('purchase_no', $request->purchase_no)->get();
        return view('backend.construction-purchase.tempList2', compact('temp_items'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'tax_invoice_no' => 'required',
            'purchase_no' => 'required',
            'pay_mode' => 'required',
            'pay_term' => 'required',
            'pay_date' => 'required',
            'shipping_id' => 'required',
        ]);
        $exit_po_no = Purchase::whereDate("created_at", "=", date("Y-m-d"))->max("temp_purchase_no");
        $temp_po_no = '';
        if($exit_po_no){
            $temp_po_no = $exit_po_no+1;
        }else{
            $temp_po_no = date("Ymd").'01';
        }
        $new_po_no = $temp_po_no."PO";
        $purchase_items_temp = PurchaseDetail::where('purchase_no', $request->purchase_no)->get();
        if($purchase_items_temp->isEmpty()){
            $notification = array(
                'message' => 'Please atleast one item add!',
                'alert-type' => 'warning'
            );
            return back()->with($notification);
        }
        $values = PurchaseDetail::where('purchase_no', $request->purchase_no)->update(['purchase_no'=>$new_po_no]);
        if($values){
            $purchase_temp = new Purchase;
            $purchase_temp->project_id = 1;
            $purchase_temp->pr_id = $request->pr_id;
            $purchase_temp->supplier_id = $request->supplier_id;
            $purchase_temp->tax_invoice_no = $request->tax_invoice_no;
            $purchase_temp->tax_invoice_date = $request->tax_invoice_date;
            $purchase_temp->purchase_no = $new_po_no;
            $purchase_temp->temp_purchase_no = $temp_po_no;
            $purchase_temp->pay_mode = $request->pay_mode;
            $purchase_temp->pay_term = $request->pay_term;
            $purchase_temp->pay_date = $request->pay_date;
            $purchase_temp->shipping_id = $request->shipping_id;
            $purchase_temp->date = $request->date;

            $discount_amount = 0;
            if($request->discount_type && $request->discount_amount){
                if($request->discount_type == 'Percentage'){
                    $discount_amount = (($purchase_items_temp->sum('total_amount')-$purchase_items_temp->sum('vat_amount'))*$request->discount_amount)/100;
                    $purchase_temp->discount_amount = $discount_amount;
                }elseif($request->discount_type == 'Fixed'){
                    $discount_amount = $request->discount_amount;
                    $purchase_temp->discount_amount = $request->discount_amount;
                }else{
                    $purchase_temp->discount_amount = 0;
                }
            }
            $total_amount = $purchase_items_temp->sum('total_amount')-$purchase_items_temp->sum('vat_amount');
            $net_total = $total_amount-$discount_amount;
            $vat_amount = ($net_total*5)/100;
            $grand_total = $net_total+$vat_amount;

            $purchase_temp->subtotal = $total_amount;
            $purchase_temp->vat = $vat_amount;
            $purchase_temp->grand_total = $grand_total;
            $purchase_temp->discount_type = $request->discount_type;
            $purchase_temp->discount_value = $discount_amount;
            if($request->pay_mode == "Cash" || $request->pay_mode == "Card"){
                $purchase_temp->paid_amount = $grand_total;
                $purchase_temp->due_amount = 0.00;
            }else{
                $purchase_temp->paid_amount = 0.00;
                $purchase_temp->due_amount = $grand_total;
            }
            $purchase_temp->status = 10;
            $purchase_temp->save();
            $notification = array(
                'message' => 'Purchase Entry Successful!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Some think Wrong! Please Try Again',
                'warning' => 'success'
            );
            return back()->with($notification);
        }
        
    }
    public function const_po_item_delete(Request $request){
        $id = PurchaseDetail::find($request->id);
        $save = $id->delete();
        if ($save) {
            $temp_items = PurchaseDetail::where('purchase_no', $request->purchase_no)->get();
            return view('backend.construction-purchase.tempList2', compact('temp_items'));
        } else {
            return response()->json(['error' => 'Item List is not submitted!']);
        }
    }
    public function const_raw_purchase_show($id){
        $purchase_info = Purchase::find($id);
        $purchase_items = PurchaseDetail::where('purchase_no', $purchase_info->purchase_no)->get();
        $payMode = PayMode::all();
        $payTerms = PayTerm::all();
        $product_purchases = Purchase::orderBy('id', 'DESC')->paginate(15);
        return view('backend.construction-purchase.show', compact('purchase_info', 'purchase_items', 'payMode', 'payTerms', 'product_purchases'));
    }
    public function const_raw_purchase_print($id){
        $purchase_info = Purchase::find($id);
        $supplier_info = PartyInfo::find($purchase_info->supplier_id);
        $purchase_items = PurchaseDetail::where('purchase_no', $purchase_info->purchase_no)->get();
        return view('backend.construction-purchase.purchase-print-pdf', compact('purchase_info', 'purchase_items', 'supplier_info'));
    }
    public function const_raw_purchase_process($id){        
        $purchase_info = Purchase::find($id);
        $purchase_info->status = 0;
        $purchase_info->save();
        $notification = array(
            'message' => 'PO Generation Process Successful!',
            'alert-type' => 'success'
        );
        return redirect('const-raw-purchase')->with($notification);
    }
    public function const_raw_purchase_edit($id)
    {
        $purchase_temp_info = Purchase::find($id);
        $purchase_details_temps = PurchaseDetail::where('purchase_no', $purchase_temp_info->purchase_no)->get();
        $brands = Brand::all();
        $units = Unit::all();
        $vatRates = VatRate::all();
        $projects = ProjectDetail::all();
        $payMode = PayMode::all();
        $payTerms = PayTerm::all();
        $groups = Group::all();
        $suppliers = PartyInfo::where('pi_type', "Supplier")->get();
        $product_purchases = Purchase::orderBy('id', 'DESC')->paginate(15);
        $items = ItemList::all();
        return view('backend.construction-purchase.edit', compact('product_purchases', 'brands', 'units', 'vatRates', 'projects', 'suppliers', 'payMode', 'payTerms', 'groups', 'purchase_details_temps', 'purchase_temp_info', 'items'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'supplier_id' => 'required',
            'tax_invoice_no' => 'required',
            'purchase_no' => 'required',
            'pay_mode' => 'required',
            'pay_term' => 'required',
            'pay_date' => 'required',
            'shipping_id' => 'required',
        ]);
        $purchase_items_temp = PurchaseDetail::where('purchase_no', $request->purchase_no)->get();
        if($purchase_items_temp->isEmpty()){
            $notification = array(
                'message' => 'Please atleast one item add!',
                'alert-type' => 'warning'
            );
            return back()->with($notification);
        }
        $purchase_temp = Purchase::find($id);
        $purchase_temp->project_id = 1;
        $purchase_temp->supplier_id = $request->supplier_id;
        $purchase_temp->tax_invoice_no = $request->tax_invoice_no;
        $purchase_temp->tax_invoice_date = $request->tax_invoice_date;
        $purchase_temp->pay_mode = $request->pay_mode;
        $purchase_temp->pay_term = $request->pay_term;
        $purchase_temp->pay_date = $request->pay_date;
        $purchase_temp->shipping_id = $request->shipping_id;
        $purchase_temp->date = $request->date;

        $discount_amount = 0;
        if($request->discount_type && $request->discount_amount){
            if($request->discount_type == 'Percentage'){
                $discount_amount = (($purchase_items_temp->sum('total_amount')-$purchase_items_temp->sum('vat_amount'))*$request->discount_amount)/100;
                $purchase_temp->discount_amount = $discount_amount;
            }elseif($request->discount_type == 'Fixed'){
                $discount_amount = $request->discount_amount;
                $purchase_temp->discount_amount = $request->discount_amount;
            }else{
                $purchase_temp->discount_amount = 0;
            }
        }
        $total_amount = $purchase_items_temp->sum('total_amount')-$purchase_items_temp->sum('vat_amount');
        $net_total = $total_amount-$discount_amount;
        $vat_amount = ($net_total*5)/100;
        $grand_total = $net_total+$vat_amount;

        $purchase_temp->subtotal = $total_amount;
        $purchase_temp->vat = $vat_amount;
        $purchase_temp->grand_total = $grand_total;
        if($request->pay_mode == "Cash" || $request->pay_mode == "Card"){
            $purchase_temp->paid_amount = $grand_total;
            $purchase_temp->due_amount = 0.00;
        }else{
            $purchase_temp->paid_amount = 0.00;
            $purchase_temp->due_amount = $grand_total;
        }
        $purchase_temp->status = 10;
        $purchase_temp->save();
        $notification = array(
            'message' => 'Purchase Update Successful!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
    public function const_raw_purchase_item_edit(Request $request){
        $item_info = PurchaseDetail::find($request->id);
        $item = ItemList::find($item_info->item_id);
        return response()->json([$item, $item_info]);
    }
    public function po_filter(Request $request)
    {
        if($request->filter_value){
            $filter_value = $request->filter_value;
        }else{
            $filter_value = [];
        }
        $product_purchases = Purchase::whereIn("status", $filter_value)->orderBy('id', 'DESC')->get();
        return view('backend.construction-purchase.filter-value', compact('product_purchases'));
    }
}
