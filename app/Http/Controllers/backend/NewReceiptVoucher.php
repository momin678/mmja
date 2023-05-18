<?php

namespace App\Http\Controllers\backend;

use App\DebitCreditVoucher;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Journal;
use App\JournalRecord;
use App\JournalRecordsTemp;
use App\JournalTemp;
use App\Models\AccountHead;
use App\Models\CostCenter;
use App\PartyInfo;
use App\PayMode;
use App\ProjectDetail;
use App\ReceiptVoucher;
use App\ReceiptVoucherDetail;
use App\ReceiptVoucherDetailTemp;
use App\ReceiptVoucherTemp;
use App\TaxInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Auth;

class NewReceiptVoucher extends Controller
{
    public function receipt_voucher_form(){
        $projects = ProjectDetail::all();
        $cCenters = CostCenter::all();
        $pInfos = PartyInfo::where('pi_type','Customer')->get();
        $modes = PayMode::all();
        // $invoices= TaxInvoice::where('pay_mode', 'Credit')->orWhere('due_amount','>',0)->get();
        $invoices= Invoice::where('pay_mode', 'credit')->get();
        
        $receipt_vouchers= ReceiptVoucherTemp::all();

        return view('backend.new-receipt-voucher.new-create', compact('projects', 'cCenters', 'pInfos','modes','invoices','receipt_vouchers'));
    }

    public function receipt_voucher_list(Request $request){
        $receipt_vouchers= ReceiptVoucher::all();
        return view('backend.new-receipt-voucher.receipt-voucher-list', compact('receipt_vouchers'));
    }


    public function get_invoice_details(Request $request){
        
        $invoice_data= TaxInvoice::where('invoice_no', $request->invoice_no)->first();
        $due_amount= ReceiptVoucherDetailTemp::where('invoice_no',$request->invoice_no)->sum('paid_amount');
        
        return Response()->json([
            'invoice_amount' => ($invoice_data->amount+$invoice_data->vat_amount),
            'due_amount' => ($invoice_data->due_amount >0 ? $invoice_data->due_amount: ($invoice_data->amount+$invoice_data->vat_amount-$due_amount)),
        ]);
    }

