<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
class InvoiceExport implements FromCollection
{
    public function collection(){
        $invoices = Invoice::all();
        // dd($invoices[0]->invoice_no);
        // return $test;
        $arr_instrulist_excel[] = array('DATE', 'TRANSACTION#', 'TYPE', 'STATUS', 'CUSTOMER NAME', 'AGE', 'AMOUNT', 'BALANCE DUE');

         foreach($invoices as $key => $arr_instrulists){
            $pi_name = $arr_instrulists->partyInfo($arr_instrulists->customer_name);
            if($pi_name){
                $date = \Carbon\Carbon::parse($arr_instrulists->due_date);
                $now = \Carbon\Carbon::now();
                $diff = $date->diffInDays($now).' Days';
                $arr_instrulist_excel[] = array(
                    'Instrument Name'  => $arr_instrulists->date,
                    'TRANSACTION#'   => $arr_instrulists->invoice_no,
                    'TYPE'    => "Invoice",
                    'STATUS'    => "Sent",
                    'CUSTOMER NAME'    => $pi_name->pi_name,
                    'AGE'    => $diff,
                    'AMOUNT'    => $arr_instrulists->grand_total,
                    'BALANCE DUE'    => $arr_instrulists->grand_total,
                );
            }
        }
         return collect($arr_instrulist_excel);
    }
}
