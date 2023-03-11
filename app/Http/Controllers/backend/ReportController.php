<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Http\Controllers\Controller;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DateTime;

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

    public function monthylySale(Request $request)
    {
        $month=null;
        if($request->month)
        {

            $start = Carbon::create($request->month)->startOfMonth()->format('Y-m-d');
            $end = Carbon::create($request->month)->endOfMonth()->format('Y-m-d');
            $month=Carbon::create($request->month)->startOfMonth()->format('M Y');
        }
        else
        {
            $now = Carbon::now();
            $start = $now->startOfMonth()->format('Y-m-d');
            $end = $now->endOfMonth()->format('Y-m-d');
        }
        $sdate = strtotime($start);
        $startOfMonth=date('Y-m-d', $sdate);
        $edate = strtotime($end);
        $endOfMonth=date('Y-m-d', $edate);
        $startDate= new DateTime( $startOfMonth );
        $endDate= new DateTime( $endOfMonth );


        return view('backend.salesReport.monthlySalesReport',compact('startDate','endDate','month'));


    }


    public function monthlySaleReportPrint($month=null)
    {
        if($month != null)
        {

            $start = Carbon::create($month)->startOfMonth()->format('Y-m-d');
            $end = Carbon::create($month)->endOfMonth()->format('Y-m-d');
            $month=Carbon::create($month)->startOfMonth()->format('M Y');
        }
        else
        {
            $now = Carbon::now();
            $start = $now->startOfMonth()->format('Y-m-d');
            $end = $now->endOfMonth()->format('Y-m-d');
        }
        $sdate = strtotime($start);
        $startOfMonth=date('Y-m-d', $sdate);
        $edate = strtotime($end);
        $endOfMonth=date('Y-m-d', $edate);
        $startDate= new DateTime( $startOfMonth );
        $endDate= new DateTime( $endOfMonth );
        return view('backend.pdf.monthlySalesReportPrint',compact('startDate','endDate','month'));


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
        $dates=Invoice::whereDate('date','>=', $from)->whereDate('date','<=', $to)->orderBy('date','ASC')->select('date')->distinct()->get();
        return view('backend.salesReport.InvoiceWisedailySalesReportRange', compact('searchDatefrom','searchDateto','from','to','dates'));
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


    public function invoiceWiseDailySalePrint()
    {
        $invoicess=Invoice::where('date',date('Y-m-d'))->get();
        return view('backend.pdf.InvoiceWisedailySalesReportP',compact('invoicess'));
    }

    public function invoiceWiseDailySalePrintDate($date)
    {
        $time = strtotime($date);
        $searchDate = date('m/d/Y',$time);
        $date=$date;
        $invoicess=Invoice::where('date',$date)->get();
        return view('backend.pdf.InvoiceWisedailySalesReportP',compact('invoicess','searchDate'));
    }

    public function invoiceWiseDailySalePrintRange($from, $to)
    {
        $timefrom = strtotime($from);
        $searchDatefrom = date('m/d/Y',$timefrom);
        $timeto = strtotime($to);
        $searchDateto = date('m/d/Y',$timeto);
        $from=$from;
        $to=$to;
        $dates=Invoice::whereDate('date','>=', $from)->whereDate('date','<=', $to)->orderBy('date','ASC')->select('date')->distinct()->get();
        return view('backend.pdf.InvoiceWisedailySalesReportPrange',compact('searchDatefrom','searchDateto','dates'));
    }
    public function searchDailySaleRange(Request $request)
    {
        // dd($request->all());
        $timefrom = strtotime($request->from);
        $searchDatefrom = date('m/d/Y',$timefrom);
        $timeto = strtotime($request->to);
        $searchDateto = date('m/d/Y',$timeto);
        $from=$request->from;
        $to=$request->to;
        $brands=Brand::latest()->get();
        return view('backend.salesReport.searchdailySalesReportRange', compact('brands','from', 'to','searchDatefrom','searchDateto'));
    }


    public function printDailySaleDateRange($from,$to)
    {
        $timefrom = strtotime($from);
        $searchDatefrom = date('m/d/Y',$timefrom);
        $timeto = strtotime($to);
        $searchDateto = date('m/d/Y',$timeto);
        $from=$from;
        $to=$to;
        return view('backend.pdf.dailySalesReportPDateRange', compact('from','to','searchDatefrom','searchDateto'));
    }

}