    public function receipt_voucher_store(Request $request){
        // return $request;    //TotalAmount     
        
        $journal_amount=0;
        if($request->voucher_type=='advance'){

            // $ac_head_cr= AccountHead::find(36); // Accrued liability

            $receipt_voucher                = new ReceiptVoucherTemp;
            $receipt_voucher->type          = $request->voucher_type;
            $receipt_voucher->project_id    = $request->project;
            $receipt_voucher->cost_center_id= $request->cost_center_name;
            $receipt_voucher->party_info_id = $request->party_info;
            $receipt_voucher->amount        = $request->total_amount;
            $receipt_voucher->payment_date  = $request->date;
            $receipt_voucher->pay_mode      = $request->pay_mode;
            $receipt_voucher->narration     = $request->remark;
            $receipt_voucher->status     = 'authorize';
            $receipt_voucher->created_by    = Auth::id();


            $receipt_voucher->save();
            $journal_amount = $request->total_amount;

        }elseif($request->voucher_type=='due'){
            // $ac_head_cr= AccountHead::find(33); // Accounts Receivable

            $amount=0;
            foreach($request->input('group-a') as $each_inv){
                $amount= $amount+ $each_inv['payment_amount'];
            }
            $journal_amount = $amount;            

            $receipt_voucher                = new ReceiptVoucherTemp;
            $receipt_voucher->type          = $request->voucher_type;
            $receipt_voucher->project_id    = $request->project;
            $receipt_voucher->cost_center_id= $request->cost_center_name;
            $receipt_voucher->party_info_id = $request->party_info;
            $receipt_voucher->amount        = $amount;
            $receipt_voucher->payment_date  = $request->date;
            $receipt_voucher->pay_mode      = $request->pay_mode;
            $receipt_voucher->narration     = $request->remark;
            $receipt_voucher->created_by    = Auth::id();
            $receipt_voucher->status     = 'authorize';

            $receipt_voucher->save();

            foreach($request->input('group-a') as $each_inv){
                $inv_details= TaxInvoice::where('invoice_no', $each_inv['invoice_no'])->first();

                $rv_details= new ReceiptVoucherDetailTemp();
                $rv_details->receipt_voucher_temp_id    = $receipt_voucher->id; 
                $rv_details->invoice_id     = $inv_details->id;
                $rv_details->invoice_no     = $each_inv['invoice_no'];
                $rv_details->cost_center_id = $request->cost_center_name;
                $rv_details->party_info_id  = $request->party_info;
                $rv_details->invoice_amount = $inv_details->amount+$inv_details->vat_amount;
                $rv_details->paid_amount    = $each_inv['payment_amount'];
                $rv_details->payment_date   = $request->date;
                $rv_details->pay_mode       = $request->pay_mode;
                $rv_details->save();

                // $current_paid_ammount       = $inv_details->paid_amount + $each_inv['payment_amount'];
                // $inv_details->paid_amount   = $current_paid_ammount;
                // $inv_details->due_amount    = ($inv_details->amount + $inv_details->vat_amount) -$current_paid_ammount;
                // $inv_details->save();

            }
        }

        // journal entry 

        // $sub_invoice = Carbon::now()->format('Ymd');

        // $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest()->first();
        
        // if ($latest_journal_no) {
        //     $journal_no = substr($latest_journal_no->journal_no,0,-1);
        //     $journal_code = $journal_no + 1;
        //     $journal_no = $journal_code . "J";
        // } else {
        //     $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        // }
        // $journal= new Journal();
        // $journal->project_id        = $request->project;
        // $journal->journal_no        = $journal_no;
        // $journal->date              = $request->date;
        // $journal->invoice_no        = 0;
        // $journal->cost_center_id    = $request->cost_center_name;
        // $journal->party_info_id     = $request->party_info;
        // $journal->account_head_id   = 0;
        // $journal->amount            = $journal_amount;
        // $journal->tax_rate          = 0;
        // $journal->vat_amount        = 0;
        // $journal->total_amount      = $journal_amount;
        // $journal->narration         = $request->remark;
        // $journal->pay_mode          = $request->pay_mode;
        // $journal->voucher_type      = 'CR';
        // $journal->save();
        
        // if($request->pay_mode=='Cash'){
        //     $ac_head_dr= AccountHead::find(1); // Cash Operating Account           
        // }elseif($request->pay_mode=='Card'){
        //     $ac_head_dr= AccountHead::find(37); // Bank Account
        // }

        // $jl_record= new JournalRecord();
        // $jl_record->journal_id          = $journal->id;
        // $jl_record->project_details_id  = $request->project;
        // $jl_record->cost_center_id      = $request->cost_center_name;
        // $jl_record->party_info_id       = $request->party_info;
        // $jl_record->journal_no          = $journal_no;
        // $jl_record->account_head_id     = $ac_head_dr->id;
        // $jl_record->master_account_id   = $ac_head_dr->master_account_id;
        // $jl_record->account_head        = $ac_head_dr->fld_ac_head;
        // $jl_record->amount              = $journal_amount;
        // $jl_record->transaction_type    = 'DR';
        // $jl_record->journal_date        = $request->date;
        // $jl_record->save();

        // $jl_record= new JournalRecord();
        // $jl_record->journal_id          = $journal->id;
        // $jl_record->project_details_id  = $request->project;
        // $jl_record->cost_center_id      = $request->cost_center_name;
        // $jl_record->party_info_id       = $request->party_info;
        // $jl_record->journal_no          = $journal_no;
        // $jl_record->account_head_id     = $ac_head_cr->id;
        // $jl_record->master_account_id   = $ac_head_cr->master_account_id;
        // $jl_record->account_head        = $ac_head_cr->fld_ac_head;
        // $jl_record->amount              = $journal_amount;
        // $jl_record->transaction_type    = 'CR';
        // $jl_record->journal_date        = $request->date;
        // $jl_record->save();

        // $dr_cr_voucher= new DebitCreditVoucher();
        // $dr_cr_voucher->journal_id      = $journal->id;
        // $dr_cr_voucher->project_id      =  $journal->project_id;
        // $dr_cr_voucher->cost_center_id  = 1;
        // $dr_cr_voucher->party_info_id   =  $journal->party_info_id;
        // $dr_cr_voucher->account_head_id = 0;
        // $dr_cr_voucher->pay_mode        = $journal->pay_mode;
        // $dr_cr_voucher->amount          = $journal->total_amount;
        // $dr_cr_voucher->narration       = $journal->narration;
        // $dr_cr_voucher->type            = 'CR';
        // $dr_cr_voucher->date            = $journal->date;
        // $dr_cr_voucher->save();

        return back()->with('success',"Successfully Added");
    }

