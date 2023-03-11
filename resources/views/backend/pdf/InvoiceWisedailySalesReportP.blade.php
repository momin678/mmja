@extends('layouts.pdf.app')
@push('css')
<style>
    th td{
        color: black !important;
        text-align: center !important;
    }
    th{
            /* text-transform: uppercase; */
            font-size: 11px !important;
        }

        @media print {
     body {
           margin-top: 0mm;
           margin-left: 20mm;
           margin-bottom: 20mm;
           margin-right: 20mm
     }
     * {
                color: inherit !important;
                background-color: transparent !important;
                background-image: none !important;
            }
            table {
                width: 100%;
                border: 1pt solid #000000;
                border-collapse: collapse;
                font-size: 11pt;
            }
            #space { height: 750px; }
}


</style>
@endpush

@php
    $grand_total_value=0;
@endphp
  @section('content')


  <div class="container py-4  page-break">
    <!-- BEGIN: Content-->
    <div class="content-overlay"></div>
    <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4> Sales Report</h4>
                            <p>{{isset($searchDate)? $searchDate: (isset($searchDatefrom)? $searchDatefrom." to ".$searchDateto: date('d M Y')) }}</p>
                        </div>
                    </div>

                    <div class="row pt-2">

                        <table   class="table table-sm table-bordered">
                            <tr>
                                <th>Invoice No</th>
                                <th>Date</th>
                                <th>Payment Mode</th>
                                <th>Taxable Sales Amount</th>
                                <th>Vat Amount</th>
                                <th>Total Amount</th>
                                <th>Amount From Customer <small>{{isset($currency)? $currency->config_value:""}}</small></th>
                                <th>Return to Customer <small>{{isset($currency)? $currency->config_value:""}}</small></th>
                            </tr>
                            @php
                            $grand_total_taxable=0;
                            $grand_total_vat=0;
                            $grand_total_amount=0;
                        @endphp
                   @foreach($invoicess as $inv)

                   <tr>
                    <td>{{ $inv->invoice_no }}</td>
                   <td>{{ $inv->date }}</td>
                   <td>{{ $inv->pay_mode }}</td>
                   <td>{{$txable=number_format((float)( App\InvoiceItem::where('invoice_id',$inv->id)->sum('total_unit_price')), 2,'.','')    }}</td>
                    <td>{{$vat=number_format((float)(  App\InvoiceItem::where('invoice_id',$inv->id)->sum('vat_amount')), 2,'.','')   }}</td>
                   <td>{{$total=number_format((float)(App\InvoiceItem::where('invoice_id',$inv->id)->sum('cost_price')), 2,'.','')   }}</td>
                   <td> {{$inv->invoiceAmount ? number_format((float)($inv->invoiceAmount->amount_from), 2,'.',''): '0.00'   }}</td>
                   <td>{{   $inv->invoiceAmount ? ($inv->invoiceAmount->amount_to>0?  number_format((float)($inv->invoiceAmount->amount_to), 2,'.',''): '0.00'): '0.00'   }}</td>
                   </tr>
                   @php
                            $grand_total_taxable=$grand_total_taxable+$txable;
                            $grand_total_vat=$grand_total_vat+$vat;
                            $grand_total_amount=$grand_total_amount+$total;
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="3" style="text-center">Grand Total</td>
                        <td>{{ number_format((float)$grand_total_taxable,'2','.','')}}</td>
                        <td>{{ number_format((float)$grand_total_vat,'2','.','')}}</td>
                        <td>{{ number_format((float)$grand_total_amount,'2','.','')}}</td>

                    </tr>
                        </table>

                    </div>

                </section>
                <!-- Widgets Statistics End -->



            </div>
        </div>
    <div class="row pt-3">
        <table class="table table-sm table-bordered" >
            <tr>
                <th>Prepared By</th>
                <th>Checked By</th>
                <th>Endorsed By</th>
                <th>Authorized By</th>
                <th>Authorized By</th>
                <th>Approved By</th>
            </tr>

            <tr>
                <td>Mahidul Islam Bappy</td>
                <td>Ridwanuzzaman</td>
                <td>Habibur Rahaman</td>
                <td>Md. Akhter Hosain</td>
                <td>S.M Arifen</td>
                <td>Salim Osman</td>


            </tr>

        </table>
 </div>
</div>


  @endsection
