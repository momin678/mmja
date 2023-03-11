<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Group;
use App\Http\Controllers\Controller;
use App\ItemList;
use App\Notification;
use App\PartyInfo;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\PurchaseRequisition;
use App\PurchaseRequisitionDetail;
use App\PurchaseTemp;
use App\PurchseDetailTemp;
use App\TempPRNO;
use App\Unit;
use App\VatRate;
use Illuminate\Http\Request;

class PurchaseRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temp_pr = '';                                                    
        $exit_temp_no = TempPRNO::whereDate('created_at', '=', date('Y-m-d'))->max('pr_no');
        if($exit_temp_no){
            $temp_pr = $exit_temp_no+1;
        }else {
            $temp_pr = date("Ymd").'01';
        }
        $new_pr_no = new TempPRNO;
        $new_pr_no->pr_no = $temp_pr;
        $new_pr_no->save();

        $units = Unit::all();
        $purchaseRequisitions = PurchaseRequisition::orderBy("id", "DESC")->paginate(15);
        $itemLists = ItemList::orderBy("barcode", "asc")->get();
        $projects = ProjectDetail::all();
        return view('backend.purchase-requisition.index', compact('units', 'purchaseRequisitions', 'itemLists', 'projects', 'new_pr_no'));
    }
    public function pr_filter(Request $request){
        if($request->filter_value){
            $filter_value = $request->filter_value;
        }else{
            $filter_value = [];
        }
        $purchaseRequisitions = PurchaseRequisition::orderBy("id", "DESC")->whereIn("status", $filter_value)->get();
        return view('backend.purchase-requisition.filter-value', compact('purchaseRequisitions'));
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
            'purchase_no' => 'required',
            'temp_purchase_no' => 'required',
        ]);
        $purchase_items_temp = PurchaseRequisitionDetail::where('purchase_no', $request->purchase_no)->get();
        if($purchase_items_temp->isEmpty()){
            $notification = array(
                'message' => 'Please atleast one item add!',
                'alert-type' => 'warning'
            );
            return redirect('purchase-requisition')->with($notification);
        }
        $exit_pr_no = PurchaseRequisition::whereDate("created_at", "=", date("Y-m-d"))->max("temp_purchase_no");
        $temp_purchase_no = '';
        if($exit_pr_no){
            $temp_purchase_no = $exit_pr_no+1;
        }else{
            $temp_purchase_no = date("Ymd").'01';
        }
        $purchase_no = $temp_purchase_no."PR";
        $values = PurchaseRequisitionDetail::where('purchase_no', $request->purchase_no)->update(['purchase_no'=>$purchase_no]);
        if($values){
            $purchase_temp = new PurchaseRequisition;
            $purchase_temp->project_id = $request->project_id;
            $purchase_temp->purchase_no = $purchase_no;
            $purchase_temp->temp_purchase_no = $temp_purchase_no;
            $purchase_temp->date = $request->date;
            $purchase_temp->status = 10;
            $purchase_temp->save();
            $notification = array(
                'message' => 'Purchase Requisition Entry Successful!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Some Think Wrong Please Try Agrain!',
                'alert-type' => 'warning'
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
        $purchase_info = PurchaseRequisition::find($id);
        $purchase_items = PurchaseRequisitionDetail::where('purchase_no', $purchase_info->purchase_no)->get();
        $payMode = PayMode::all();
        $payTerms = PayTerm::all();
        $product_purchases = PurchaseRequisition::orderBy("id", "DESC")->paginate(15);
        return view('backend.purchase-requisition.show', compact('purchase_info', 'purchase_items', 'payMode', 'payTerms', 'product_purchases'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $units = Unit::all();
        $purchaseRequisitions = PurchaseRequisition::orderBy("id", "DESC")->paginate(15);
        $itemLists = ItemList::orderBy("barcode", "asc")->get();
        $projects = ProjectDetail::all();
        $prInfo = PurchaseRequisition::find($id);
        $purchase_details_temps = PurchaseRequisitionDetail::where('purchase_no', $prInfo->purchase_no)->get();
        return view('backend.purchase-requisition.edit', compact('units', 'purchaseRequisitions', 'itemLists', 'projects', 'prInfo', 'purchase_details_temps'));
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
            'purchase_no' => 'required',
        ]);
        $purchase_items_temp = PurchaseRequisitionDetail::where('purchase_no', $request->purchase_no)->get();
        if($purchase_items_temp->isEmpty()){
            $notification = array(
                'message' => 'Please atleast one item add!',
                'alert-type' => 'warning'
            );
            return redirect('purchase-requisition')->with($notification);
        }
        $purchase_temp = PurchaseRequisition::find($id);
        $purchase_temp->project_id = $request->project_id;
        $purchase_temp->purchase_no = $request->purchase_no;
        $purchase_temp->temp_purchase_no = $request->temp_purchase_no;
        $purchase_temp->date = $request->date;
        $purchase_temp->status = 0;
        $purchase_temp->save();
        $rejNotify = Notification::where('purchase_id', $request->purchase_no)->where("state", "Editor")->where("status", 99)->first();
        if($rejNotify){
            $rejNotify->status = 0;
            $rejNotify->save();
        }
        $notification = array(
            'message' => 'Purchase Requisition Update Successful!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
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
    public function delete_previouse_pr_item(Request $request){
        $id = $request->purchase_no;
        $purchaseTemp = PurchaseTemp::find($id);
        if($purchaseTemp == null){
            PurchaseRequisitionDetail::whereIn('purchase_no',explode(",", $id))->delete();
        }
        $temp_items = PurchaseRequisitionDetail::where('purchase_no', $request->purchase_no)->get();
        return view('backend.purchase-requisition.purchaseRequisitionDetail', compact('temp_items'));
    }
    public function purchase_requisitin_aprove($id){
        $purchase_info = PurchaseRequisition::find($id);
        $purchase_info->status = 0;
        $purchase_info->save();
        $notification = array(
            'message' => 'Purchase Requisition Aprove Successful!',
            'alert-type' => 'success'
        );
        return redirect('purchase-requisition')->with($notification);
    }
    public function item_list_get(Request $request){
        $items = [];
        $requisition = PurchaseRequisition::find($request->id);
        $item_ids = PurchaseRequisitionDetail::where("purchase_no", $requisition->purchase_no)->get();
        foreach($item_ids as $item){
            $itemInfo = ItemList::find($item->item_id);
            array_push($items, $itemInfo);
        }
        return response()->json([$items, $item_ids]);
    }
    public function authorize_requisition(){
        $authrizeRequisition = PurchaseRequisition::orderBy("id", "DESC")->where('status', 0)->paginate(15);
        return view('backend.purchase-requisition.authorize-pr-list', compact('authrizeRequisition'));
    }
    public function authorize_requisition_details($id){
        $authorize_requisition_info = PurchaseRequisition::find($id);
        $purchase_items = PurchaseRequisitionDetail::where('purchase_no', $authorize_requisition_info->purchase_no)->get();
        return view('backend.purchase-requisition.authorize-pr-details', compact('authorize_requisition_info', 'purchase_items'));
    }
    public function authorize_pr_submit($id){
        $authorize_requisition_info = PurchaseRequisition::find($id);
        $authorize_requisition_info->status = 1;
        $authorize_requisition_info->save();
        $notification = array(
            'message' => 'Purchase Requisition Authorize Successful!',
            'alert-type' => 'success'
        );
        return redirect('authorize-requisition')->with($notification);
    }
    public function approve_requisition(){
        $approveRequisition = PurchaseRequisition::orderBy("id", "DESC")->where('status', 1)->paginate(15);
        return view('backend.purchase-requisition.approve-pr-list', compact('approveRequisition'));
    }
    public function approve_requisition_details($id){
        $approve_requisition_info = PurchaseRequisition::find($id);
        $purchase_items = PurchaseRequisitionDetail::where('purchase_no', $approve_requisition_info->purchase_no)->get();
        return view('backend.purchase-requisition.approve-pr-details', compact('approve_requisition_info', 'purchase_items'));
    }
    public function approve_pr_submit($id){
        $authorize_requisition_info = PurchaseRequisition::find($id);
        $authorize_requisition_info->status = 2;
        $authorize_requisition_info->save();
        $notification = array(
            'message' => 'Purchase Requisition Approve Successful!',
            'alert-type' => 'success'
        );
        return redirect('approve-requisition')->with($notification);
    }
    public function authorize_pr_rejected($id){
        $authorize_requisition_info = PurchaseRequisition::find($id);
        $authorize_requisition_info->status = 100;
        $save = $authorize_requisition_info->save();
        if($save){
            $notification = new Notification;
            $notification->purchase_id = $authorize_requisition_info->purchase_no;
            $notification->comment = "PR Rejected from Authorize";
            $notification->state = "Editor";
            $notification->status = 100;
            $notification->save();
        }
        $notification = array(
            'message' => 'Purchase Requisition Rejected Successful!',
            'alert-type' => 'success'
        );
        return redirect('authorize-requisition')->with($notification);
    }
    public function approver_pr_rejected($id){
        $authorize_requisition_info = PurchaseRequisition::find($id);
        $authorize_requisition_info->status = 100;
        $save = $authorize_requisition_info->save();
        if($save){
            $notification = new Notification;
            $notification->purchase_id = $authorize_requisition_info->purchase_no;
            $notification->comment = "PR Rejected from Approver";
            $notification->state = "Editor";
            $notification->status = 100;
            $notification->save();
        }
        $notification = array(
            'message' => 'Purchase Requisition Rejected Successful!',
            'alert-type' => 'success'
        );
        return redirect('authorize-requisition')->with($notification);
    }
    public function authorize_pr_reviece(Request $request){
        $authorize_requisition_info = PurchaseRequisition::where("purchase_no", $request->purchase_no)->first();
        $authorize_requisition_info->status = 99;
        $save = $authorize_requisition_info->save();
        if($save){
            $notification = new Notification;
            $notification->purchase_id = $request->purchase_no;
            $notification->comment = $request->comment;
            $notification->state = "Editor";
            $notification->status = 99;
            $notification->save();
        }
        $notification = array(
            'message' => 'Purchase Requisition Revise Successful!',
            'alert-type' => 'success'
        );
        return redirect('authorize-requisition')->with($notification);
    }
    public function rejected_requisition(){
        $rejectedRequisition = PurchaseRequisition::orderBy("id", "DESC")->where('status', 100)->paginate(15);
        return view('backend.purchase-requisition.rejected-pr-list', compact('rejectedRequisition'));
    }
    public function approve_pr_reviece(Request $request){
        $authorize_requisition_info = PurchaseRequisition::where("purchase_no", $request->purchase_no)->first();
        $authorize_requisition_info->status = 99;
        $save = $authorize_requisition_info->save();
        if($save){
            $data = [
                ['purchase_id'=>$request->purchase_no, 'comment'=> $request->comment, 'state'=>"Editor", 'status'=>99],
                ['purchase_id'=>$request->purchase_no, 'comment'=> $request->comment, 'state'=>"Authorize", 'status'=>99],
            ];
            Notification::insert($data);
        }
        $notification = array(
            'message' => 'Purchase Requisition Revise Successful!',
            'alert-type' => 'success'
        );
        return redirect('approve-requisition')->with($notification);
    }
    public function reviece_requisition_authorize(){
        $rejectedRequisition = Notification::where('state', "Authorize")->where('status', 99)->get();
        // dd($rejectedRequisition);
        return view('backend.purchase-requisition.rejected-pr-notification-authorize', compact('rejectedRequisition'));
    }
    public function reviece_requisition_editor(){
        $rejectedRequisition = PurchaseRequisition::orderBy("id", "DESC")->where('status', 99)->paginate(15);
        return view('backend.purchase-requisition.rejected-pr-notification', compact('rejectedRequisition'));
    }
    public function editor_pr_process($id){
        $pr_info = PurchaseRequisition::find($id);
        $pr_info->status = 0;
        $pr_info->save();        
        $notification = array(
            'message' => 'PR Process Successful!',
            'alert-type' => 'success'
        );
        return redirect("purchase-requisition")->with($notification);
    }
    public function delete_previouse_po_item_one(Request $request){
        $id = PurchseDetailTemp::find($request->id);
        $save = $id->delete();
        if ($save) {
            $temp_items = PurchseDetailTemp::where('purchase_no', $request->purchase_no)->get();
            return view('backend.ajax.tempList', compact('temp_items'));
        } else {
            return response()->json(['error' => 'Item List is not submitted!']);
        }
    }
    public function pr_print($id){
        $purchase_info = PurchaseRequisition::find($id);
        $purchase_items = PurchaseRequisitionDetail::where('purchase_no', $purchase_info->purchase_no)->get();
        return view('backend.purchase-requisition.pr-print', compact('purchase_info', 'purchase_items'));
    }
}
