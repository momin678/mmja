<?php

namespace App\Exports;

use App\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;

class PurchaseExport implements FromCollection
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
        $arr_instrulist_excel[] = array('DATE', 'BILL#', 'STATUS', 'DUE DATE', 'AMOUNT', 'PAID BALANCE', 'BALANCE DUE');
        foreach($purcahses as $key => $arr_instrulists){
            $today = strtotime(date('Y-m-d'));
            $to = strtotime($arr_instrulists->date);
            $from = strtotime($arr_instrulists->pay_date);
            $differnet_days = (int)(($from - $to)/86400);
            $over_days = (int)(($today - $to)/86400);
            $days = $over_days-$differnet_days;
            if($over_days>$differnet_days){
                $status = 'Overdue by '. $days .' days';
            }else{
                $status = 'Open';
            }
            $arr_instrulist_excel[] = array(
                'DATE'  => $arr_instrulists->date,
                'BILL#'   => $arr_instrulists->purchase_no,
                'STATUS'    => $status,
                'DUE DATE'    => $arr_instrulists->pay_date,
                'AMOUNT'    => '(AED) '.number_format($arr_instrulists->purchase_details->sum('total_amount'),2),
                'PAID BALANCE' => '(AED) '.number_format($arr_instrulists->purchase_details->sum('paid_amount'),2),
                'BALANCE DUE' => '(AED) '.number_format($arr_instrulists->purchase_details->sum('total_amount')-$arr_instrulists->paid_amount->sum('paid_amount'),2),
            );
        }
        return collect($arr_instrulist_excel);
    }
}
