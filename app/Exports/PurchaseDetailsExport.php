<?php

namespace App\Exports;

use App\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;

class PurchaseDetailsExport implements FromCollection
{
    protected $id;
    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $purcahses = Purchase::where('supplier_id', $this->id)->get();
        $arr_instrulist_excel[] = array('DATE', 'BILL#', 'DUE DATE', 'VAT AMOUNT', 'AMOUNT', 'PAID BALANCE', 'BALANCE DUE');
        foreach($purcahses as $key => $arr_instrulists){
            $arr_instrulist_excel[] = array(
                'DATE'  => $arr_instrulists->date,
                'BILL#'   => $arr_instrulists->purchase_no,
                'DUE DATE'    => $arr_instrulists->pay_date,
                'AMOUNT'    => '(AED) '.number_format($arr_instrulists->purchase_details->sum('total_vat'),2),
                'VAT AMOUNT'    => '(AED) '.number_format($arr_instrulists->purchase_details->sum('total_amount'),2),
                'PAID BALANCE' => '(AED) '.number_format($arr_instrulists->purchase_details->sum('paid_amount'),2),
                'BALANCE DUE' => '(AED) '.number_format($arr_instrulists->purchase_details->sum('total_amount')-$arr_instrulists->paid_amount->sum('paid_amount'),2),
            );
        }
         return collect($arr_instrulist_excel);
    }
}
