<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Fifo;
use App\FifoInvoice;
use App\GoodsReceivedDetails;
use App\Group;
use App\Http\Controllers\Controller;
use App\InvoiceItem;
use App\InvoiceItemTemp;
use App\InvoiceTemp;
use App\ItemList;
use App\PurchseDetail;
use App\PurchseDetailTemp;
use App\Unit;
use App\VatRate;
use Illuminate\Http\Request;
use App\Imports\BulkImport;
use App\PurchaseRequisitionDetail;
use App\PurchaseRequisitionDetailTemp;
use App\StockTransection;
use App\Style;
use Maatwebsite\Excel\Facades\Excel;

class ItemListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itme_lists = ItemList::orderBy("barcode")->paginate(20);
        $units = Unit::all();
        $vatRates = VatRate::all();
        $brands = Brand::all();
        $groups = Group::all();
        $styles = Style::all();
        return view('backend.item-list.index', compact('itme_lists', 'units', 'vatRates', 'brands', 'groups', 'styles'));
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
        $request->validate([
            'style_id' => 'required',
            'item_type' => 'required',
            'barcode' => 'required|unique:items,barcode',
            'item_name' => 'required',
            'brand_id' => 'required',
            'country' => 'required',
            'unit' => 'required',
            'description' => 'max:250',
            'sell_price' => 'required',
            'vat_rate' => 'required',
            'vat_amount' => 'required',
        ],
        [
            'barcode.unique'=> "same product exist"
        ]
        );
        $item_list = new ItemList;
        $group = Group::where('id', $request->item_type)->first();
        $item_list->group_name = $group->group_name;
        $item_list->group_no = $group->group_no;
        $item_list->barcode = $request->barcode;
        $item_list->style_id = $request->style_id;
        $item_list->item_name = $request->item_name;
        $item_list->brand_id = $request->brand_id;
        $item_list->country = $request->country;
        $item_list->unit = $request->unit;
        $item_list->description = $request->description;
        $item_list->sell_price = $request->sell_price;
        $item_list->vat_rate = $request->vat_rate;
        $item_list->vat_amount = $request->vat_amount;
        $item_list->total_amount = $request->total_amount;
        $item_list->save();
        $notification= array(
            'message'       => 'Item Listing successfully!',
            'alert-type'    => 'success'
        );
        return redirect('item-list')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item_info = ItemList::find($id);
        $units = Unit::all();
        $vatRates = VatRate::all();
        $brands = Brand::all();
        $groups = Group::all();
        $itme_lists = ItemList::orderBy("barcode")->paginate(20);
        return view('backend.item-list.show', compact('item_info', 'units', 'vatRates', 'brands', 'groups', 'itme_lists'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item_info = ItemList::find($id);
        $units = Unit::all();
        $vatRates = VatRate::all();
        $brands = Brand::all();
        $groups = Group::all();
        $styles = Style::all();
        $itme_lists = ItemList::orderBy("barcode")->paginate(20);
        return view('backend.item-list.edit', compact('item_info', 'units', 'vatRates', 'brands', 'groups', 'styles','itme_lists'));
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
        $request->validate([
            'item_type' => 'required',
            'barcode' => 'required|unique:items,barcode,'.$id,
            'style_id' => 'required',
            'item_name' => 'required',
            'brand_id' => 'required',
            'country' => 'required',
            'unit' => 'required',
            'description' => 'max:250',
            'sell_price' => 'required',
            'vat_rate' => 'required',
            'vat_amount' => 'required',
        ],
        [
            'barcode.unique'=> "same product exist"
        ]
        );
        $item_list = ItemList::find($id);
        $group = Group::where('group_name', $request->item_type)->first();
        $item_list->group_name = $group->group_name;
        $item_list->group_no = $group->group_no;
        $item_list->barcode = $request->barcode;
        $item_list->style_id = $request->style_id;
        $item_list->item_name = $request->item_name;
        $item_list->brand_id = $request->brand_id;
        $item_list->country = $request->country;
        $item_list->unit = $request->unit;
        $item_list->description = $request->description;
        $item_list->sell_price = $request->sell_price;
        $item_list->vat_rate = $request->vat_rate;
        $item_list->vat_amount = $request->vat_amount;
        $item_list->total_amount = $request->total_amount;
        $item_list->save();
        $notification= array(
            'message'       => 'Item Listing Updated successfully!',
            'alert-type'    => 'success'
        );
        return redirect('item-list')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd($id);
    }

    public function item_type_no(Request $request){
        $item_type_no = $request->item_type_id;
        if($item_type_no){
            $item_type_id = Group::all();
            return response()->json($item_type_id);
        }else{
            $item_type_id = [];
            return response()->json($item_type_id);
        }
    }
    public function group_id(Request $request){
        $group = Group::find($request->group_id);
        return $group;
    }
    public function brand_country(Request $request){
        $brand_country = Brand::where('id', $request->brand_id)->first();
        return $brand_country;
    }
    public function item_delete(ItemList $id)
    {   $searching = PurchaseRequisitionDetail::where('item_id', $id->id)->count();
        $searching1 = PurchseDetailTemp::where('item_id', $id->id)->count();
        $searching2 = PurchseDetail::where('item_id', $id->id)->count();
        $searching3 = InvoiceItem::where('item_id', $id->id)->count();
        $searching4 = InvoiceItemTemp::where('item_id', $id->id)->count();
        $searching5 = Fifo::where('item_id', $id->id)->count();
        $searching6 = FifoInvoice::where('item_id', $id->id)->count();
        $searching7 = StockTransection::where('item_id', $id->id)->count();
        if ($searching > 0  || $searching1 > 0 || $searching2 > 0 || $searching3 > 0 || $searching4 > 0 || $searching5 > 0 || $searching6 > 0 || $searching7 > 0) {
            return back()->with('error', "It has Related with Others Table");
        }
        $id->delete();
        $notification= array(
            'message'       => 'Item Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('item-list')->with($notification);
    }
    public function vat_type_value(Request $request){
        $vat_type = VatRate::find($request->vat_type_id);
        return $vat_type->value;
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => "required"
        ]);
        $save = Excel::import(new BulkImport,request()->file('file'));
        $notification= array(
            'message'       => 'Item Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('item-list')->with($notification);
    }
    public function item_barcode(Request $request){
        $item_barcode = ItemList::find($request->item_id);
        return $item_barcode;
    }
    public function item_barcode_check(Request $request){
        $item_barcode = ItemList::where("barcode", $request->barcode)->first();
        if($item_barcode){
            return "same product exist";
        }else{
            return "";
        }
        
    }
    public function item_name_auto_select(Request $request){
        $item = ItemList::where('barcode',$request->barcode)->first();
        return $item;
    }
    public function items_download(){
        $itme_lists = ItemList::orderBy("barcode", "asc")->get();
        $units = Unit::all();
        $vatRates = VatRate::all();
        $brands = Brand::all();
        $groups = Group::all();
        $styles = Style::all();
        return view('backend.item-list.items-download', compact('itme_lists', 'units', 'vatRates', 'brands', 'groups', 'styles'));
    }
}
