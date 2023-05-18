<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\ItemList;
use App\PartyInfo;
use App\SalesPerson;
use App\SalesRegion;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    public function sales_by_customer(){
        $starttDate= date('Y-m-').'01';
        $endDate= date('Y-m-').'31';

        $parties= PartyInfo::where('pi_type','Customer')->get();

        // $items= ItemList::all(); 
        return view('backend.salesAccReport.sales-by-customer', compact('parties'));
    }

    public function sales_by_customer_one($party){
        $starttDate= date('Y-m-').'01';
        $endDate= date('Y-m-').'31';
        
        $invoices= Invoice::where('customer_name', $party)->get();
        $party= PartyInfo::where('pi_code',$party)->first();
        
        return view('backend.salesAccReport.sales-by-customer-one', compact('invoices','party'));
    }

    public function sales_by_item(){
        $items= ItemList::all();
        return view('backend.salesAccReport.sales-by-item', compact('items'));
    }

    public function sales_by_person(){
        $starttDate= date('Y-m-').'01';
        $endDate= date('Y-m-').'31';

        $parties= PartyInfo::where('pi_type','Customer')->get();
        $persons= SalesPerson::all();

        // $items= ItemList::all(); 
        return view('backend.salesAccReport.sales-by-person', compact('persons'));
    }

    public function sales_by_region(){
        $starttDate= date('Y-m-').'01';
        $endDate= date('Y-m-').'31';

        $parties= PartyInfo::where('pi_type','Customer')->get();
        $regions= SalesRegion::all();

        // $items= ItemList::all(); 
        return view('backend.salesAccReport.sales-by-region', compact('regions'));
    }
}
