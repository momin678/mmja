<?php

namespace App\Exports;

use App\Invoice;
use App\PartyInfo;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomerBalanceExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $customers = Invoice::get()->groupBy(function($data){
            return $data->customer_name;
        });
        $arr_instrulist_excel[] = array('CUSTOMER NAME', 'INVOICED AMOUNT', 'AMOUNT RECEIVED', 'CLOSING BALANCE');
        foreach($customers as $key => $customer){
            $party = PartyInfo::where('pi_code', $key)->first();
            $invoices = Invoice::where('customer_name', $key)->get();
            $invoice_amount = 0;
            $received_amount = 0;
            foreach ($invoices as $key => $invoice) {
                if($invoice->invoiceAmount){
                    $invoice_amount += ($invoice->invoiceAmount->amount_from - $invoice->invoiceAmount->amount_to);
                    $received_amount  += $invoice->invoiceAmount->amount_from;
                }
            }
            if($party){
                $arr_instrulist_excel[] = array(
                    'CUSTOMER NAME' => $party->pi_name,
                    'INVOICED AMOUNT' => $invoice_amount,
                    'AMOUNT RECEIVED' => $received_amount,
                    'CLOSING BALANCE' => $invoice_amount-$received_amount,
                );
            }
        }
        return collect($arr_instrulist_excel);
    }
}
