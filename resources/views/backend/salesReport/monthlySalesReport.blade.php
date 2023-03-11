@extends('layouts.backend.app')
@section('title', 'Stock Position')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>

        th{
            text-transform: uppercase;
            text-align: center;
        }
        td{
            text-align:center;
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

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-10">
                            <h4>{{ $month==null?  date('M Y'): $month }} Sales Report</h4>
                        </div>
                        <div class="col-md-2 text-right  col-left-padding">
                            <form action="#" method="GET">
                                {{-- @csrf --}}
                                <div class="row form-group  col-left-padding">
                                    <input type="text" class="form-control col-9 " name="month"
                                        placeholder="Month" onfocus="(this.type='month')" id="month" required>
                                    <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row pt-2">
                        <div class="col-md-12">
                            @php
                                $is_month=isset($month)? $month:null;
                            @endphp

                        <a href="{{ route('monthlySaleReportPrint',$is_month) }}" class="btn btn-sm btn-info float-right"
                        target="_blank">Print</a>



                            <button class="btn  btn-info btn-sm float-right mr-1"
                        onclick="exportTableToCSV('stockPosition.csv')">Export To CSV</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">

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

                                    <td><small>{{$prevvalue= number_format((float)(App\StockTransection::where('tns_type_code','S')->where('date','<',$date)->sum('cost_price') - App\JournalRecordsTemp::where('transaction_type','DR')->where('journal_date','<',$date)->whereIn('account_head_id',[225,226,227,228])->sum('amount')),'2','.','') }}</small></td>
                                    <td><small>{{$todayValue =number_format((float)(App\StockTransection::where('tns_type_code','S')->where('date',$date)->sum('cost_price')),'2','.','') }}</small></td>
                                    <td><small>{{$total= number_format((float)($prevvalue+$todayValue),'2','.','') }}</small></td>
                                    <td><small>{{$selim= number_format((float)(App\JournalRecordsTemp::where('account_head_id',225)->where('journal_date',$date)->sum('amount')),'2','.','') }}</small></td>
                                    <td><small>{{$nasrin= number_format((float)(App\JournalRecordsTemp::where('account_head_id',226)->where('journal_date',$date)->sum('amount')),'2','.','') }}</small></td>
                                    <td><small>{{$rumana= number_format((float)(App\JournalRecordsTemp::where('account_head_id',227)->where('journal_date',$date)->sum('amount')),'2','.','') }}</small></td>
                                    <td><small>{{$cotton= number_format((float)(App\JournalRecordsTemp::where('account_head_id',228)->where('journal_date',$date)->sum('amount')),'2','.','') }}</small></td>
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
                    </div>

                </section>
                <!-- Widgets Statistics End -->



            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        // $(document).ready(function() {
        // Page Script
        // alert("Alhamdulillah");
        // });
    </script>
@endpush
