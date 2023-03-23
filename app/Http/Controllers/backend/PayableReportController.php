<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\PartyInfo;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayableReportController extends Controller
{
    public function ap_ageing_summary(){
        // return "Alhamdulillah";

        // $parties= DB::table('party_infos as tb1')
        // ->rightJoin('purchases as tb2', 'tb1.id', '=', 'tb2.supplier_id')
        // ->select('tb1.id', 'tb1.pi_code','tb1.pi_name',
        // DB::raw("SUM(tb2.grand_total) as gtotal"),
        // DB::raw("SUM(IF(tb2.due_date =CURDATE(), tb2.grand_total, 0 )) as current"),
        // DB::raw("SUM(IF(tb2.due_date BETWEEN DATE_SUB('2023-03-10', INTERVAL 14 DAY) AND '2023-03-10', tb2.grand_total, 0 )) as 'days_1_15'"),
        // DB::raw("SUM(IF(tb2.due_date BETWEEN DATE_SUB('2023-03-10', INTERVAL 29 DAY) AND DATE_SUB('2023-03-10', INTERVAL 15 DAY), tb2.grand_total, 0)) as 'days_16_30'"),
        // DB::raw("SUM(IF(tb2.due_date BETWEEN DATE_SUB('2023-03-10', INTERVAL 44 DAY) AND DATE_SUB('2023-03-10', INTERVAL 30 DAY), tb2.grand_total, 0)) as 'days_31_45'"),
        // DB::raw("SUM(IF(tb2.due_date BETWEEN DATE_SUB('2023-03-10', INTERVAL 59 DAY) AND DATE_SUB('2023-03-10', INTERVAL 45 DAY), tb2.grand_total, 0)) as 'days_46_60'"),
        // DB::raw("SUM(IF(tb2.due_date < DATE_SUB('2023-03-10', INTERVAL 60 DAY), tb2.grand_total, 0)) as 'days_up_60'")
        // )
        // ->where('tb1.pi_type', 'Customer')
        // ->groupBy('tb2.customer_name')
        // ->get();

        $parties=PartyInfo::where('pi_type','Supplier')->get();


        // return $query;
        return view('backend.payableReport.ap-ageing-summary',compact('parties'));

    }


    public function ap_ageing_summary_one($id){
        $partyinfo= PartyInfo::find($id);
        $purchase_1= Purchase::where('pay_mode','Credit')->where('supplier_id', $partyinfo->id)->where('pay_date', '<=', Carbon::now()->subDays(1))->where('pay_date', '>=', Carbon::now()->subDays(15))->orderBy('pay_date', 'desc')->get();
        $purchase_2= Purchase::where('pay_mode','Credit')->where('supplier_id', $partyinfo->id)->where('pay_date', '<=', Carbon::now()->subDays(16))->where('pay_date', '>=', Carbon::now()->subDays(30))->orderBy('pay_date', 'desc')->get();
        $purchase_3= Purchase::where('pay_mode','Credit')->where('supplier_id', $partyinfo->id)->where('pay_date', '<=', Carbon::now()->subDays(31))->where('pay_date', '>=', Carbon::now()->subDays(45))->orderBy('pay_date', 'desc')->get();
        $purchase_4= Purchase::where('pay_mode','Credit')->where('supplier_id', $partyinfo->id)->where('pay_date', '<=', Carbon::now()->subDays(46))->where('pay_date', '>=', Carbon::now()->subDays(60))->orderBy('pay_date', 'desc')->get();
        $purchase_5= Purchase::where('pay_mode','Credit')->where('supplier_id', $partyinfo->id)->where('pay_date', '<', Carbon::now()->subDays(60))->orderBy('pay_date', 'desc')->get();

        // return $invoices;
        return view('backend.payableReport.ap-ageing-summary-one',compact('purchase_1','purchase_2','purchase_3','purchase_4','purchase_5','partyinfo'));
    }

    public function ap_ageing_details(){
        // $partyinfo= PartyInfo::find($id);
        $purchase_1= Purchase::where('pay_mode','Credit')->where('pay_date', '<=', Carbon::now()->subDays(1))->where('pay_date', '>=', Carbon::now()->subDays(15))->orderBy('pay_date', 'desc')->get();
        $purchase_2= Purchase::where('pay_mode','Credit')->where('pay_date', '<=', Carbon::now()->subDays(16))->where('pay_date', '>=', Carbon::now()->subDays(30))->orderBy('pay_date', 'desc')->get();
        $purchase_3= Purchase::where('pay_mode','Credit')->where('pay_date', '<=', Carbon::now()->subDays(31))->where('pay_date', '>=', Carbon::now()->subDays(45))->orderBy('pay_date', 'desc')->get();
        $purchase_4= Purchase::where('pay_mode','Credit')->where('pay_date', '<=', Carbon::now()->subDays(46))->where('pay_date', '>=', Carbon::now()->subDays(60))->orderBy('pay_date', 'desc')->get();
        $purchase_5= Purchase::where('pay_mode','Credit')->where('pay_date', '<', Carbon::now()->subDays(60))->orderBy('pay_date', 'desc')->get();

        // return $invoices;
        return view('backend.payableReport.ap-ageing-details',compact('purchase_1','purchase_2','purchase_3','purchase_4','purchase_5'));
    }

    public function payable_summary(){
        // return "Alhamdulillah";

        $purchases= Purchase::where('pay_mode','Credit')->orderBy('pay_date', 'desc')->paginate(25)->withQueryString();
        return view('backend.payableReport.payable-summary',compact('purchases'));
    }


    public function payable_details($id){
        $party_info= PartyInfo::find($id);
        $purchases= Purchase::where('pay_mode','Credit')->where('supplier_id', $party_info->id)->orderBy('pay_date', 'desc')->paginate(25);
        return view('backend.payableReport.payable-details',compact('purchases', 'party_info'));
    }

    public function payable_details_view(){
        // return "Alhamdulillah";

        $purchases= Purchase::orderBy('pay_date', 'desc')->paginate(25)->withQueryString();
        return view('backend.payableReport.payable-details-view',compact('purchases'));
    }
}
