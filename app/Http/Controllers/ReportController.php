<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function dailySaleReport()
    {
        return view('backend.salesReport.dailySalesReport');
    }

    public function printDailySale()
    {
        return view('backend.pdf.dailySalesReportP');
    }

    public function printDailySaleDate($date)
    {
        // $date=$date;
        return view('backend.pdf.dailySalesReportPDate', compact('date'));
    }

    public function searchDailySale(Request $request)
    {
        $date=$request->date;
        return view('backend.salesReport.searchdailySalesReport', compact('date'));
    }

    public function monthlySaleReport()
    {
        $numOfDays=Carbon::now()->month(Carbon::now()->format('m'))->daysInMonth;
        $numberOfWeek=(int)($numOfDays/7);
        $daysLeft=$numOfDays-($numberOfWeek*7);
        $lastWeek=7+$daysLeft;
        return view('backend.salesReport.monthlySalesReport');


    }

    public function InvoiceWiseSaleSummary()
    {
        $invoicess=Invoice::where('date',date('Y-m-d'))->get();
        return view('backend.salesReport.InvoiceWisedailySalesReport',compact('invoicess'));
    }




    public function searchinvoiceWIseDate(Request $request)
    {
        $time = strtotime($request->date);
        $searchDate = date('m/d/Y',$time);
        $date=$request->date;
        $invoicess=Invoice::where('date',$request->date)->get();
        return view('backend.salesReport.InvoiceWisedailySalesReport', compact('invoicess','searchDate','date'));
    }

    public function searchinvoiceWIseRange(Request $request)
    {
        $timefrom = strtotime($request->from);
        $searchDatefrom = date('m/d/Y',$timefrom);
        $timeto = strtotime($request->to);
        $searchDateto = date('m/d/Y',$timeto);
        $from=$request->from;
        $to=$request->to;
        $invoicess=Invoice::whereDate('date','>=', $from)->whereDate('date','<=', $to)->orderBy('date','ASC')->get();
        return view('backend.salesReport.InvoiceWisedailySalesReport', compact('invoicess','searchDatefrom','searchDateto','from','to'));
    }

    public function filterInvoiceWiseSaleReport(Request $request)
    {
        if($request->date != null)
        {
            $invoicess=Invoice::where('date',$request->date)->where('pay_mode', $request->value)->get();
        }
        elseif($request->from != null)
        {
            $invoicess=Invoice::whereDate('date','>=', $request->from)->whereDate('date','<=', $request->to)->where('pay_mode', $request->value)->get();
        }
        else
        {
            $invoicess=Invoice::where('date',date('Y-m-d'))->where('pay_mode', $request->value)->get();
        }


        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.InvoiceWisedailySalesReportTbody', compact('invoicess'))->render()
            ]);
        }

    }
}
