<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Group;
use App\Http\Controllers\Controller;
use App\ItemList;
use App\PartyInfo;
use App\PayMode;
use App\Payterm;
use App\ProductPurchase;
use App\ProjectDetail;
use App\TempItemStore;
use App\Unit;
use App\VatRate;
use Illuminate\Http\Request;

class ProductPurchaseController extends Controller
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
        $suppliers = PartyInfo::all();
        $payMode = PayMode::all();
        $payTerms = Payterm::all();
        $groups = Group::all();
        $itemLists = ItemList::all();
        $product_purchases = ProductPurchase::orderBy('id', 'desc')->paginate(15);
        return view('backend.item-purchase.index', compact('product_purchases', 'brands', 'units', 'vatRates', 'projects', 'suppliers', 'payMode', 'payTerms', 'groups', 'itemLists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $brands = Brand::all();
        $units = Unit::all();
        $vatRates = VatRate::all();
        $projects = ProjectDetail::all();
        $suppliers = PartyInfo::all();
        $payMode = PayMode::all();
        $payTerms = Payterm::all();
        $groups = Group::all();
        $itemLists = ItemList::all();
        return view('backend.item-purchase.create', compact('brands', 'units', 'vatRates', 'projects', 'suppliers', 'payMode', 'payTerms', 'groups', 'itemLists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'tax_invoice_date' => 'required',
            'serial_no' => 'required',
            'supplier_id' => 'required',
            'trn' => 'required',
            'project_id' => 'required',
            'pay_term' => 'required',
            'pay_mode' => 'required',
            'pay_date' => 'required',
            'tax_invoice_no' => 'required',
        ]);
        $temp_items = TempItemStore::where('serial_id', $request->serial_no)->get();
        if($temp_items->isEmpty()){
            return redirect()->route('item-purchase.create')->with('error', 'At lest One Item select');
        }
        $item_lists = new ProductPurchase;
        $item_lists->po_list = $request->po_list;
        $item_lists->project_id = $request->project_id;
        $item_lists->tax_invoice_date = $request->tax_invoice_date;
        $item_lists->serial_no = $request->serial_no;
        $item_lists->supplier_id = $request->supplier_id;
        $item_lists->trn = $request->trn;
        $item_lists->pay_mode = $request->pay_mode;
        $item_lists->pay_term = $request->pay_term;
        $item_lists->pay_date = $request->pay_date;
        $item_lists->tax_invoice_no = $request->tax_invoice_no;
        $item_lists->grand_total = $temp_items->sum('total_amount');
        $item_lists->save();
        $notification= array(
            'message'       => 'Purchase successfully finish!',
            'alert-type'    => 'success'
        );
        return redirect('item-purchase')->with($notification);
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
    public function supplier_information(Request $request){
        $supplier_information = PartyInfo::find($request->supplier_id);
        return response()->json($supplier_information);
    }
    public function temporary_item_list_stor(Request $request){
        $request->validate([
            'serial_id' => 'required',
            'brand_id' => 'required',
            'group_id' => 'required',
            'item_list_id' => 'required',
            'shipping_id' => 'required',
            'purchase_rate' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'vat_rate' => 'required',
            'taxable_supplies' => 'required',
            'vat_amount'=> 'required',
            'total_amount' => 'required',
        ]);
        $temp_item_store = new TempItemStore;
        $temp_item_store->serial_id = $request->serial_id;
        $temp_item_store->brand_id = $request->brand_id;
        $temp_item_store->group_id = $request->group_id;
        $temp_item_store->item_list_id = $request->item_list_id;
        $temp_item_store->shipping_id = $request->shipping_id;
        $temp_item_store->purchase_rate = $request->purchase_rate;
        $temp_item_store->quantity = $request->quantity;
        $temp_item_store->unit = $request->unit;
        $temp_item_store->vat_rate = $request->vat_rate;
        $temp_item_store->taxable_supplies = $request->taxable_supplies;
        $temp_item_store->vat_amount = $request->vat_amount;
        $temp_item_store->total_amount = $request->total_amount;
        $save = $temp_item_store->save();
        if($save){
            $temp_items = TempItemStore::where('serial_id', $request->serial_id)->get();
            return view('backend.ajax.tempList', compact('temp_items'));
        }else{
            return response()->json(['error'=>'Item List is not submitted!']);
        }
    }
    public function temp_item_delete(TempItemStore $id){
        $id->delete();
        return back();
    }
}
