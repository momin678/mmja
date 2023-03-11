<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceItem;
use App\Notification;
use App\PayTerm;
use App\ReceiptVoucher;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class ReceiptVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        $rvs = ReceiptVoucher::all();
        return view('backend.receipt-voucher.index', compact('invoices', "rvs"));
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
        // dd($request);
        if($request->tax_invoice_id){
            $tex_invoice_info = Invoice::find($request->tax_invoice_id);
            $rv = new ReceiptVoucher;
            $rv->rv_no = $request->rv_no;
            $rv->temp_rv_no = $request->temp_rv_no;
            $rv->tax_invoice_id = $tex_invoice_info->id;
            $rv->project_id = $request->project_id;
            $rv->customer_id = $request->customer_id;
            $rv->customer_name = $tex_invoice_info->customer_name;
            $rv->payment_method = $request->payment_method;
            $rv->date = $request->date;
            $rv->check_no = $request->check_no;
            $rv->bank_name = $request->bank_name;
            $rv->branch_name = $request->branch_name;
            $rv->paid_amount = $request->paid_amount;
            $rv->total_amount = $tex_invoice_info->grossTotal($tex_invoice_info->invoice_no);
            $rv->due_amount = $request->due_amount;
            $rv->save();
            $notification= array(
                'message'       => 'Receipt Voucher Create successfully!',
                'alert-type'    => 'success'
            );
            return redirect('receipt-voucher')->with($notification);
        }else{
            $notification= array(
                'message'       => 'Some thing Worng!',
                'alert-type'    => 'warning'
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
        $rv_info = ReceiptVoucher::find($id);
        $terms=PayTerm::get();
        return view('backend.receipt-voucher.show', compact('rv_info', 'terms'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rv_info = ReceiptVoucher::find($id);
        $terms=PayTerm::get();
        return view('backend.receipt-voucher.edit', compact('rv_info', 'terms'));
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
        $rv = ReceiptVoucher::find($id);
        $rv->date = $request->date;
        $rv->payment_method = $request->payment_method;
        $rv->check_no = $request->check_no;
        $rv->bank_name = $request->bank_name;
        $rv->branch_name = $request->branch_name;
        $rv->paid_amount = $request->paid_amount;
        $rv->due_amount = $request->due_amount;
        $rv->save();
        $notification= array(
            'message'       => 'Receipt Voucher Update successfully!',
            'alert-type'    => 'success'
        );
        return redirect('receipt-voucher')->with($notification);
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
    public function invoice_details($id){
        $invoice = Invoice::find($id);
        $terms=PayTerm::get();
        $invoice_items = InvoiceItem::where("invoice_no", $invoice->invoice_no)->get();
        return view('backend.receipt-voucher.invoice-details', compact("invoice", "invoice_items", "terms"));
    }
    public function receipt_voucher_create($id){
        $invoice = Invoice::find($id);
        $terms = PayTerm::get();
        $invoice_items = InvoiceItem::where("invoice_no", $invoice->invoice_no)->get();
        return view('backend.receipt-voucher.receipt-voucher-create', compact("invoice", "invoice_items", "terms"));
    }
    public function receipt_voucher_process($id){
        $rv_info = ReceiptVoucher::find($id);
        $rv_info->status = 1;
        $rv_info->save();
        $notification= array(
            'message'       => 'Receipt Voucher Process successfully!',
            'alert-type'    => 'success'
        );
        return redirect('receipt-voucher')->with($notification);
    }
    public function receipt_voucher_print($id){
        $rv_info = ReceiptVoucher::find($id);
        $terms=PayTerm::get();
        return view('backend.receipt-voucher.rv-pdf-print', compact('rv_info', 'terms'));
    }
    public function receipt_voucher_approval_list(){
        $rv_approval_list = ReceiptVoucher::where('status', 1)->get();
        return view('backend.receipt-voucher.rv-approval-list', compact('rv_approval_list'));
    }
    public function approve_rv_details($id){
        $rv_info = ReceiptVoucher::find($id);
        $terms=PayTerm::get();
        return view('backend.receipt-voucher.approve-rv-details', compact('rv_info', 'terms'));
    }
    public function approve_rv_reviece(Request $request){
        $rv_info = ReceiptVoucher::where("rv_no", $request->purchase_no)->first();
        $rv_info->status = 99;
        $save = $rv_info->save();
        if($save){
            $data = [
                ['purchase_id'=>$request->purchase_no, 'comment'=> $request->comment, 'state'=>"Editor", 'status'=>99]
            ];
            Notification::insert($data);
        }
        $notification = array(
            'message' => 'Receipt Voucher Revise Successful!',
            'alert-type' => 'success'
        );
        return redirect('receipt-voucher-approval-list')->with($notification);
    }
    public function approver_rv_approve($id){
        $rv_info = ReceiptVoucher::find($id);
        if($rv_info->due_amount > 0){
            $rv_info->status = 3;
        }else{
            $rv_info->status = 2;
        }        
        $rv_info->save();
        $notification= array(
            'message'       => 'Receipt Voucher Approval successfully!',
            'alert-type'    => 'success'
        );
        return redirect('receipt-voucher-approval-list')->with($notification);
    }
    public function rv_revise_list(){
        $rv_approval_list = ReceiptVoucher::where('status', 99)->get();
        return view('backend.receipt-voucher.rv-revise-list', compact('rv_approval_list'));
    }
    public function rv_revise_update($id){
        $rv_info = ReceiptVoucher::find($id);
        $terms=PayTerm::get();
        return view('backend.receipt-voucher.rv-revise-update-form', compact('rv_info', 'terms'));
    }
    public function rv_revise_update_complete(Request $request, $id){
        $rv = ReceiptVoucher::find($id);
        $rv->date = $request->date;
        $rv->payment_method = $request->payment_method;
        $rv->check_no = $request->check_no;
        $rv->bank_name = $request->bank_name;
        $rv->branch_name = $request->branch_name;
        $rv->paid_amount = $request->paid_amount;
        $rv->total_amount = $request->total_amount;
        $rv->due_amount = $request->due_amount;
        $rv->status = 1;
        $rv->save();
        $notification= array(
            'message'       => 'Receipt Voucher Revise Update successfully!',
            'alert-type'    => 'success'
        );
        return redirect('receipt-voucher')->with($notification);
    }
    public function rv_filter(Request $request){
        if($request->filter_value){
            $filter_value = $request->filter_value;
        }else{
            $filter_value = [];
        }
        $rvs = ReceiptVoucher::whereIn("status", $filter_value)->get();
        return view('backend.receipt-voucher.filter-value', compact('rvs'));

    }
}
