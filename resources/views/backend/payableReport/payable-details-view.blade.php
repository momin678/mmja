@extends('layouts.backend.app')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
$currency= \App\Setting::where('config_name', 'currency')->first();

@endphp
@section('title', 'Customer Balance')
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
<style>
    @media(min-width: 992px){
        .modal-lg{

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
                            <h5>{{ $company_name->config_value}}</h5>
                            <h4> Payable Details</h4>
                        </div>
                    </div>

                    <div class="row pt-2 d-flex justify-content-end">
                        <div class="col-md-6">

                            {{-- <button class="btn  btn-info btn-sm float-right mr-1"
                        onclick="exportTableToCSV('stockPosition-{{ date('d M Y') }}.csv')">Export To CSV</button> --}}
                        </div>
                        <div class="table-responsive pt-1">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Transaction#</th>
                                    <th>Vendor Name#</th>
                                    <th>Transaction Type</th>
                                    <th>Item Name</th>
                                    <th>Quantity Ordered</th>
                                    <th>Item Price <small>(BCY)</small></th>
                                    <th>Item Amount (BCY)</th>
                                </tr>
                                <tbody class="invoice-tbody">
                                    @php
                                        $grand_total_invoice=0;
                                        $grand_total_credit=0;
                                        $grand_total_balance=0;
                                    @endphp
                               @foreach($purchases as $purch)

                               <tr>
                                <td class="{{$purch->paid_status?"": ($purch->pay_date<date('Y-m-d')?'text-danger':"")}}">{{$purch->paid_status? "Paid" : ($purch->pay_date<date('Y-m-d')?'Overdue':"Open")}}</td>
                                <td>
                                    {{$purch->date}}
                                </td>
                                <td><a href="{{route('item-purchase.show',$purch)}}">{{ $purch->purchase_no }}</a> </td>

                                <td>
                                    
                                    @if(isset($purch->partInfo))
                                        <a href="{{ route('payable-details',$purch->partInfo->id) }}" target="_blank">{{$purch->partInfo->pi_name }}</a>
                                    @endif

                                </td>
                                <td>Purchase</td>
                                <td>-</td>
                                <td>{{$purch->purchase_details->sum('quantity')}}</td>
                                
                                <td>{{number_format($purch->grand_total/$purch->purchase_details->sum('quantity'),2) }}</td>
                                <td>{{ $purch->grand_total }}</td>

                                </tr>
                                    {{-- @php
                                        $grand_total_invoice=$grand_total_invoice+$invoice->total_invoice_amount;
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
                    <div class="row">
                        <div class="col-12 text-right mt-1">
                            {{ $purchases->links() }}
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

});
    </script>


@endpush
