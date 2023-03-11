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

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-4">
                            <h4>{{ $date !=null? $date:($from != null? ( $from.' to '. $to) : date('d M Y')) }} Stock Report</h4>
                        </div>
                        <div class="col-md-2 text-right  col-left-padding">
                            <form action="#" method="GET">
                                {{-- @csrf --}}
                                <div class="row form-group  col-left-padding">
                                    <input type="text" class="form-control col-9 " name="date"
                                        placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                    <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4  col-left-padding">
                            <form action="#" method="GET">
                                {{-- @csrf --}}
                                <div class="row form-group">
                                    <div class="col-5 col-right-padding">
                                        <input type="text" class="form-control" name="from"
                                        placeholder="From" onfocus="(this.type='date')" id="from" required>
                                    </div>
                                    <div class="col-5  col-left-padding col-right-padding">
                                        <input type="text" class="form-control" name="to"
                                        placeholder="To" onfocus="(this.type='date')" id="to" required>
                                    </div>
                                    <button class="bx bx-search col-2 btn-warning btn-block" type="submit"></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('stockReportWithP') }}" class="btn btn-info">With Purchase</a>
                        </div>
                    </div>



                    <div class="row pt-2">
                        <div class="col-md-12">

                            @if($date != null)
                            <a href="{{ route('printStockPosition2Date',$date) }}" class="btn btn-sm btn-info float-right"
                            target="_blank">Print</a>
                        @elseif($from != null)
                            <a href="{{ route('printStockPosition2Range',[$from,$to]) }}" class="btn btn-sm btn-info float-right"
                            target="_blank">Print</a>
                        @else
                        <a href="{{ route('printStockPosition2') }}" class="btn btn-sm btn-info float-right"
                        target="_blank">Print</a>
                        @endif

                            <button class="btn  btn-info btn-sm float-right mr-1"
                        onclick="exportTableToCSV('stockPosition.csv')">Export To CSV</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th colspan="12">{{ $date !=null? $date:($from != null? ( $from.' to '. $to) : date('d M Y')) }} Stock Report</th>
                                </tr>
                                <tr>
                                    <th><small>Style</small></th>
                                    <th><small>Rate</small></th>
                                    <th><small>Opening Stock</small></th>
                                    <th><small>Opening Stock Value</small></th>
                                    <th><small>Receive</small></th>
                                    <th><small>Receive Value</small></th>
                                    <th><small>Total Stock</small></th>
                                    <th><small>Total Stock Value</small></th>
                                    <th><small>Sale</small></th>
                                    <th><small>Sale Value</small></th>
                                    <th><small>Closing Stock</small></th>
                                    <th><small>Closing Stock Value</small></th>
                                </tr>
                                @foreach ($styles as $style)
                                @if($date!=null)
                                <tr>
                                    <td><small>{{ $style->style_name }}</small></td>
                                    <td><small>{{ $style->styleRate() }}</small></td>
                                    <td><small>{{$s_op = $style->styleOpeningStockDate($date) }}</small></td>
                                    <td><small>{{$s_op_value =number_format((float)($style->styleRate() * $style->styleOpeningStockDate($date)),'2','.','')  }}</small></td>
                                    <td><small>{{ $s_rcv = $style->stylePurchaseStockDate($date) }}</small></td>
                                    <td><small>{{$s_rcv_value =number_format((float)($style->styleRate() * $style->stylePurchaseStockDate($date)),'2','.','')  }}</small></td>
                                    <td><small>{{ $totalStock= $s_op + $s_rcv }}</small></td>
                                    <td><small>{{$s_stock_value= number_format((float)($style->styleRate() * $totalStock),'2','.','')  }}</small></td>
                                    <td><small>{{ $s_sale =$style->styleSaleDate($date) }}</small></td>
                                    <td><small>{{ $s_s_value= number_format((float)($style->styleRate() * $style->styleSaleDate($date)),'2','.','')  }}</small></td>
                                    <td><small>{{ $s_curr_stock= $style->styleCurrentStockDate($date) }}</small></td>
                                    <td><small>{{$s_closing_value = number_format((float)($style->styleRate() * $style->styleCurrentStockDate($date)),'2','.','')  }}</small></td>
                                </tr>
                                @elseif ($from !=null)
                                <tr>
                                    <td><small>{{ $style->style_name }}</small></td>
                                    <td><small>{{ $style->styleRate() }}</small></td>
                                    <td><small>{{$s_op = $style->styleOpeningStockDate($from) }}</small></td>
                                    <td><small>{{$s_op_value =number_format((float)($style->styleRate() * $style->styleOpeningStockDate($from)),'2','.','')  }}</small></td>
                                    <td><small>{{ $s_rcv = $style->stylePurchaseStockRange($from,$to) }}</small></td>
                                    <td><small>{{$s_rcv_value =number_format((float)($style->styleRate() * $style->stylePurchaseStockRange($from,$to)),'2','.','')  }}</small></td>
                                    <td><small>{{ $totalStock= $s_op + $s_rcv }}</small></td>
                                    <td><small>{{$s_stock_value= number_format((float)($style->styleRate() * $totalStock),'2','.','')  }}</small></td>
                                    <td><small>{{ $s_sale =$style->styleSaleRange($from,$to) }}</small></td>
                                    <td><small>{{ $s_s_value= number_format((float)($style->styleRate() * $style->styleSaleRange($from,$to)),'2','.','')  }}</small></td>
                                    <td><small>{{ $s_curr_stock= $style->styleCurrentStockDate($to) }}</small></td>
                                    <td><small>{{$s_closing_value = number_format((float)($style->styleRate() * $style->styleCurrentStockDate($to)),'2','.','')  }}</small></td>
                                </tr>
                                @else
                                <tr>
                                    <td><small>{{ $style->style_name }}</small></td>
                                    <td><small>{{ $style->styleRate() }}</small></td>
                                    <td><small>{{$s_op = $style->styleOpeningStock() }}</small></td>
                                    <td><small>{{$s_op_value =number_format((float)($style->styleRate() * $style->styleOpeningStock()),'2','.','')  }}</small></td>
                                    <td><small>{{ $s_rcv = $style->stylePurchaseStock() }}</small></td>
                                    <td><small>{{$s_rcv_value =number_format((float)($style->styleRate() * $style->stylePurchaseStock()),'2','.','')  }}</small></td>
                                    <td><small>{{ $totalStock= $s_op + $s_rcv }}</small></td>
                                    <td><small>{{$s_stock_value= number_format((float)($style->styleRate() * $totalStock),'2','.','')  }}</small></td>
                                    <td><small>{{ $s_sale =$style->styleSale() }}</small></td>
                                    <td><small>{{ $s_s_value= number_format((float)($style->styleRate() * $style->styleSale()),'2','.','')  }}</small></td>
                                    <td><small>{{ $s_curr_stock= $style->styleCurrentStock() }}</small></td>
                                    <td><small>{{$s_closing_value = number_format((float)($style->styleRate() * $style->styleCurrentStock()),'2','.','')  }}</small></td>
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
                                    <th colspan="2">Total</th>
                                    <th>{{ $op_stock }}</th>
                                    <th>{{ $op_value }}</th>
                                    <th>{{ $rcv }}</th>
                                    <th>{{ $rcv_value }}</th>
                                    <th>{{ $t_stock }}</th>
                                    <th>{{ $t_stock_value }}</th>
                                    <th>{{ $sale }}</th>
                                    <th>{{ $s_value }}</th>
                                    <th>{{ $closing_stock }}</th>
                                    <th>{{ $closing_stock_value }}</th>
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
