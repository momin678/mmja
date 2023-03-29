@extends('layouts.backend.app')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
$currency= \App\Setting::where('config_name', 'currency')->first();

@endphp
@section('title', 'Receivable Summary')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('content')
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
                            <h4> Receivable Summary</h4>
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <a href="{{route('receivable-summary-excel-download')}}" class="btn btn-info">Excel</a>
                        <a href="{{route('receivable-summary-pdf-download')}}" class="btn btn-light mr-1">PDF Download</a>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <div class="table-responsive pt-1">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr style="height: 50px;">
                                        <th>Customer Name</th>
                                        <th>Date</th>
                                        <th>Transaction#</th>
                                        <th>Reference#</th>
                                        <th>Status</th>
                                        <th>Transaction Type</th>
                                        <th>Total</th>
                                        <th>Balance</th>                                    
                                    </tr>
                                <thead/>
                                <tbody class="invoice-tbody">
                                    @php
                                        $grand_total_invoice=0;
                                        $grand_total_credit=0;
                                        $grand_total_balance=0;
                                    @endphp
                                    @foreach($invoices as $invoice)
                                        <tr>
                                            <td>
                                                @if (isset($invoice->partyInfo($invoice->customer_name)->pi_name))
                                                    <a href="{{ route('receivable-details', $invoice->partyInfo($invoice->customer_name)->id) }}" target="_blank">{{ $invoice->partyInfo($invoice->customer_name)->pi_name }}</a>
                                                @endif
                                            </td>
                                            <td>{{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }} </td>
                                            <td>{{ $invoice->invoice_no }}</td>
                                            <td>-</td>
                                            <td>Sent</td>
                                            <td>Invoice</td>
                                            <td>{{ $invoice->grand_total }}</td>
                                            <td>{{ $invoice->grand_total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>


                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-right mt-1">
                            {{ $invoices->links() }}
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
