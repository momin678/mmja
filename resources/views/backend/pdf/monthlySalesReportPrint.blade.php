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

    $op_value=0;
    $rcv_value=0;
    $t_amnt=0;
    $t_salim=0;
    $t_nasrin=0;
    $t_rumana=0;
    $t_cotton=0;
    $t_dp=0;
    $t_close=0;
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
                        <h4> Sales Report</h4>
                        <p> <h4>{{ $month==null?  date('M Y'): $month }} </h4></p>
                    </div>

                </div>

                <div class="row">

                    <table   class="table table-sm table-bordered">
                        <tr>
                            <th><small>Date</small></th>
                            <th><small>Opening Stock</small></th>
                            <th><small>Received Amount</small></th>
                            <th><small>Total Amount</small></th>
                            <th><small>Bank Deposit Salim Osman</small></th>
                            <th><small>Bank Deposit Nasrim Osman</small></th>
                            <th><small>Bank Deposit Rumana</small></th>
                            <th><small>Bank Deposit Cotton Mart</small></th>
                            <th><small>Total Bank Deposit</small></th>
                            <th><small>Closing Amount</small></th>
                        </tr>
                        @for($i = $startDate; $i <= $endDate; $i->modify('+1 day'))
                        <tr>
                            <td><small>{{$date= $i->format("Y-m-d") }}</small></td>
                        <td><small>{{$prevvalue= number_format((float)(App\StockTransection::where('tns_type_code','S')->whereDate('date','<',$date)->sum('cost_price') - App\JournalRecordsTemp::where('transaction_type','DR')->whereDate('journal_date','<',$date)->whereIn('account_head_id',[225,226,227,228])->sum('amount')),'2','.','') }}</small></td>
                            <td><small>{{$todayValue =number_format((float)(App\StockTransection::where('tns_type_code','S')->whereDate('date',$date)->sum('cost_price')),'2','.','') }}</small></td>
                            <td><small>{{$total= number_format((float)($prevvalue+$todayValue),'2','.','') }}</small></td>
                            <td><small>{{$selim= number_format((float)(App\JournalRecordsTemp::where('account_head_id',225)->where('transaction_type','DR')->whereDate('journal_date',$date)->sum('amount')),'2','.','') }}</small></td>
                            <td><small>{{$nasrin= number_format((float)(App\JournalRecordsTemp::where('account_head_id',226)->where('transaction_type','DR')->whereDate('journal_date',$date)->sum('amount')),'2','.','') }}</small></td>
                            <td><small>{{$rumana= number_format((float)(App\JournalRecordsTemp::where('account_head_id',227)->where('transaction_type','DR')->whereDate('journal_date',$date)->sum('amount')),'2','.','') }}</small></td>
                            <td><small>{{$cotton= number_format((float)(App\JournalRecordsTemp::where('account_head_id',228)->where('transaction_type','DR')->whereDate('journal_date',$date)->sum('amount')),'2','.','') }}</small></td>
                            <td><small>{{$total_dp= number_format((float)($selim+$nasrin+$rumana+$cotton),'2','.','') }}</small></td>
                            <td><small>{{$close=number_format((float)($total - $total_dp),'2','.','') }}</small></td>
                           </tr>

                           @php
                                $op_value=$op_value+$prevvalue;
                                $rcv_value=$rcv_value+$todayValue;
                                $t_amnt=$t_amnt+$total;
                                $t_salim=$t_salim+$selim;
                                $t_nasrin=$t_nasrin+$nasrin;
                                $t_rumana=$t_rumana+$rumana;
                                $t_cotton=$t_cotton+$cotton;
                                $t_dp=$t_dp+$total_dp;
                                $t_close=$t_close+$close;
                            @endphp
                           @endfor
                           <tr>
                            <th><small>Total</small></th>
                            <th><small>{{ number_format((float)($op_value),'2','.','') }}</small></th>
                            <th><small>{{ number_format((float)($rcv_value),'2','.','') }}</small></th>
                            <th><small>{{ number_format((float)($t_amnt),'2','.','') }}</small></th>
                            <th><small>{{ number_format((float)($t_salim ),'2','.','')}}</small></th>
                            <th><small>{{ number_format((float)($t_nasrin),'2','.','') }}</small></th>
                            <th><small>{{ number_format((float)($t_rumana),'2','.','') }}</small></th>
                            <th><small>{{ number_format((float)($t_cotton),'2','.','') }}</small></th>
                            <th><small>{{ number_format((float)($t_dp),'2','.','') }}</small></th>
                            <th><small>{{  number_format((float)($t_close ),'2','.','')}}</small></th>
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
