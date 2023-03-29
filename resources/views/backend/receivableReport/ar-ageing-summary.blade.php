@extends('layouts.backend.app')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
$currency= \App\Setting::where('config_name', 'currency')->first();

@endphp
@section('title', 'AR Ageing Summary By Invoice Due Date')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        th{
            /* text-transform: uppercase; */
            font-size: 11px !important;
        }
    </style>
@endpush
<style>
    @media(min-width: 992px){
        .modal-lg{
            
        }
    }
    @media print {
        .menu-accordion{
            visibility: hidden;
        }
        .party-name{
            text-decoration: none !important;
            color: black;
        }
    }
</style>
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
                        <div class="col-md-12 text-center">
                            {{-- {{isset($searchDate)? $searchDate: (isset($searchDatefrom)? $searchDatefrom." to ".$searchDateto: date('d M Y')) }} --}}
                            <h4>{{ $company_name->config_value}}</h4>
                            <h6> AR Ageing Summary By Invoice Due Date</h6>
                        </div>

                        {{-- <div class="col-md-2 text-right  col-left-padding">
                            <form action="{{ route('searchinvoiceWIseDate') }}" method="GET">
                                
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
                        </div> --}}
                        
                    </div>



                    <div class="row pt-2 d-flex justify-content-end">
                        <div class="col-6">
                            <div style="width: 40%">
                                {{-- <select name="filter" id="filter" class="form-control">
                                    <option value="">Filter...</option>
                                    @foreach (App\PayMode::get() as $mode )
                                    <option value="{{ $mode->title }}">{{ $mode->title }}</option>

                                    @endforeach
                                </select> --}}

                            </div>
                        </div>
                        <div class="table-responsive pt-1">
                            <table class="table table-sm table-bordered exprortTable">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Current</th>
                                        <th>1-15 Days</th>
                                        <th>16-30 Days</th>
                                        <th>31-45 Days</th>
                                        <th>46-60 Days</th>
                                        <th>>60 Days</th>
                                        <th>Total</th>                                    
                                    </tr>
                                </thead>
                                <tbody class="invoice-tbody">
                                    @php
                                        $grand_total_invoice=0;
                                        $grand_total_credit=0;
                                        $grand_total_balance=0;
                                    @endphp
                               @foreach($parties as $party)

                               <tr>
                                <td>
                                    <a href="{{ route('ar-ageing-summary-one', $party->id) }}" target="_blank" class="party-name">{{ $party->pi_name }}</a>
                                </td>
                                <td class="text-right">{{ $party->current }}</td>
                                <td class="text-right">{{ $party->days_1_15 }}</td>
                                <td class="text-right">{{ $party->days_16_30 }}</td>
                                <td class="text-right">{{ $party->days_31_45 }}</td>
                                <td class="text-right">{{ $party->days_46_60 }}</td>
                                <td class="text-right">{{ $party->days_up_60 }}</td>
                                <td class="text-right">{{ $party->gtotal }}</td>
                                {{-- <td>
                                    <a href="#" class="btn customer-details" id="{{ $party->customer_name}}"> {{ $party->partyInfo($party->customer_name)->pi_name }}</a>
                                </td>
                                <td>{{ $party->total_invoice_amount }}</td>
                                <td>{{ $available_credit= ($party->partyInfo($party->customer_name)->credit_limit -  $party->total_invoice_amount) }}</td>
                                <td>{{ $balance= $party->total_invoice_amount - $available_credit }}</td>                                --}}
                                </tr>
                                    {{-- @php
                                        $grand_total_invoice=$grand_total_invoice+$party->total_invoice_amount;
                                        $grand_total_credit=$grand_total_credit+$available_credit;
                                        $grand_total_balance=$grand_total_balance+$balance;
                                    @endphp --}}
                                @endforeach
                                {{-- <tr>
                                    <td colspan="2" style="text-center">Grand Total</td>
                                    <td>{{ number_format((float)$grand_total_invoice,'2','.','')}}</td>
                                    <td>{{ number_format((float)$grand_total_credit,'2','.','')}}</td>
                                    <td>{{ number_format((float)$grand_total_balance,'2','.','')}}</td>

                                </tr> --}}
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
    
    <div class="modal fade bd-example-modal-lg" id="projectViewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="min-width: 90% !important;">
            <div class="modal-content">
                <div id="projectViewDetails">
                    
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="invoice-modal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="min-width: 90% !important;">
          <div class="modal-content">
            <section class="print-hideen border-bottom p-1">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                    </div>
            </section>
            <div id="invoice-details-content" class="m-1">
            </div>
          </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
      $(document).ready(function() {

        $(document).on("click", ".customer-details", function(e) { 
            e.preventDefault();
            
            var id= $(this).attr('id');
            // alert(id);
            $.ajax({
                url: "{{URL('customer-invoice-report')}}",
                method: "POST",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){				
                    document.getElementById("projectViewDetails").innerHTML = response;
                    $('#projectViewModal').modal('show');
                }
            });
        });

        $(document).on("click", ".invoice-details", function(e) { 
          e.preventDefault();
          
          var id= $(this).attr('id');
            //   alert(id);
          $.ajax({
              url: "{{URL('invoice-view-modal')}}",
              method: "POST",
              cache: false,
              data:{
                  _token:'{{ csrf_token() }}',
                  id:id,
              },
              success: function(response){				
                  document.getElementById("invoice-details-content").innerHTML = response;
                  $('#invoice-modal').modal('show');
              }
          });
        });

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
        
        $(document).on("click", "#pagePrint", function(e){
            e.preventDefault();
            window.print();
        });
    });
    </script>


@endpush
