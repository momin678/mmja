@extends('layouts.backend.app')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
$currency= \App\Setting::where('config_name', 'currency')->first();

@endphp
@section('title', 'Sales Report')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        td{
            text-align: right !important;
        }
        th{
            /* text-transform: uppercase; */
            font-size: 11px !important;
        }
    </style>
@endpush

@section('content')
@php

@endphp
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>{{isset($searchDate)? $searchDate: (isset($searchDatefrom)? $searchDatefrom." to ".$searchDateto: date('d M Y')) }} Sales Report</h4>
                        </div>
                        <div class="col-md-2 text-right  col-left-padding">
                            <form action="{{ route('searchinvoiceWIseDate') }}" method="GET">
                                {{-- @csrf --}}
                                <div class="row form-group  col-left-padding">
                                    <input type="text" class="form-control col-9 " name="date"
                                        placeholder="Select Date" value="{{ isset($searchDate)? $searchDate:"" }}" onfocus="(this.type='date')" id="date" required>
                                    <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                                </div>
                            </form>
                            <input type="hidden" name="hidden_date" value="{{ isset($date)? $date:"" }}" id="hidden_date">

                        </div>
                        <div class="col-md-4  col-left-padding">
                            <form action="{{ route('searchinvoiceWIseRange') }}" method="GET">
                                {{-- @csrf --}}
                                <div class="row form-group">
                                    <div class="col-5 col-right-padding">
                                        <input type="text" class="form-control" name="from"
                                        placeholder="From"  value="{{ isset($searchDatefrom)? $searchDatefrom:"" }}"  onfocus="(this.type='date')"  id="from" required>

                                    </div>
                                    <div class="col-5  col-left-padding col-right-padding">
                                        <input type="text" class="form-control" name="to"
                                        placeholder="To" value="{{ isset($searchDateto)? $searchDateto:"" }}" onfocus="(this.type='date')" id="to" required>
                                    </div>
                                    <button class="bx bx-search col-2 btn-warning btn-block" type="submit"></button>
                                </div>
                            </form>

                            <input type="hidden" name="hidden_date_from" value="{{ isset($from)? $from:"" }}" id="hidden_date_from">
                            <input type="hidden" name="hidden_date_to" value="{{ isset($to)? $to:"" }}" id="hidden_date_to">
                        </div>
                        {{-- <div class="col-md-2">
                            <a href="{{ route('stockReportWithP') }}" class="btn btn-info">With Purchase</a>
                        </div> --}}
                    </div>



                    <div class="row pt-2 d-flex justify-content-end">
                        <div class="col-6">
                            <div style="width: 40%">
                                <select name="filter" id="filter" class="form-control">
                                    <option value="">Filter...</option>
                                    @foreach (App\PayMode::get() as $mode )
                                    <option value="{{ $mode->title }}">{{ $mode->title }}</option>

                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            @if(isset($date))
                            <a href="{{ route('invoiceWiseDailySalePrintDate',$date) }}" class="btn btn-sm btn-info float-right"
                            target="_blank">Print</a>
                            @elseif (isset($searchDatefrom))
                            <a href="{{ route('invoiceWiseDailySalePrintRange',['from'=>$from,'to'=>$to]) }}" class="btn btn-sm btn-info float-right"
                            target="_blank">Print</a>
                            @else
                            <a href="{{ route('invoiceWiseDailySalePrint') }}" class="btn btn-sm btn-info float-right"
                            target="_blank">Print</a>
                            @endif
                            {{-- <button class="btn  btn-info btn-sm float-right mr-1"
                        onclick="exportTableToCSV('stockPosition-{{ date('d M Y') }}.csv')">Export To CSV</button> --}}
                        </div>
                        <div class="table-responsive pt-1">
                            <table class="table table-sm table-bordered">
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
                                <tbody class="invoice-tbody">
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
                                </tbody>


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
      $(document).ready(function() {
    $('#filter').change(function() {

        if ($(this).val() != '') {
            var date = $('#hidden_date').val();

            var from = $('#hidden_date_from').val();

            var to = $('#hidden_date_to').val();

            var value = $(this).val();

            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('filterInvoiceWiseSaleReport') }}",
                method: "POST",
                data: {
                    value: value,
                    date:date,
                    from:from,
                    to:to,
                    _token: _token,
                },
                success: function(response) {
                    $(".invoice-tbody").empty().append(response.page);
                }
            })
        }
    });

});
    </script>


@endpush
