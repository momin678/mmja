<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\JournalRecordsTemp;
use Illuminate\Http\Request;

class AccountsReportController extends Controller
{
    public function general_ledger(){
        return view('backend.accounts-report.general-ledger');
    }

    public function general_ledger_by_date_range(Request $request){
        $from=$request->from;
        $to=$request->to;
        return view('backend.accounts-report.general-ledger-by-date-range',compact('from','to'));
    }

    public function general_ledger_by_date(Request $request){
        $date=$request->date;
        return view('backend.accounts-report.general-ledger-by-date',compact('date'));
    }

    public function general_ledger_print(){
        return view('backend.accounts-report.print-general-ledger');
    }
    public function general_ledger_print_date(Request $request){
        $date=$request->date;
        return view('backend.accounts-report.print-gl-date', compact('date'));
    }

    public function general_ledger_print_date_range(){
        return view('backend.accounts-report.print-gl-date-range');
    }

    public function trial_balance(){
        return view('backend.accounts-report.trial-balance');
    }

    public function trial_balance_date(Request $request){
        $date=$request->date;
        return view('backend.accounts-report.trial-balance-date', compact('date'));  
    }

    public function trial_balance_date_range(Request $request){
        $from=$request->from;
        $to=$request->to;
        return view('backend.accounts-report.trial-balance-date-range', compact('from','to'));  
    }

    public function trial_balance_print(){
        return view('backend.accounts-report.print-trial-balance');
    }

    public function trial_balance_print_date($date){
        return view('backend.accounts-report.print-trial-balance-date',compact('date'));
    }

    public function trial_balance_print_date_range($from,$to){
        return view('backend.accounts-report.print-trial-balance-date-range',compact('from','to'));
    }

    public function ac_payable_ledger(Request $request){
        $ac_payable_id=35;
        if($request->has('date')){
            $date= $request->date;
            return view('backend.accounts-report.ac-payable-ledger', compact('ac_payable_id','date'));
        }elseif($request->hasAny(['from','to'])){
            $from= $request->from;
            $to= $request->to;
            return view('backend.accounts-report.ac-payable-ledger', compact('ac_payable_id','from','to'));
        }
        return view('backend.accounts-report.ac-payable-ledger', compact('ac_payable_id'));
    }


    public function ac_receivable_ledger(Request $request){
        $ac_payable_id=33;
        if($request->has('date')){
            $date= $request->date;
            return view('backend.accounts-report.ac-receivable-ledger', compact('ac_payable_id','date'));
        }elseif($request->hasAny(['from','to'])){
            $from= $request->from;
            $to= $request->to;
            return view('backend.accounts-report.ac-receivable-ledger', compact('ac_payable_id','from','to'));
        }
        return view('backend.accounts-report.ac-receivable-ledger', compact('ac_payable_id'));
    }
    
    // work by mominul
    public function new_general_ledger(Request $request){
        return view('backend.accounts-report.new-index');
    }
    public function new_general_ledger_by_date_range(Request $request){
        $from=$request->from;
        $to=$request->to;
        return view('backend.accounts-report.new-index-by-date-range',compact('from','to'));
    }
    public function new_general_ledger_by_date(Request $request){
        $date=$request->date;
        return view('backend.accounts-report.new-index-by-date', compact('date'));
    }
    public function new_trial_balance(Request $request){
        return view('backend.accounts-report.new-trial-balance');
    }
    public function new_trial_balance_date(Request $request){
        $date=$request->date;
        return view('backend.accounts-report.new-trial-balance-date', compact('date'));
    }
    public function new_trial_balance_date_range(Request $request){
        $from=$request->from;
        $to=$request->to;
        return view('backend.accounts-report.new-trial-balance-date-range', compact('from','to'));  
    }
    public function new_accounts_payable_ledger(Request $request){
        $ac_payable_id=35;
        if($request->has('date')){
            $date= $request->date;
            return view('backend.accounts-report.new-ac-payable-ledger', compact('ac_payable_id','date'));
        }elseif($request->hasAny(['from','to'])){
            $from= $request->from;
            $to= $request->to;
            return view('backend.accounts-report.new-ac-payable-ledger', compact('ac_payable_id','from','to'));
        }
        return view('backend.accounts-report.new-ac-payable-ledger', compact('ac_payable_id'));
    }
    public function new_accounts_receivable_ledger(Request $request){
        $ac_payable_id=33;
        if($request->has('date')){
            $date= $request->date;
            return view('backend.accounts-report.new-ac-receivable-ledger', compact('ac_payable_id','date'));
        }elseif($request->hasAny(['from','to'])){
            $from= $request->from;
            $to= $request->to;
            return view('backend.accounts-report.new-ac-receivable-ledger', compact('ac_payable_id','from','to'));
        }
        return view('backend.accounts-report.new-ac-receivable-ledger', compact('ac_payable_id'));
    }
    
     //work by tarek
    public function new_general_filter(Request $request){
        // dd($request->all());
        $date=$request->date;
        $acc_head=$request->head;

        return view('backend.accounts-report.new-index-date-filter', compact('date','acc_head'));
    }

    public function new_general_filter_all(Request $request){

        $acc_head=$request->head;

        return view('backend.accounts-report.new-index-filter', compact('acc_head'));
    }

    public function new_general_filter_range(Request $request){
        // dd($request->all());
        $from=$request->from;
        $to=$request->to;
        $acc_head=$request->head;

        return view('backend.accounts-report.new-index-range-filter', compact('from','to','acc_head'));
    }

    public function customer_balance(){
        $invoicess=Invoice::groupBy('customer_name')
        ->selectRaw('customer_name, sum(grand_total) as total_invoice_amount')
        ->where('pay_mode','Credit')->get();
        return view('backend.receivableReport.customer-balance',compact('invoicess'));
    }

    public function customer_invoice_report(Request $request){
        $customer_id= $request->id;
        $invoices= Invoice::where('customer_name', $customer_id)->where('pay_mode', "Credit")->get();

        if(!$invoices)
        {
            return back()->with('error', "Not Found");
        }

        return view('backend.receivableReport.customer-invoice-list-modal',compact('invoices'));
    }

    public function invoice_view_modal(Request $request){
        $invoice = Invoice::where('invoice_no', $request->id)->first();
        if ($invoice->taxbleSup($invoice->invoice_no) > 9999) {
            return view('backend.pdf.invoice', compact('invoice'));
        } else {
            return view('backend.pdf.invoice2', compact('invoice'));
        }
    }

}
