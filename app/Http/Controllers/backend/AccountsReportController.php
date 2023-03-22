<?php

namespace App\Http\Controllers\backend;

use App\Exports\InvoiceExport;
use App\Exports\PurchaseDetailsExport;
use App\Exports\PurchaseExport;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceItem;
use App\JournalRecordsTemp;
use App\PartyInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\ItemList;
use App\Models\AccountHead;
use App\Purchase;
use App\PurchaseReturn;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\App;

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


    public function ar_ageing_summary(){
        // return "Alhamdulillah";

        $parties= DB::table('party_infos as tb1')
        ->rightJoin('invoices as tb2', 'tb1.pi_code', '=', 'tb2.customer_name')
        ->select('tb1.id', 'tb1.pi_code','tb1.pi_name', 
        DB::raw("SUM(tb2.grand_total) as gtotal"),
        DB::raw("SUM(IF(tb2.due_date =CURDATE(), tb2.grand_total, 0 )) as current"),
        DB::raw("SUM(IF(tb2.due_date BETWEEN DATE_SUB('2023-03-10', INTERVAL 14 DAY) AND '2023-03-10', tb2.grand_total, 0 )) as 'days_1_15'"),
        DB::raw("SUM(IF(tb2.due_date BETWEEN DATE_SUB('2023-03-10', INTERVAL 29 DAY) AND DATE_SUB('2023-03-10', INTERVAL 15 DAY), tb2.grand_total, 0)) as 'days_16_30'"),
        DB::raw("SUM(IF(tb2.due_date BETWEEN DATE_SUB('2023-03-10', INTERVAL 44 DAY) AND DATE_SUB('2023-03-10', INTERVAL 30 DAY), tb2.grand_total, 0)) as 'days_31_45'"),
        DB::raw("SUM(IF(tb2.due_date BETWEEN DATE_SUB('2023-03-10', INTERVAL 59 DAY) AND DATE_SUB('2023-03-10', INTERVAL 45 DAY), tb2.grand_total, 0)) as 'days_46_60'"),
        DB::raw("SUM(IF(tb2.due_date < DATE_SUB('2023-03-10', INTERVAL 60 DAY), tb2.grand_total, 0)) as 'days_up_60'")
        )
        ->where('tb1.pi_type', 'Customer')
        ->groupBy('tb2.customer_name')
        ->get();

        // return $query;
        return view('backend.receivableReport.ar-ageing-summary',compact('parties'));

    }

    public function ar_ageing_summary_one($id){
        $partyinfo= PartyInfo::find($id);
        $invoices= Invoice::where('customer_name', $partyinfo->pi_code)->orderBy('due_date', 'desc')->get();
        // return $invoices;
        return view('backend.receivableReport.ar-ageing-summary-one',compact('invoices','partyinfo'));
    }

    public function ar_ageing_details(){
        $invoices= Invoice::orderBy('due_date', 'desc')->get();
        // return $invoices;
        return view('backend.receivableReport.ar-ageing-details2',compact('invoices'));
    }

    public function receivable_summary(){
        $invoices= Invoice::orderBy('due_date', 'desc')->paginate(25)->withQueryString();
        return view('backend.receivableReport.receivable-summary',compact('invoices'));
    }

    public function receivable_details($id){
        $party_info= PartyInfo::find($id);
        $invoices= Invoice::where('customer_name', $party_info->pi_code)->orderBy('due_date', 'desc')->paginate(25)->withQueryString();
        return view('backend.receivableReport.receivable-details',compact('invoices', 'party_info'));
    }
    // Mominul Account Report
    public function customer_balance_summary(Request $request){
        $customers = DB::table('invoices')->select('customer_name')->groupBy('customer_name')->paginate(25);
        return view('backend.receivableReport.customer-balance-summary',compact('customers'));
    }
    public function customer_summary_details(Request $request){
        $party = PartyInfo::where('pi_code', $request->id)->first();
        $invoices = Invoice::where('customer_name', $request->id)->select('id','invoice_no', 'date')
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->date)->format('m'); // grouping by months
        });
        $amount_list = [];
        $date_list = [];
        foreach($invoices as $key => $invoice){
            $amount = 0;
            $date = null;
            foreach($invoice as $key => $item){
                $amount += InvoiceItem::where('invoice_no', $item->invoice_no)->sum('cost_price');
                $date = Carbon::parse($item->date)->format('M-Y');
            }
            array_push($amount_list, $amount);
            array_push($date_list, $date);
        }
        return view('backend.receivableReport.customer-summary-details', compact('party', 'invoices', 'amount_list', 'date_list'));
    }
    public function tax_invoice_detail(Request $request){
        $invoicess = Invoice::where('invoice_from','Counter Sale')->orderBy('id','DESC');
        if($request->date_from && $request->date_to){
            $invoicess = $invoicess->whereBetween('date', [$request->date_from, $request->date_to]);
        }
        if($request->date){
            $invoicess = $invoicess->where('date', $request->date);
        }
        $invoicess = $invoicess->paginate(25)->withQueryString();
        return view('backend.receivableReport.invoice-details',compact('invoicess'));
    }
    public function customer_order(Request $request){
        $invoicess = Invoice::where('invoice_from','Counter Sale')->orderBy('id','DESC');
        if($request->date_from && $request->date_to){
            $invoicess = $invoicess->whereBetween('date', [$request->date_from, $request->date_to]);
        }
        if($request->date){
            $invoicess = $invoicess->where('date', $request->date);
        }
        $invoicess = $invoicess->paginate(25)->withQueryString();
        return view('backend.receivableReport.customer-order',compact('invoicess'));
    }

    // previous
    public function vendor_balances(Request $request){
        $customers = PartyInfo::where('pi_type', 'Supplier')->get();
        return view('backend.payables.vendor-balances',compact('customers'));
    }
    public function vendor_balances_details(Request $request){
        $vendor = PartyInfo::find($request->id);
        $purchases = Purchase::where('supplier_id', $request->id)->get();
        return view('backend.payables.vendor-balances-details', compact('vendor', 'purchases'));
    }
    public function vendor_balance_summary(Request $request){
        $customers = PartyInfo::where('pi_type', 'Supplier')->get();
        return view('backend.payables.vendor-balance-summary',compact('customers'));
    }
    public function bills_details(Request $request){
        $purchases = Purchase::orderBy('id', 'desc')->get();
        return view('backend.payables.bills-details',compact('purchases'));
    }
    public function vendor_debit_details(Request $request){
        $returns = PurchaseReturn::orderBy('id', 'desc')->get();
        return view('backend.payables.vendor-debit-details',compact('returns'));
    }
    public function purchase_order_details(Request $request){
        $purchases = Purchase::orderBy('id', 'desc')->get();
        return view('backend.payables.purchase-order-details',compact('purchases'));
    }
    public function purchase_order_by_vendor(Request $request){
        $customers = PartyInfo::where('pi_type', 'Supplier')->get();
        return view('backend.payables.purchase-order-by-vendor',compact('customers'));
    }
    public function purchase_by_vendor(Request $request){
        $customers = PartyInfo::where('pi_type', 'Supplier')->get();
        return view('backend.payables.purchase-by-vendor',compact('customers'));
    }
    public function purchase_by_item(Request $request){
        $items = ItemList::all();
        return view('backend.payables.purchase-by-item',compact('items'));
    }
    public function expenses_details(Request $request){
        $accounts = AccountHead::all();
        return view('backend.payables.expenses-details',compact('accounts'));
    }
    // new
    public function ar_ageing_pdf_download(Request $request){
        $invoices = Invoice::all();
        $pdf = PDF::loadView('backend.receivableReport.ar-ageing-pdf', compact('invoices'));
        $test = $pdf->download('ar-dgeing-details.pdf');
        dd($test);
    }
    public function ar_ageing_excel_download(Request $request){
        $reports =  Excel::download(new InvoiceExport, 'invoices.xlsx');
        return $reports;
    }
    public function vendor_balance_details_pdf_download($id){
        $vendor = PartyInfo::find($id);
        $purchases = Purchase::where('supplier_id', $id)->get();
        $pdf = PDF::loadView('backend.receivableReport.vbd-pdf-download', compact('vendor', 'purchases'));
        return $pdf->download('vbd-pdf-download.pdf');
    }
    public function vbd_excel_download($id){
        $reports =  Excel::download(new PurchaseExport($id), 'Vendor-Balances-Details.xlsx');
        return $reports;
    }
    public function purchase_order_by_vendor_details(Request $request){
        $vendor = PartyInfo::find($request->id);
        $purchases = Purchase::where('supplier_id', $request->id)->get();
        return view('backend.payables.purchase-order-by-vendor-details', compact('vendor', 'purchases'));
    }
    public function pov_pdf_download($id){
        $vendor = PartyInfo::find($id);
        $purchases = Purchase::where('supplier_id', $id)->get();
        $pdf = PDF::loadView('backend.receivableReport.pov-pdf-download', compact('vendor', 'purchases'));
        return $pdf->download('pov-pdf-download.pdf');
    }
    public function pov_excel_download($id){
        $reports =  Excel::download(new PurchaseDetailsExport($id), 'Purchase-Orders-Details.xlsx');
        return $reports;
    }
}
