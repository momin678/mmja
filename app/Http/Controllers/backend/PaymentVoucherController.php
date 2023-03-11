<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoicePosting;
use App\InvoicePostingDetails;
use App\Notification;
use App\PartyInfo;
use App\PaymentVoucher;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class PaymentVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice_postings = InvoicePosting::orderBy('id', 'desc')->where("is_paid", 0)->paginate(15);
        $payment_voucher = PaymentVoucher::orderBy('id', 'desc')->paginate(15);
        return view("backend.payment-voucher.index", compact("invoice_postings", 'payment_voucher'));
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
        $payment = new PaymentVoucher;
        $payment->payment_voucher_no = $request->payment_voucher_no;
        $payment->temp_payment_voucher_no = $request->temp_payment_voucher_no;
        $payment->ip_no = $request->ip_no;
        $payment->goods_received_no = $request->goods_received_no;
        $payment->po_no = $request->po_no;
        $payment->pr_no = $request->pr_no;
        $payment->supplier_id = $request->supplier_id;
        $payment->date = $request->date;
        $payment->payment_method = $request->payment_method;
        $payment->paid_amount = $request->paid_amount;
        $payment->due_amount = $request->due_amount;
        $payment->check_no = $request->check_no;
        $payment->bank_name = $request->bank_name;
        $payment->branch_name = $request->branch_name;
        $payment->supplier_name = $request->supplier_name;
        $payment->state = "PV Editor";
        $save = $payment->save();
        if($save){
            $ip = InvoicePosting::where("invoice_posting_no", $request->ip_no)->first();
            $ip->is_paid = 1;
            $ip->save();
        }
        $notification = array(
            'message' => "Payment Voucher Create Successful!",
            'alert-type' => "success",
        );
        return redirect("payment-voucher")->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pv_info = PaymentVoucher::find($id);
        $ip_items = InvoicePostingDetails::where("invoice_posting_no", $pv_info->ip_no)->get();
        return view("backend.payment-voucher.show", compact("pv_info", 'ip_items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pv_info = PaymentVoucher::find($id);
        $ip_items = InvoicePostingDetails::where("invoice_posting_no", $pv_info->ip_no)->get();
        return view("backend.payment-voucher.edit", compact("pv_info", 'ip_items'));
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
        $payment = PaymentVoucher::find($id);
        $payment->date = $request->date;
        $payment->payment_method = $request->payment_method;
        $payment->paid_amount = $request->paid_amount;
        $payment->due_amount = $request->due_amount;
        $payment->check_no = $request->check_no;
        $payment->bank_name = $request->bank_name;
        $payment->branch_name = $request->branch_name;
        $payment->supplier_name = $request->supplier_name;
        $payment->status = 0;
        $payment->state = "PV Editor";
        $payment->save();
        $rejNotify = Notification::where('purchase_id', $payment->payment_voucher_no)->where("state", "Editor")->where("status", 99)->first();
        if($rejNotify){
            $rejNotify->status = 0;
            $rejNotify->save();
        }
        $notification = array(
            'message' => "Payment Voucher Update Successful!",
            'alert-type' => "success",
        );
        return redirect("payment-voucher")->with($notification);
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
    public function pv_process($id){
        $ip_info = InvoicePosting::find($id);
        $ip_items = InvoicePostingDetails::where("invoice_posting_no", $ip_info->invoice_posting_no)->get();
        $payment_voucher = PaymentVoucher::orderBy('id', 'desc')->paginate(15);
        return view("backend.payment-voucher.pv-process", compact('ip_info', 'ip_items', 'payment_voucher'));
    }
    public function pv_create($id){
        $ip_info = InvoicePosting::find($id);
        $ip_items = InvoicePostingDetails::where("invoice_posting_no", $ip_info->invoice_posting_no)->get();
        $party_info = PartyInfo::where("pi_type", "Supplier")->get();
        return view("backend.payment-voucher.create", compact('ip_info', 'ip_items', 'party_info'));
    }
    public function pending_pv_authorize(){
        $pending_pv_authorize = PaymentVoucher::where("status", 0)->get();
        return view("backend.payment-voucher.pending-pv-authorize", compact("pending_pv_authorize"));
    }
    public function pv_authorize_view($id){
        $pv_info = PaymentVoucher::find($id);
        $ip_items = InvoicePostingDetails::where("invoice_posting_no", $pv_info->ip_no)->get();
        return view("backend.payment-voucher.pv-authorize-view", compact("pv_info", 'ip_items'));
    }
    public function revise_pv_submit_authorizer(Request $request){
        $authorize_pv_info = PaymentVoucher::where("payment_voucher_no", $request->payment_voucher_no)->first();
        $authorize_pv_info->status = 99;
        $authorize_pv_info->state = "PV Authorizer";
        $save = $authorize_pv_info->save();
        if($save){
            $notification = new Notification;
            $notification->purchase_id = $request->payment_voucher_no;
            $notification->comment = $request->comment;
            $notification->state = "Editor";
            $notification->status = 99;
            $notification->save();
        }
        $notification = array(
            'message' => 'PV Reviece Successful!',
            'alert-type' => 'success'
        );
        return redirect('pending-pv-authorize')->with($notification);
    }
    public function rejected_pv_authorizer($id){
        $pv_info = PaymentVoucher::find($id);
        $pv_info->status = 100;
        $pv_info->state = "PV Authorizer";
        $save = $pv_info->save();
        if($save){
            $n = new Notification;
            $n->purchase_id = $pv_info->payment_voucher_no;
            $n->comment = "Rejected form Authorizer";
            $n->state = "Editor";
            $n->status = 100;
            $n->save();
        }
        $notification = array(
            'message' => "PV Rejected Successful!",
            'alert-type' => "success",
        );
        return redirect("pending-pv-authorize")->with($notification);
    }
    public function rejected_pv_all_editor(){
        $rejected_pv = PaymentVoucher::where('status', 100)->get();
        return view("backend.payment-voucher.rejected-pv-all-editor", compact("rejected_pv"));
    }
    public function pv_approve_authorizer(PaymentVoucher $id){
        $id->status = 1;
        $id->state = "PV Authorizer";
        $id->save();
        $notification = array(
            'message' => "PV Authorize Successful",
            'alert-type' => "success"
        );
        return redirect("pending-pv-authorize")->with($notification);
    }
    public function pending_pv_approval(){
        $pv_approvals = PaymentVoucher::where('status', 1)->get();
        return view("backend.payment-voucher.pending-pv-approval", compact("pv_approvals"));
    }
    public function pv_approval_view($id){
        $pv_info = PaymentVoucher::find($id);
        $ip_items = InvoicePostingDetails::where("invoice_posting_no", $pv_info->ip_no)->get();
        return view("backend.payment-voucher.pv-approval-view", compact("pv_info", 'ip_items'));
    }
    public function revise_pv_submit_approval(Request $request){
        $pv_info = PaymentVoucher::where("payment_voucher_no", $request->payment_voucher_no)->first();
        $pv_info->status = 99;
        $pv_info->state = "PV Approval";
        $save = $pv_info->save();
        if($save){
            $data = [
                ['purchase_id'=>$request->payment_voucher_no, 'comment'=> $request->comment, 'state'=>"Editor", 'status'=>99],
                ['purchase_id'=>$request->payment_voucher_no, 'comment'=> $request->comment, 'state'=>"Authorize", 'status'=>99],
            ];
            Notification::insert($data);
        }
        $notification = array(
            'message' => 'PV Reviece Successful!',
            'alert-type' => 'success'
        );
        return redirect("pending-pv-approval")->with($notification);
    }
    public function revise_pv_all_editor(){
        $pv_revise = PaymentVoucher::where('status', 99)->get();
        return view("backend.payment-voucher.revise-pv-editor", compact("pv_revise"));
    }
    public function revise_pv_authorizer_approver(){
        $pv_revise = PaymentVoucher::where('status', 99)->where("state", "PV Approval")->get();
        return view("backend.payment-voucher.revise-pv-authorizer-approver", compact("pv_revise"));
    }
    public function rejected_pv_approver($id){
        $pv_info = PaymentVoucher::find($id);
        $pv_info->status = 100;
        $pv_info->state = "PV Approval";
        $save = $pv_info->save();
        if($save){
            $data = [
                ['purchase_id'=>$pv_info->payment_voucher_no, 'comment'=> "Rejected from Approver", 'state'=>"Editor", 'status'=>100],
                ['purchase_id'=>$pv_info->payment_voucher_no, 'comment'=> "Rejected from Approver", 'state'=>"Authorize", 'status'=>100],
            ];
            Notification::insert($data);
            
        }
        $notification = array(
            'message' => "PV Rejected Successful!",
            'alert-type' => "success",
        );
        return redirect("pending-pv-authorize")->with($notification);
    }
    public function rejected_pv_authorize(){
        $rejected_pv = PaymentVoucher::where('status', 100)->where("state", "PV Approval")->get();
        return view("backend.payment-voucher.rejected-pv-authorizer", compact("rejected_pv"));
    }
    public function pv_approve_approval($id){
        $pv_info = PaymentVoucher::find($id);
        $pv_info->state = "PV Approval";
        if($pv_info->due_amount > 0){
            $pv_info->status = 3;
        }else{
            $pv_info->status = 2;
        }
        $save = $pv_info->save();
        if($save){
            $ip = InvoicePosting::where("invoice_posting_no", $pv_info->ip_no)->first();
            if($pv_info->due_amount > 0){
                $ip->is_paid = 3;
            }else{
                $ip->is_paid = 2;
            }
            $ip->save();
        }
        $notification = array(
            "message" => "PV Approve Successful",
            "alert-type" => "success"
        );
        return redirect("pending-pv-approval")->with($notification);
    }
    public function approve_pv_view($id){
        $pv_info = PaymentVoucher::find($id);
        $ip_items = InvoicePostingDetails::where("invoice_posting_no", $pv_info->ip_no)->get();
        return view("backend.payment-voucher.approve-pv-view", compact("pv_info", 'ip_items'));
    }
    public function pv_pdf_print($id){
        $pv_info = PaymentVoucher::find($id);
        $ip_items = InvoicePostingDetails::where("invoice_posting_no", $pv_info->ip_no)->get();
        return view("backend.payment-voucher.pv-pdf-print", compact("pv_info", 'ip_items'));
    }
    public function pv_filter(Request $request){
        if($request->filter_value){
            $filter_value = $request->filter_value;
        }else{
            $filter_value = [];
        }
        $payment_voucher = PaymentVoucher::orderBy('id', 'desc')->whereIn("status", $filter_value)->get();
        return view('backend.payment-voucher.filter-value', compact('payment_voucher')); 
    }
}
