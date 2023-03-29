<?php

namespace App\Exports;

use App\Invoice;
use App\PartyInfo;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReceivableSummaryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $invoices = Invoice::orderBy('due_date', 'desc')->get();
        $arr_instrulist_excel[] = array('CUSTOMER NAME', 'DATE', 'TRANSACTION#', 'REFERENCE#', 'STATUS', 'TRANSACTION TYPE', 'TOTAL', 'BALANCE');
        foreach($invoices as $invoice){
            $party = PartyInfo::where('pi_code', $invoice->customer_name)->first();
            if($party){
                $arr_instrulist_excel[] = array(
                    'CUSTOMER NAME' => $party->pi_name,
                    'DATE' => $invoice->date,
                    'TRANSACTION#' => $invoice->invoice_no,
                    'REFERENCE#' => '-',
                    'STATUS#' => 'Sent',
                    'TRANSACTION TYPE#' => 'Invoice',
                    'TOTAL' => $invoice->grand_total,
                    'BALANCE' => $invoice->grand_total
                );
            }
        }
        return collect($arr_instrulist_excel);
    }
}
