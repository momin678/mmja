<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Fifo;
use App\GoodsReceived;
use App\Group;
use App\Http\Controllers\Controller;
use App\ItemList;
use App\Notification;
use App\PartyInfo;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\Purchase;
use App\PurchaseDetail;
use App\PurchaseRequisition;
use App\PurchaseRequisitionDetail;
use App\PurchseDetail;
use App\Stock;

use App\StockTransection;
use App\Unit;
use App\VatRate;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
            'project_id' => 'required',
            'pr_id' => 'required',
            'supplier_id' => 'required',
            'tax_invoice_no' => 'required',
            'purchase_no' => 'required',
            'pay_mode' => 'required',
            'pay_term' => 'required',
            'pay_date' => 'required',
            'shipping_id' => 'required',
        ]);
        $exit_pr_check = Purchase::where("pr_id", $request->pr_id)->first();
        if($exit_pr_check){
            $notification = array(
                'message' => 'This PR Item Already Take by Other!',
                'alert-type' => 'warning'
            );
            return back()->with($notification);
        }
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
            return redirect('item-purchase')->with($notification);
        }
        $values = PurchaseDetail::where('purchase_no', $request->purchase_no)->update(['purchase_no'=>$new_po_no]);
        if($values){
            $purchase_temp = new Purchase;
            $purchase_temp->project_id = $request->project_id;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $items = [];
        $item_ids = PurchaseRequisitionDetail::where("purchase_no", $purchase_temp_info->prInfo->purchase_no)->get();
        foreach($item_ids as $item){
            $itemInfo = ItemList::find($item->item_id);
            array_push($items, $itemInfo);
        }
        return view('backend.item-purchase.edit', compact('product_purchases', 'brands', 'units', 'vatRates', 'projects', 'suppliers', 'payMode', 'payTerms', 'groups', 'purchase_details_temps', 'purchase_temp_info', 'items', 'item_ids'));
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
            'project_id' => 'required',
            'pr_id' => 'required',
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
        $purchase_temp->project_id = $request->project_id;
        $purchase_temp->pr_id = $request->pr_id;
        $purchase_temp->supplier_id = $request->supplier_id;
        $purchase_temp->tax_invoice_no = $request->tax_invoice_no;
        $purchase_temp->tax_invoice_date = $request->tax_invoice_date;
        $purchase_temp->purchase_no = $request->purchase_no;
        $purchase_temp->pay_mode = $request->pay_mode;
        $purchase_temp->pay_term = $request->pay_term;
        $purchase_temp->pay_date = $request->pay_date;
        $purchase_temp->shipping_id = $request->shipping_id;
        $purchase_temp->date = $request->date;
        $purchase_temp->status = 0;
        $purchase_temp->save();
        $notification = array(
            'message' => 'Purchase Update Successful!',
            'alert-type' => 'success'
        );
        return redirect('item-purchase')->with($notification);
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
    public function po_generation_approval_list(){
        $purchases = Purchase::orderBy('id', 'DESC')->where('status', 0)->paginate(15);
        return view('backend.item-purchase.po-generation-approval-list', compact('purchases'));
    }
    public function po_generation_approval_details($id){
        $purchase_info = Purchase::find($id);
        $purchase_items = PurchaseDetail::where('purchase_no', $purchase_info->purchase_no)->get();
        $payMode = PayMode::all();
        $payTerms = PayTerm::all();
        return view('backend.item-purchase.po-generation-approval-details', compact('purchase_info', 'purchase_items', 'payMode', 'payTerms'));
    }
    public function approve_po_submit($id){
        // dd($id);
        $purchase_info = Purchase::find($id);
        $purchase_info->status = 1;
        $purchase_info->save();
        $notification = array(
            'message' => 'PO Approve Successful!',
            'alert-type' => 'success'
        );
        return redirect('po-generation-approval-list')->with($notification);
    }
    public function approve_po_reviece(Request $request){
        $po_info = Purchase::where("purchase_no", $request->purchase_no)->first();
        $po_info->status = 99;
        $save = $po_info->save();
        if($save){
            $data = [
                ['purchase_id'=>$request->purchase_no, 'comment'=> $request->comment, 'state'=>"Editor", 'status'=>99],
            ];
            Notification::insert($data);
        }
        $notification = array(
            'message' => 'PO Revise Successful!',
            'alert-type' => 'success'
        );
        return redirect('po-generation-approval-list')->with($notification);
    }
    public function po_generation_revise_list(){
        $purchases = Purchase::orderBy('id', 'DESC')->where('status', 99)->paginate(15);
        return view('backend.item-purchase.po-generation-revise-list', compact('purchases'));
    }
    public function purchase_temp_trasfer(Request $request){
        $goods_received = GoodsReceived::where("goods_received_no", $request->goods_received_no)->first();
        if($goods_received->status == 1){
            $notification = array(
                'message' => 'Goods Received Already Take!',
                'alert-type' => 'warning'
            );
            return back()->with($notification);
        }
        $goods_received->status = 1;
        $goods_received->save();

        $purchase_info = Purchase::where("purchase_no", $request->purchase_no)->first();
        $purchase_info->status = 101;
        $purchase_info->save();
        $purchase_requisition = PurchaseRequisition::where('purchase_no', $request->pr_id)->first();
        if($purchase_requisition){
            $purchase_requisition->status = 101;
            $purchase_requisition->save();
        }

        $items_ids = $request->item_id;
        $qtys = $request->qty;
        foreach($items_ids as $key => $item_id){
            // item stock
            if($qtys[$key] > 0){
                $item_stock = new StockTransection;
                $item_stock->item_id = $item_id;
                $item_stock->transection_id = $purchase_info->id;
                $item_stock->quantity = $qtys[$key];
                $item_stock->stock_effect = 1;
                $item_stock->tns_type_code = "P";
                $item_stock->tns_description = "Purchase";
                $item_stock->date = $goods_received->date;
                $item_stock->save();
                // fifos stock
                $item_find = PurchaseDetail::where("purchase_no", $request->purchase_no)->where("item_id", $item_id)->first();
                $vat_rate = VatRate::find($item_find->vat_rate);
                $unit_price = $item_find->purchase_rate + ($item_find->purchase_rate * $vat_rate->value)/100;

                $item_fifos = new Fifo;
                $item_fifos->item_id = $item_id;
                $item_fifos->purchase_id = $purchase_info->id;
                $item_fifos->quantity = $qtys[$key];
                $item_fifos->unit_cost_price = $unit_price;
                $item_fifos->consumed = 0;
                $item_fifos->remaining = $qtys[$key];
                $item_fifos->save();
                
                $newStock=Stock::where('item_id',$item_id)->first();
                if(!$newStock)
                {
                    $newStock=new Stock();
                    $newStock->item_id=$item_id;
                    $newStock->quantity=$qtys[$key];
                }
                else
                {
                    $newStock->quantity=$newStock->quantity+$qtys[$key];
                }
                 $newStock->save();
            }
        }
        $notification = array(
            'message' => 'Goods Received Successful!',
            'alert-type' => 'success'
        );
        return redirect('goods-received')->with($notification);
    }
    public function purchase_process($id){        
        $purchase_info = Purchase::find($id);
        $purchase_info->status = 0;
        $purchase_info->save();
        $notification = array(
            'message' => 'PO Generation Process Successful!',
            'alert-type' => 'success'
        );
        return redirect('item-purchase')->with($notification);
    }
    public function new_supplier(Request $request){
        $request->validate([
            'pi_name' => 'required',
            'pi_type'        => 'required',
        ],
        [
            'pi_name.required' => 'Cost Center is required',
            'pi_type.required' => 'Type is required',
        ]
        );
        $latest = PartyInfo::withTrashed()->orderBy('id','DESC')->first();
            if ($latest) {
                $pi_code=preg_replace('/^PI-/', '', $latest->pi_code );
                ++$pi_code;
            } else {
                $pi_code = 1;
            }
            if($pi_code<10)
            {
                $c_code="PI-000".$pi_code;
            }
            elseif($pi_code<100)
            {
                $c_code="PI-00".$pi_code;
            }
            elseif($pi_code<1000)
            {
                $c_code="PI-0".$pi_code;
            }
            else
            {
                $c_code="PI-".$pi_code;
            }
        $draftCost = new PartyInfo();
        $draftCost->pi_code = $c_code;
        $draftCost->pi_name = $request->pi_name;
        $draftCost->pi_type = $request->pi_type;
        $draftCost->trn_no = $request->trn_no;
        $draftCost->address = $request->address;
        $draftCost->con_person = $request->con_person;
        $draftCost->con_no = $request->con_no;
        $draftCost->phone_no = $request->phone_no;
        $draftCost->email = $request->email;
        $sv=$draftCost->save();
        $newCustomer=$draftCost;
        $customers=PartyInfo::where('pi_type', "Supplier")->get();
        return Response()->json(['page' => view('backend.item-purchase.new-supplier', ['customers' => $customers])->render(),'newCustomer' => $newCustomer ]);
    }
}