    public function receipt_voucher_print($id){
        $receipt_voucher= ReceiptVoucherTemp::find($id);

        $words= $this->convert_number($receipt_voucher->amount);

        return view('backend.new-receipt-voucher.print', compact('receipt_voucher','words'));
    }

    public function receipt_voucher_details_modal(Request $request){
        $voucher= ReceiptVoucher::find($request->id);
        $words= $this->convert_number($voucher->amount);
        return view('backend.new-receipt-voucher.receipt-voucher-preview', compact('voucher','words'));
    }
    public function receipt_voucher_view_pdf($id){
        $receipt_voucher= ReceiptVoucherTemp::find($id);
        $words= $this->convert_number($receipt_voucher->amount);
        $pdf = PDF::loadView('backend.new-receipt-voucher.receipt-voucher-pdf', compact('receipt_voucher', 'words'));
        return $pdf->download('recept-voucher.pdf');
        // return view('backend.new-receipt-voucher.receipt-voucher-pdf', compact('receipt_voucher','words'));
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

    public function voucher_authorize(Request $request){
        $vouchers= ReceiptVoucherTemp::where('authorized_by',0)->where('status', '!=', 'Rejected')->latest()->get();
        return view('backend.new-receipt-voucher.voucher-authorize', compact('vouchers'));
    }

    public function authorize_modal(Request $request){
        // return "Alhamdulillah";
        $voucher= ReceiptVoucherTemp::find($request->id);
        if(!$voucher)
        {
            return back()->with('error', "Not Found");
        }
       return view('backend.new-receipt-voucher.authorize-modal', compact('voucher'));
    }

    public function approval_modal(Request $request){
        $voucher= ReceiptVoucherTemp::find($request->id);
        if(!$voucher)
        {
            return back()->with('error', "Not Found");
        }
       return view('backend.new-receipt-voucher.approval-modal', compact('voucher'));
    }

    public function make_authorize($id){
        $voucher= ReceiptVoucherTemp::find($id);
        $voucher->authorized_by= Auth::id();
        $voucher->save();
        // return $voucher;
        return back()->with('success',"Authorized!");
    }

    public function make_approve($id){
        // dd(1);
        $voucher= ReceiptVoucherTemp::find($id);
        

        $receipt_voucher= new ReceiptVoucher;
        $receipt_voucher->type          = $voucher->type;
        $receipt_voucher->cost_center_id= $voucher->cost_center_id;
        $receipt_voucher->party_info_id = $voucher->party_info_id;
        $receipt_voucher->amount        = $voucher->amount;
        $receipt_voucher->payment_date  = $voucher->payment_date;
        $receipt_voucher->pay_mode      = $voucher->pay_mode;
        $receipt_voucher->narration     = $voucher->narration;
        $receipt_voucher->authorized_by = $voucher->authorized_by;
        $receipt_voucher->approved_by   = Auth::id();
        $receipt_voucher->save();

        $temp_details= ReceiptVoucherDetailTemp::where('receipt_voucher_temp_id', $voucher->id)->get();
        
        // return $temp_details;
        foreach($temp_details as $each_item){
            
            $rv_details= new ReceiptVoucherDetail();
            $rv_details->receipt_voucher_id    = $receipt_voucher->id; 
            $rv_details->invoice_id     = $each_item->invoice_id;
            $rv_details->invoice_no     = $each_item->invoice_no;
            $rv_details->cost_center_id = $each_item->cost_center_id;
            $rv_details->party_info_id  = $each_item->party_info_id;
            $rv_details->invoice_amount = $each_item->invoice_amount;
            $rv_details->paid_amount    = $each_item->paid_amount;
            $rv_details->payment_date   = $each_item->payment_date;
            $rv_details->pay_mode       = $each_item->pay_mode;
            $rv_details->save();

            $inv_details= TaxInvoice::where('invoice_no', $each_item->invoice_no)->first();
            $current_paid_ammount       = $inv_details->paid_amount + $each_item->paid_amount;
            $inv_details->paid_amount   = $current_paid_ammount;
            $inv_details->due_amount    = ($inv_details->amount + $inv_details->vat_amount) -$current_paid_ammount;
            $inv_details->save();

            // delete voucher detail from temp table
            $each_item->delete();
        }

        if($voucher->type=='advance'){
            $ac_head_cr= AccountHead::find(36); // Accrued liability
        }elseif($voucher->type=='due'){
            $ac_head_cr= AccountHead::find(33); // Accounts Receivable  
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
        $journal->project_id        = $voucher->project_id;
        $journal->journal_no        = $journal_no;
        $journal->date              = $voucher->payment_date;
        $journal->invoice_no        = 0;
        $journal->cost_center_id    = $voucher->cost_center_id;
        $journal->party_info_id     = $voucher->party_info_id;
        $journal->account_head_id   = 0;
        $journal->amount            = $voucher->amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      = $voucher->amount;
        $journal->narration         = $voucher->narration;
        $journal->pay_mode          = $voucher->pay_mode;
        $journal->voucher_type      = 'CR';
        $journal->authorized        =1;
        $journal->approved          =1;
        $journal->created_by          =Auth::id();
        $journal->authorized_by          =Auth::id();
        $journal->approved_by          =Auth::id();
        $journal->save();
        
        if($voucher->pay_mode=='Cash'){
            $ac_head_dr= AccountHead::find(1); // Cash Operating Account           
        }elseif($voucher->pay_mode=='Card'){
            $ac_head_dr= AccountHead::find(37); // Bank Account
        }

        $jl_record= new JournalRecord();
        $jl_record->journal_id          = $journal->id;
        $jl_record->project_details_id  = $voucher->project_id;
        $jl_record->cost_center_id      = $voucher->cost_center_id;
        $jl_record->party_info_id       = $voucher->party_info_id;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $ac_head_dr->id;
        $jl_record->master_account_id   = $ac_head_dr->master_account_id;
        $jl_record->account_head        = $ac_head_dr->fld_ac_head;
        $jl_record->amount              = $voucher->amount;
        $jl_record->transaction_type    = 'DR';
        $jl_record->journal_date        = $voucher->payment_date;
        $jl_record->save();

        $jl_record= new JournalRecord();
        $jl_record->journal_id          = $journal->id;
        $jl_record->project_details_id  = $voucher->project_id;
        $jl_record->cost_center_id      = $voucher->cost_center_id;
        $jl_record->party_info_id       = $voucher->party_info_id;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $ac_head_cr->id;
        $jl_record->master_account_id   = $ac_head_cr->master_account_id;
        $jl_record->account_head        = $ac_head_cr->fld_ac_head;
        $jl_record->amount              = $voucher->amount;
        $jl_record->transaction_type    = 'CR';
        $jl_record->journal_date        = $voucher->payment_date;
        $jl_record->save();

        $dr_cr_voucher= new DebitCreditVoucher();
        $dr_cr_voucher->journal_id      = $journal->id;
        $dr_cr_voucher->project_id      = $journal->project_id;
        $dr_cr_voucher->cost_center_id  = $voucher->cost_center_id;
        $dr_cr_voucher->party_info_id   = $journal->party_info_id;
        $dr_cr_voucher->account_head_id = 0;
        $dr_cr_voucher->pay_mode        = $journal->pay_mode;
        $dr_cr_voucher->amount          = $journal->total_amount;
        $dr_cr_voucher->narration       = $journal->narration;
        $dr_cr_voucher->type            = 'CR';
        $dr_cr_voucher->date            = $journal->date;
        $dr_cr_voucher->save();

        // delete voucher from temp
        $voucher->delete();

        return back()->with('success',"Successfully Added");
    }
    
    public function voucher_approval(Request $request){
        $vouchers= ReceiptVoucherTemp::where('authorized_by', '!=', 0)->where('status', '!=', 'Rejected')->where('approved_by',0)->latest()->get();
        return view('backend.new-receipt-voucher.voucher-approval', compact('vouchers'));
    } 
    public function receipt_voucher_edit($id){
        $voucher= ReceiptVoucherTemp::find($id);
        $voucher_item= ReceiptVoucherDetailTemp::where('receipt_voucher_temp_id', $id)->get();
        $projects = ProjectDetail::all();
        $cCenters = CostCenter::all();
        $pInfos = PartyInfo::where('pi_type','Customer')->get();
        $modes = PayMode::all();
        $invoices= TaxInvoice::where('pay_mode', 'Credit')->orWhere('due_amount','>',0)->get();
        return view('backend.new-receipt-voucher.edit-receipt-voucher', compact('projects', 'cCenters', 'pInfos','modes','invoices', 'voucher', 'voucher_item'));
    }
    public function update_receipt_voucher(Request $request , $id){
        $receipt_voucher= ReceiptVoucherTemp::find($id);
        $journal_amount=0;
        if($request->voucher_type=='advance'){
            $receipt_voucher                = ReceiptVoucherTemp::find($id);
            $receipt_voucher->type          = $request->voucher_type;
            $receipt_voucher->project_id    = $request->project;
            $receipt_voucher->cost_center_id= $request->cost_center_name;
            $receipt_voucher->party_info_id = $request->party_info;
            $receipt_voucher->amount        = $request->total_amount;
            $receipt_voucher->payment_date  = $request->date;
            $receipt_voucher->pay_mode      = $request->pay_mode;
            $receipt_voucher->narration     = $request->remark;
            $receipt_voucher->authorized_by = 0;
            $receipt_voucher->status        = "Draft";
            $receipt_voucher->save();
            
            $journal_amount = $request->total_amount;
        }elseif($request->voucher_type=='due'){
            $amount=0;
            foreach($request->input('group-a') as $each_inv){
                $amount= $amount+ $each_inv['payment_amount'];
            }
            $journal_amount = $amount;            

            $receipt_voucher                = ReceiptVoucherTemp::find($id);
            $receipt_voucher->type          = $request->voucher_type;
            $receipt_voucher->project_id    = $request->project;
            $receipt_voucher->cost_center_id= $request->cost_center_name;
            $receipt_voucher->party_info_id = $request->party_info;
            $receipt_voucher->amount        = $amount;
            $receipt_voucher->payment_date  = $request->date;
            $receipt_voucher->pay_mode      = $request->pay_mode;
            $receipt_voucher->authorized_by = 0;
            $receipt_voucher->status        = "Draft";
            $receipt_voucher->narration     = $request->remark;
            $save = $receipt_voucher->save();
            if($save){
                ReceiptVoucherDetailTemp::where('receipt_voucher_temp_id',$id)->delete();
            }
            foreach($request->input('group-a') as $each_inv){
                $inv_details= TaxInvoice::where('invoice_no', $each_inv['invoice_no'])->first();
                if($inv_details){
                    $rv_details= new ReceiptVoucherDetailTemp();
                    $rv_details->receipt_voucher_temp_id    = $receipt_voucher->id; 
                    $rv_details->invoice_id     = $inv_details->id;
                    $rv_details->invoice_no     = $each_inv['invoice_no'];
                    $rv_details->cost_center_id = $request->cost_center_name;
                    $rv_details->party_info_id  = $request->party_info;
                    $rv_details->invoice_amount = $inv_details->amount+$inv_details->vat_amount;
                    $rv_details->paid_amount    = $each_inv['payment_amount'];
                    $rv_details->payment_date   = $request->date;
                    $rv_details->pay_mode       = $request->pay_mode;
                    $rv_details->save();
                }
            }
        }
        if($receipt_voucher->authorized_by == 0){
            return redirect('receipt-voucher-authorize')->with('success',"Successfully Updated");
        }else{
            return redirect('receipt-voucher-approval')->with('success',"Successfully Updated");
        }
    }
    public function receipt_voucher_reject_list(){
        $vouchers= ReceiptVoucherTemp::where('status', 'Rejected')->get();
        return view('backend.new-receipt-voucher.voucher-rejected', compact('vouchers'));
    }
    public function receipt_voucher_rejected($id){
        $voucher= ReceiptVoucherTemp::find($id);
        $voucher->status = "Rejected";
        $voucher->save();
        return back()->with('success',"Voucher Rejected");
    }
}
