<?php

namespace App\Http\Controllers\backend;

use App\DebitCreditVoucher;
use App\Http\Controllers\Controller;
use App\Journal;
use App\JournalRecord;
use App\Models\AccountHead;
use App\Models\CostCenter;
use App\PartyInfo;
use App\PaymentVoucher;
use App\PaymentVoucherDetail;
use App\PaymentVoucherDetailTemp;
use App\PaymentVoucherTemp;
use App\PayMode;
use App\ProjectDetail;
use App\SupplierInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NewPaymentVoucher extends Controller
{
    public function payment_voucher_form(){
        Gate::authorize('payment_voucher_create');
        $projects = ProjectDetail::all();
        $cCenters = CostCenter::all();
        $pInfos = PartyInfo::where('pi_type','Supplier')->get();
        $modes = PayMode::all();
        $invoices= SupplierInvoice::where('pay_mode', 'Credit')->orWhere('due_amount','>',0)->get();
        // return $invoices;
        $payment_vouchers= PaymentVoucherTemp::all();

        return view('backend.new-payment-voucher.new-create', compact('projects', 'cCenters', 'pInfos','modes','invoices','payment_vouchers'));
    }

    public function get_invoice_details(Request $request){

        $invoice_data= SupplierInvoice::where('invoice_no', $request->invoice_no)->first();
        $due_amount= PaymentVoucherDetailTemp::where('invoice_no',$request->invoice_no)->sum('paid_amount');

        return Response()->json([
            'invoice_amount' => ($invoice_data->amount+$invoice_data->vat_amount),
            'due_amount' => ($invoice_data->due_amount >0 ? $invoice_data->due_amount: ($invoice_data->amount+$invoice_data->vat_amount-$due_amount)),
        ]);
    }

    public function payment_voucher_store(Request $request){
        // return $request;
        Gate::authorize('payment_voucher_create');

        $journal_amount=0;
        if($request->voucher_type=='advance'){

            $ac_head_dr= AccountHead::find(36); // Accrued liability/ Need to define account head

            $payment_voucher                = new PaymentVoucherTemp();

            $payment_voucher->type          = $request->voucher_type;
            $payment_voucher->cost_center_id= $request->cost_center_name;
            $payment_voucher->party_info_id = $request->party_info;
            $payment_voucher->amount        = $request->total_amount;
            $payment_voucher->payment_date  = $request->date;
            $payment_voucher->pay_mode      = $request->pay_mode;
            $payment_voucher->narration     = $request->remark;
            $payment_voucher->date        = $request->date;

            $payment_voucher->project_id        = $request->project;
            $payment_voucher->status     = "Authorize";
            $payment_voucher->created_by     = Auth::id();
            $payment_voucher->save();

            $journal_amount = $request->total_amount;


        }elseif($request->voucher_type=='due'){
            $ac_head_dr= AccountHead::find(35); // Accounts Payable

            $amount=0;
            foreach($request->input('group-a') as $each_inv){
                $amount= $amount+ $each_inv['payment_amount'];
            }
            $journal_amount = $amount;

            $payment_voucher                = new PaymentVoucherTemp();
            $payment_voucher->type          = $request->voucher_type;
            $payment_voucher->cost_center_id= $request->cost_center_name;
            $payment_voucher->party_info_id = $request->party_info;
            $payment_voucher->amount        = $amount;
            $payment_voucher->payment_date  = $request->date;
            $payment_voucher->pay_mode      = $request->pay_mode;
            $payment_voucher->narration     = $request->remark;
            $payment_voucher->date        = $request->date;
            $payment_voucher->project_id        = $request->project;
            $payment_voucher->status     = "Authorize";
            $payment_voucher->created_by     = Auth::id();
            $payment_voucher->save();

            foreach($request->input('group-a') as $each_inv){
                $inv_details= SupplierInvoice::where('invoice_no', $each_inv['invoice_no'])->first();

                $rv_details= new PaymentVoucherDetailTemp();
                $rv_details->payment_voucher_temp_id    = $payment_voucher->id;
                $rv_details->invoice_id     = $inv_details->id;
                $rv_details->invoice_no     = $each_inv['invoice_no'];
                $rv_details->cost_center_id = $request->cost_center_name;
                $rv_details->party_info_id  = $request->party_info;
                $rv_details->invoice_amount = $inv_details->amount+$inv_details->vat_amount;
                $rv_details->paid_amount    = $each_inv['payment_amount'];
                $rv_details->payment_date   = $request->date;
                $rv_details->pay_mode       = $request->pay_mode;
                $rv_details->save();

                $current_paid_ammount       = $inv_details->paid_amount + $each_inv['payment_amount'];
                $inv_details->paid_amount   = $current_paid_ammount;
                $inv_details->due_amount    = ($inv_details->amount + $inv_details->vat_amount) -$current_paid_ammount;
                $inv_details->save();

            }
        }


        return back()->with('success',"Successfully Added");
    }

    public function payment_voucher_print($id){
        $payment_voucher= PaymentVoucherTemp::find($id);

        $words= $this->convert_number($payment_voucher->amount);

        return view('backend.new-payment-voucher.print', compact('payment_voucher','words'));
    }

    function convert_number($number)
    {
        if (($number < 0) || ($number > 999999999))
        {
            throw new Exception("Number is out of range");
        }
        $giga = floor($number / 1000000);
        // Millions (giga)
        $number -= $giga * 1000000;
        $kilo = floor($number / 1000);
        // Thousands (kilo)
        $number -= $kilo * 1000;
        $hecto = floor($number / 100);
        // Hundreds (hecto)
        $number -= $hecto * 100;
        $deca = floor($number / 10);
        // Tens (deca)
        $n = $number % 10;
        // Ones
        $result = "";
        if ($giga)
        {
            $result .= $this->convert_number($giga) .  "Million";
        }
        if ($kilo)
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($kilo) . " Thousand";
        }
        if ($hecto)
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($hecto) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($deca || $n) {
            if (!empty($result))
            {
                $result .= " and ";
            }
            if ($deca < 2)
            {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n)
                {
                    $result .= "-" . $ones[$n];
                }
            }
        }
        if (empty($result))
        {
            $result = "zero";
        }
        return $result;
    }

    public function payment_voucher_list(Request $request){
        $payment_vouchers= PaymentVoucher::all();
        return view('backend.new-payment-voucher.payment-voucher-list', compact('payment_vouchers'));
    }
    public function payment_voucher_details_modal(Request $request){
        $payment_voucher= PaymentVoucherTemp::find($request->id);
        $words= $this->convert_number($payment_voucher->amount);
        return view('backend.new-payment-voucher.payment-voucher-preview', compact('payment_voucher','words'));
    }
    public function payment_voucher_view_pdf($id){
        $payment_voucher= PaymentVoucherTemp::find($id);
        $words= $this->convert_number($payment_voucher->amount);
        $pdf = PDF::loadView('backend.new-payment-voucher.payment-voucher-pdf', compact('payment_voucher', 'words'));
        return $pdf->download('payment-voucher.pdf');
        // return view('backend.new-receipt-voucher.receipt-voucher-pdf', compact('payment_voucher','words'));
    }


    //work by tarek
    public function authorize_payment_voucher_list(Request $request){
        Gate::authorize('payment_voucher_authorize');

        $payment_vouchers= PaymentVoucherTemp::where('status',"Authorize")->get();
        return view('backend.new-payment-voucher.pre-payment-voucher-list', compact('payment_vouchers'));
    }
    public function approval_payment_voucher_list(Request $request){
        Gate::authorize('payment_voucher_approval');
        $payment_vouchers= PaymentVoucherTemp::where('status',"Approve")->get();
        return view('backend.new-payment-voucher.pre-payment-voucher-list', compact('payment_vouchers'));
    }


    public function make_authorize($id){
        // dd(1);
        $voucher= PaymentVoucherTemp::find($id);
        if($voucher->status=="Authorize")
        {
            Gate::authorize('payment_voucher_authorize');
            $voucher->authorized_by= Auth::id();
            $voucher->status= "Approve";
            $voucher->save();
            // return $voucher;
            return back()->with('success',"Authorized!");
        }
        elseif($voucher->status=="Approve")
        {
            Gate::authorize('payment_voucher_approval');
            $payment_voucher                = new PaymentVoucher();
            $payment_voucher->type          = $voucher->type;
            $payment_voucher->cost_center_id= $voucher->cost_center_id;
            $payment_voucher->party_info_id =  $voucher->party_info_id;
            $payment_voucher->amount        = $voucher->amount;
            $payment_voucher->payment_date  = $voucher->payment_date;
            $payment_voucher->pay_mode      = $voucher->pay_mode;
            $payment_voucher->narration     =$voucher->narration;
            $payment_voucher->project_id        = $voucher->project_id;
            $payment_voucher->date        = $voucher->date;
            $payment_voucher->created_by     = $voucher->created_by;
            $payment_voucher->authorized_by     = $voucher->authorized_by;
            $payment_voucher->approved_by     = Auth::id();
            $payment_voucher->save();
            // dd($voucher);

            foreach($voucher->items as $temdet){

                $rv_details= new PaymentVoucherDetail();
                $rv_details->payment_voucher_id    =$payment_voucher->id ;
                $rv_details->invoice_id     = $temdet->invoice_id;
                $rv_details->invoice_no     = $temdet->invoice_no  ;
                $rv_details->cost_center_id = $temdet->cost_center_id;
                $rv_details->party_info_id  = $temdet->party_info_id;
                $rv_details->invoice_amount = $temdet->invoice_amount;
                $rv_details->paid_amount    = $temdet->paid_amount;
                $rv_details->payment_date   = $temdet->payment_date;
                $rv_details->pay_mode       = $temdet->pay_mode;
                $rv_details->save();

            }

        // journal entry

        $sub_invoice = Carbon::now()->format('Ymd');

        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest()->first();

        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no,0,-1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }
        $journal= new Journal();
        $journal->project_id        = $payment_voucher->project_id;
        $journal->journal_no        = $journal_no;
        $journal->date              = $payment_voucher->date;
        $journal->invoice_no        = 0;
        $journal->cost_center_id    = $payment_voucher->cost_center_id;
        $journal->party_info_id     = $payment_voucher->party_info_id;
        $journal->account_head_id   = 0;
        $journal->amount            = $payment_voucher->amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      = $payment_voucher->amount;
        $journal->narration         = $payment_voucher->narration;
        $journal->pay_mode          = $payment_voucher->pay_mode;
        $journal->voucher_type      = 'DR';
        $journal->authorized        =1;
        $journal->approved          =1;
        $journal->created_by          =Auth::id();
        $journal->authorized_by          =Auth::id();
        $journal->approved_by          =Auth::id();
        $journal->save();

        if( $payment_voucher->type=='advance'){
            $ac_head_dr= AccountHead::find(36);
        }
        elseif( $payment_voucher->type=='due'){
            $ac_head_dr= AccountHead::find(35);
        }
        if($payment_voucher->pay_mode=='Cash'){
            $ac_head_cr= AccountHead::find(1); // Cash Operating Account
        }elseif($payment_voucher->pay_mode=='Card'){
            $ac_head_cr= AccountHead::find(37); // Bank Account
        }

        $jl_record= new JournalRecord();
        $jl_record->journal_id          = $journal->id;
        $jl_record->project_details_id  =$payment_voucher->project_id;
        $jl_record->cost_center_id      = $payment_voucher->cost_center_id;
        $jl_record->party_info_id       = $payment_voucher->party_info_id;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $ac_head_dr->id;
        $jl_record->master_account_id   = $ac_head_dr->master_account_id;
        $jl_record->account_head        = $ac_head_dr->fld_ac_head;
        $jl_record->amount              =$payment_voucher->amount;
        $jl_record->transaction_type    = 'DR';
        $jl_record->journal_date        = $payment_voucher->date;
        $jl_record->save();

        $jl_record= new JournalRecord();
        $jl_record->journal_id          = $journal->id;
        $jl_record->project_details_id  = $payment_voucher->project_id;
        $jl_record->cost_center_id      =  $payment_voucher->cost_center_id;
        $jl_record->party_info_id       = $payment_voucher->party_info_id;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $ac_head_cr->id;
        $jl_record->master_account_id   = $ac_head_cr->master_account_id;
        $jl_record->account_head        = $ac_head_cr->fld_ac_head;
        $jl_record->amount              = $payment_voucher->amount;
        $jl_record->transaction_type    = 'CR';
        $jl_record->journal_date        = $payment_voucher->date;
        $jl_record->save();

        $dr_cr_voucher= new DebitCreditVoucher();
        $dr_cr_voucher->journal_id      = $journal->id;
        $dr_cr_voucher->project_id      =  $journal->project_id;
        $dr_cr_voucher->cost_center_id  =  $journal->cost_center_id ;
        $dr_cr_voucher->party_info_id   =  $journal->party_info_id;
        $dr_cr_voucher->account_head_id = 0;
        $dr_cr_voucher->pay_mode        = $journal->pay_mode;
        $dr_cr_voucher->amount          = $journal->total_amount;
        $dr_cr_voucher->narration       = $journal->narration;
        $dr_cr_voucher->type            = 'DR';
        $dr_cr_voucher->date            = $journal->date;
        $dr_cr_voucher->save();
        $voucher->items->each->delete();
        $voucher->delete();
        $notification= array(
            'message'       => 'Voucher Approved successfully!',
            'alert-type'    => 'success'
        );

        return back()->with($notification);
        }
    }

    public function appr_payment_voucher_details_modal(Request $request){
        $payment_voucher= PaymentVoucher::find($request->id);
        $words= $this->convert_number($payment_voucher->amount);
        return view('backend.new-payment-voucher.appr-payment-voucher-preview', compact('payment_voucher','words'));
    }
    public function payment_voucher_edit($id){
        Gate::authorize('payment_voucher_create');
        $payment = PaymentVoucherTemp::find($id);
        // dd($payment);
        $payment_item = PaymentVoucherDetailTemp::where('payment_voucher_temp_id', $id)->get();
        $projects = ProjectDetail::all();
        $cCenters = CostCenter::all();
        $pInfos = PartyInfo::where('pi_type','Supplier')->get();
        $modes = PayMode::all();
        $invoices= SupplierInvoice::where('pay_mode', 'Credit')->get();
        // dd($invoices);
        return view('backend.new-payment-voucher.edit', compact('projects', 'cCenters', 'pInfos','modes','invoices', 'payment', 'payment_item'));
    }
    public function update_payment_voucher(Request $request, $id){
        Gate::authorize('payment_voucher_create');
        $payment_voucher = PaymentVoucherTemp::find($id);

        $journal_amount=0;
        if($request->voucher_type=='advance'){
            $ac_head_dr= AccountHead::find(36); // Accrued liability/ Need to define account head
            $payment_voucher                = PaymentVoucherTemp::find($id);
            $payment_voucher->type          = $request->voucher_type;
            $payment_voucher->cost_center_id= $request->cost_center_name;
            $payment_voucher->party_info_id = $request->party_info;
            $payment_voucher->amount        = $request->total_amount;
            $payment_voucher->payment_date  = $request->date;
            $payment_voucher->pay_mode      = $request->pay_mode;
            $payment_voucher->narration     = $request->remark;
            $payment_voucher->date          = $request->date;
            $payment_voucher->project_id    = $request->project;
            $payment_voucher->authorized_by = 0;
            $payment_voucher->status        = "Authorize";
            $payment_voucher->save();
            $journal_amount = $request->total_amount;
        }elseif($request->voucher_type=='due'){
            $ac_head_dr= AccountHead::find(35); // Accounts Payable
            $amount=0;
            foreach($request->input('group-a') as $each_inv){
                $amount= $amount+ $each_inv['payment_amount'];
            }
            $journal_amount = $amount;

            $payment_voucher                = PaymentVoucherTemp::find($id);
            $payment_voucher->type          = $request->voucher_type;
            $payment_voucher->cost_center_id= $request->cost_center_name;
            $payment_voucher->party_info_id = $request->party_info;
            $payment_voucher->amount        = $amount;
            $payment_voucher->payment_date  = $request->date;
            $payment_voucher->pay_mode      = $request->pay_mode;
            $payment_voucher->narration     = $request->remark;
            $payment_voucher->date          = $request->date;
            $payment_voucher->project_id    = $request->project;
            $payment_voucher->authorized_by = 0;
            $payment_voucher->status        = "Authorize";
            $save = $payment_voucher->save();
            if($save){
                $pre_payment_details = PaymentVoucherDetailTemp::where('payment_voucher_temp_id', $id)->get();
                foreach($pre_payment_details as $pre_payment_detail){
                    $inv_details = SupplierInvoice::where('invoice_no', $pre_payment_detail->invoice_no)->first();
                    $inv_details->paid_amount   = $inv_details->paid_amount - $pre_payment_detail->paid_amount;
                    $inv_details->due_amount    = $inv_details->due_amount + $pre_payment_detail->paid_amount;
                    $inv_details->save();
                    $pre_payment_detail->delete();
                }
            }
            foreach($request->input('group-a') as $each_inv){
                // dd($request->input('group-a'));
                $inv_details= SupplierInvoice::where('invoice_no', $each_inv['invoice_no'])->first();
                if($inv_details){
                    $rv_details= new PaymentVoucherDetailTemp();
                    $rv_details->payment_voucher_temp_id    = $payment_voucher->id;
                    $rv_details->invoice_id     = $inv_details->id;
                    $rv_details->invoice_no     = $each_inv['invoice_no'];
                    $rv_details->cost_center_id = $request->cost_center_name;
                    $rv_details->party_info_id  = $request->party_info;
                    $rv_details->invoice_amount = $inv_details->amount+$inv_details->vat_amount;
                    $rv_details->paid_amount    = $each_inv['payment_amount'];
                    $rv_details->payment_date   = $request->date;
                    $rv_details->pay_mode       = $request->pay_mode;
                    $rv_details->save();

                    $current_paid_ammount       = $inv_details->paid_amount + $each_inv['payment_amount'];
                    $inv_details->paid_amount   = $current_paid_ammount;
                    $inv_details->due_amount    = ($inv_details->amount + $inv_details->vat_amount) -$current_paid_ammount;
                    $inv_details->save();
                }
            }
        }
        if($payment_voucher->authorized_by == 0){
            return redirect('authorize-payment-voucher-list')->with('success',"Successfully Update");
        }else{
            return redirect('approval-payment-voucher-list')->with('success',"Successfully Updated");
        }
    }
    public function payment_voucher_reject_list(Request $request){
        Gate::authorize('payment_voucher_approval');
        $payment_vouchers= PaymentVoucherTemp::where('status',"Rejected")->get();
        return view('backend.new-payment-voucher.pre-payment-voucher-list', compact('payment_vouchers'));
    }
    public function payment_voucher_rejected($id){
        $payment = PaymentVoucherTemp::find($id);
        $payment->status = "Rejected";
        $payment->save();
        return back()->with('success',"Successfully Rejected");
    }
}
