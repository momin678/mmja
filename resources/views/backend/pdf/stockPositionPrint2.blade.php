@extends('layouts.pdf.app')
@push('css')
<style>
    th td{
        color: black !important;
        text-align: center !important;
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
            th td{
        color: black !important;
        text-align: center !important;
    }
}


</style>
@endpush

@php
    $op_stock=0;
    $op_value=0;
    $rcv=0;
    $rcv_value=0;
    $t_stock=0;
    $t_stock_value=0;
    $sale=0;
    $s_value=0;
    $closing_stock=0;
    $closing_stock_value=0;
@endphp
  @section('content')

  {{-- $style->styleSTockPositionCheck($style) --}}


  <div class="container py-2  page-break">
    <!-- BEGIN: Content-->
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Widgets Statistics start -->
            <section id="widgets-Statistics">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4> Stock Report</h4>
                        <p>{{ $date !=null? $date:($from != null? ( $from.' to '. $to) : date('d M Y')) }}</p>
                    </div>

                </div>

                <div class="row">

                    <table   class="table table-sm table-bordered">
                        <tr>
                            <th class="text-center" colspan="12">{{ $date !=null? $date:($from != null? ( $from.' to '. $to) : date('d M Y')) }} Stock Report</th>
                        </tr>
                        <tr>
                            <th class="text-center"><small><strong>Style</strong></small></th>
                            <th class="text-center"><small><strong>Rate</strong></small></th>
                            <th class="text-center"><small><strong>Opening Stock</strong></small></th>
                            <th class="text-center"><small><strong>Opening Stock Value</strong></small></th>
                            <th class="text-center"><small><strong>Receive</strong></small></th>
                            <th class="text-center"><small><strong>Receive Value</strong></small></th>
                            <th class="text-center"><small><strong>Total Stock</strong></small></th>
                            <th class="text-center"><small><strong>Total Stock Value</strong></small></th>
                            <th class="text-center"><small><strong>Sale</strong></small></th>
                            <th class="text-center"><small><strong>Sale Value</strong></small></th>
                            <th class="text-center"><small><strong>Closing Stock</strong></small></th>
                            <th class="text-center"><small><strong>Closing Stock Value</strong></small></th>
                        </tr>
                        @foreach ($styles as $style)
                        @if($date!=null)
                        <tr>
                            <td class="text-center"><small>{{ $style->style_name }}</small></td>
                            <td class="text-center"><small>{{ $style->styleRate() }}</small></td>
                            <td class="text-center"><small>{{$s_op = $style->styleOpeningStockDate($date) }}</small></td>
                            <td class="text-center"><small>{{$s_op_value =number_format((float)($style->styleRate() * $style->styleOpeningStockDate($date)),'2','.','')  }}</small></td>
                            <td class="text-center"><small>{{ $s_rcv = $style->stylePurchaseStockDate($date) }}</small></td>
                            <td class="text-center"><small>{{$s_rcv_value =number_format((float)($style->styleRate() * $style->stylePurchaseStockDate($date)),'2','.','')  }}</small></td>
                            <td class="text-center"><small>{{ $totalStock= $s_op + $s_rcv }}</small></td>
                            <td class="text-center"><small>{{$s_stock_value= number_format((float)($style->styleRate() * $totalStock),'2','.','')  }}</small></td>
                            <td class="text-center"><small>{{ $s_sale =$style->styleSaleDate($date) }}</small></td>
                            <td class="text-center"><small>{{ $s_s_value= number_format((float)($style->styleRate() * $style->styleSaleDate($date)),'2','.','')  }}</small></td>
                            <td class="text-center"><small>{{ $s_curr_stock= $style->styleCurrentStockDate($date) }}</small></td>
                            <td class="text-center"><small>{{$s_closing_value = number_format((float)($style->styleRate() * $style->styleCurrentStockDate($date)),'2','.','')  }}</small></td>
                        </tr>
                        @elseif ($from !=null)
                        <tr>
                            <td class="text-center"><small>{{ $style->style_name }}</small></td>
                            <td class="text-center"><small>{{ $style->styleRate() }}</small></td>
                            <td class="text-center"><small>{{$s_op = $style->styleOpeningStockDate($from) }}</small></td>
                            <td class="text-center"><small>{{$s_op_value =number_format((float)($style->styleRate() * $style->styleOpeningStockDate($from)),'2','.','')  }}</small></td>
                            <td class="text-center"><small>{{ $s_rcv = $style->stylePurchaseStockRange($from,$to) }}</small></td>
                            <td class="text-center"><small>{{$s_rcv_value =number_format((float)($style->styleRate() * $style->stylePurchaseStockRange($from,$to)),'2','.','')  }}</small></td>
                            <td class="text-center"><small>{{ $totalStock= $s_op + $s_rcv }}</small></td>
                            <td class="text-center"><small>{{$s_stock_value= number_format((float)($style->styleRate() * $totalStock),'2','.','')  }}</small></td>
                            <td class="text-center"><small>{{ $s_sale =$style->styleSaleRange($from,$to) }}</small></td>
                            <td class="text-center"><small>{{ $s_s_value= number_format((float)($style->styleRate() * $style->styleSaleRange($from,$to)),'2','.','')  }}</small></td>
                            <td class="text-center"><small>{{ $s_curr_stock= $style->styleCurrentStockDate($to) }}</small></td>
                            <td class="text-center"><small>{{$s_closing_value = number_format((float)($style->styleRate() * $style->styleCurrentStockDate($to)),'2','.','')  }}</small></td>
                        </tr>
                        @else
                        <tr>
                            <td class="text-center"><small>{{ $style->style_name }}</small></td>
                            <td class="text-center"><small>{{ $style->styleRate() }}</small></td>
                            <td class="text-center"><small>{{$s_op = $style->styleOpeningStock() }}</small></td>
                            <td class="text-center"><small>{{$s_op_value =number_format((float)($style->styleRate() * $style->styleOpeningStock()),'2','.','')  }}</small></td>
                            <td class="text-center"><small>{{ $s_rcv = $style->stylePurchaseStock() }}</small></td>
                            <td class="text-center"><small>{{$s_rcv_value =number_format((float)($style->styleRate() * $style->stylePurchaseStock()),'2','.','')  }}</small></td>
                            <td class="text-center"><small>{{ $totalStock= $s_op + $s_rcv }}</small></td>
                            <td class="text-center"><small>{{$s_stock_value= number_format((float)($style->styleRate() * $totalStock),'2','.','')  }}</small></td>
                            <td class="text-center"><small>{{ $s_sale =$style->styleSale() }}</small></td>
                            <td class="text-center"><small>{{ $s_s_value= number_format((float)($style->styleRate() * $style->styleSale()),'2','.','')  }}</small></td>
                            <td class="text-center"><small>{{ $s_curr_stock= $style->styleCurrentStock() }}</small></td>
                            <td class="text-center"><small>{{$s_closing_value = number_format((float)($style->styleRate() * $style->styleCurrentStock()),'2','.','')  }}</small></td>
                        </tr>
                        @endif
                        @php
                            $op_stock=$op_stock+$s_op;
                            $op_value=$op_value+$s_op_value;
                            $rcv=$rcv+ $s_rcv;
                            $rcv_value=$rcv_value+$s_rcv_value;
                            $t_stock=$t_stock+$totalStock;
                            $t_stock_value=$t_stock_value+$s_stock_value;
                            $sale=$sale+ $s_sale;
                            $s_value=$s_value+ $s_s_value;
                            $closing_stock=$closing_stock+ $s_curr_stock;
                            $closing_stock_value=$closing_stock_value+$s_closing_value;
                        @endphp
                        @endforeach
                        <tr>
                            <th class="text-center" colspan="2">Total</th>
                            <th class="text-center">{{ $op_stock }}</th>
                            <th class="text-center">{{ $op_value }}</th>
                            <th class="text-center">{{ $rcv }}</th>
                            <th class="text-center">{{ $rcv_value }}</th>
                            <th class="text-center">{{ $t_stock }}</th>
                            <th class="text-center">{{ $t_stock_value }}</th>
                            <th class="text-center">{{ $sale }}</th>
                            <th class="text-center">{{ $s_value }}</th>
                            <th class="text-center">{{ $closing_stock }}</th>
                            <th class="text-center">{{ $closing_stock_value }}</th>
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
