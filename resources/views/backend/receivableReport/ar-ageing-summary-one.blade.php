@extends('layouts.backend.app')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
$currency= \App\Setting::where('config_name', 'currency')->first();

@endphp
@section('title', 'AR Ageing Details By Invoice Due Date')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        table td+td+td+td+td+td{
            text-align: right;
        }
        .custom-border td{
            border-right: 1px solid #f2f4f4 !important;
        }
        tr td:last-child {
            border-right:1px solid #dfe3e7 !important;
      }
      tr th{
        min-width: 100px !important;
      }
    </style>
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
                            <h4>{{ $company_name->config_value}}</h4>
                            <h6> AR Ageing Details By Invoice Due Date</h6>
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
                                        <th>Date</th>
                                        <th>Transaction#</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Customer Name</th>
                                        <th>Age</th>
                                        <th>Amount</th>
                                        <th>Balance Due</th>                                    
                                    </tr>
                                </thead>
                                <tbody class="invoice-tbody">
                                    @php
                                        $grand_total_invoice=0;
                                        $grand_total_credit=0;
                                        $grand_total_balance=0;

                                        $today= date('Y-m-d');
                                        $day_1st1= $today;
                                        $day_1st2= date('Y-m-d', strtotime("- 14 days"));

                                        $day_2nd1= date('Y-m-d', strtotime("- 15 days"));
                                        $day_2nd2= date('Y-m-d', strtotime("- 29 days"));
                                        $day_3rd1= date('Y-m-d', strtotime("- 30 days"));
                                        $day_3rd2= date('Y-m-d', strtotime("- 44 days"));
                                        $day_4th1= date('Y-m-d', strtotime("- 45 days"));
                                        $day_4th2= date('Y-m-d', strtotime("- 59 days"));

                                        $day_5th= date('Y-m-d', strtotime("- 60 days"));
                                        $day1='1-15 Days';
                                        $day2='16-30 Days';
                                        $day3='31-45 Days';
                                        $day4='46-60 Days';
                                        $day5='>60 Days';
                                    @endphp
                                    
                                <tr class="custom-border"> 
                                    <td> <b> {{ $partyinfo->pi_name}} </b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                               @foreach($invoices as $invoice)
                                    
                                @if ( $invoice->due_date >= $day_1st2 && $invoice->due_date <= $day_1st1)
                                
                                    @if ($day1!='')
                                        <tr class="custom-border"> 
                                            <td> <b> {{ $day1}} </b></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @php
                                            $day1='';
                                        @endphp
                                    @endif

                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }} </td>
                                        <td>{{ $invoice->invoice_no }}</td>
                                        <td>{{ 'Invoice' }}</td>
                                        <td>{{ 'Sent' }}</td>
                                        <td>{{ $invoice->partyInfo($invoice->customer_name)->pi_name }}</td>
                                        <td>
                                            @php
                                                
                                                $date = \Carbon\Carbon::parse($invoice->due_date);
                                                $now = \Carbon\Carbon::now();
                                                echo $diff = $date->diffInDays($now).' Days';

                                            @endphp
                                        </td>
                                        <td>{{ $invoice->grand_total }}</td>
                                        <td>{{ $invoice->grand_total }}</td>                                
                                    </tr>
                                    
                                    
                                    @elseif($invoice->due_date >= $day_2nd2 && $invoice->due_date <= $day_2nd1)

                                        @if ($day2!='')
                                            <tr class="custom-border"> 
                                                <td> <b> {{ $day2}} </b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @php
                                                $day2='';
                                            @endphp
                                        @endif

                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }} </td>
                                        <td>{{ $invoice->invoice_no }}</td>
                                        <td>{{ 'Invoice' }}</td>
                                        <td>{{ 'Sent' }}</td>
                                        <td>{{ $invoice->partyInfo($invoice->customer_name)->pi_name }}</td>
                                        <td>
                                            @php
                                                
                                                $date = \Carbon\Carbon::parse($invoice->due_date);
                                                $now = \Carbon\Carbon::now();
                                                echo $diff = $date->diffInDays($now).' Days';

                                            @endphp
                                        </td>
                                        <td>{{ $invoice->grand_total }}</td>
                                        <td>{{ $invoice->grand_total }}</td>                                
                                    </tr>

                                    @elseif($invoice->due_date >= $day_3rd2 && $invoice->due_date <= $day_3rd1)

                                        @if ($day3!='')
                                            <tr class="custom-border"> 
                                                <td> <b> {{ $day3}} </b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @php
                                                $day3='';
                                            @endphp
                                        @endif

                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }} </td>
                                        <td>{{ $invoice->invoice_no }}</td>
                                        <td>{{ 'Invoice' }}</td>
                                        <td>{{ 'Sent' }}</td>
                                        <td>{{ $invoice->partyInfo($invoice->customer_name)->pi_name }}</td>
                                        <td>
                                            @php
                                                
                                                $date = \Carbon\Carbon::parse($invoice->due_date);
                                                $now = \Carbon\Carbon::now();
                                                echo $diff = $date->diffInDays($now).' Days';

                                            @endphp
                                        </td>
                                        <td>{{ $invoice->grand_total }}</td>
                                        <td>{{ $invoice->grand_total }}</td>                                
                                    </tr>

                                    @elseif($invoice->due_date >= $day_4th2 && $invoice->due_date <= $day_4th1)

                                        @if ($day4!='')
                                            <tr class="custom-border"> 
                                                <td> <b> {{ $day4}} </b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @php
                                                $day4='';
                                            @endphp
                                        @endif

                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }} </td>
                                        <td>{{ $invoice->invoice_no }}</td>
                                        <td>{{ 'Invoice' }}</td>
                                        <td>{{ 'Sent' }}</td>
                                        <td>{{ $invoice->partyInfo($invoice->customer_name)->pi_name }}</td>
                                        <td>
                                            @php
                                                
                                                $date = \Carbon\Carbon::parse($invoice->due_date);
                                                $now = \Carbon\Carbon::now();
                                                echo $diff = $date->diffInDays($now).' Days';

                                            @endphp
                                        </td>
                                        <td>{{ $invoice->grand_total }}</td>
                                        <td>{{ $invoice->grand_total }}</td>                                
                                    </tr>

                                    @elseif($invoice->due_date <= $day_5th)

                                        @if ($day5!='')
                                            <tr class="custom-border"> 
                                                <td> <b> {{ $day5}} </b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @php
                                                $day5='';
                                            @endphp
                                        @endif

                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }} </td>
                                        <td>{{ $invoice->invoice_no }}</td>
                                        <td>{{ 'Invoice' }}</td>
                                        <td>{{ 'Sent' }}</td>
                                        <td>{{ $invoice->partyInfo($invoice->customer_name)->pi_name }}</td>
                                        <td>
                                            @php
                                                
                                                $date = \Carbon\Carbon::parse($invoice->due_date);
                                                $now = \Carbon\Carbon::now();
                                                echo $diff = $date->diffInDays($now).' Days';

                                            @endphp
                                        </td>
                                        <td>{{ $invoice->grand_total }}</td>
                                        <td>{{ $invoice->grand_total }}</td>                                
                                    </tr>
                                    @else

                                    @endif
                                    
                                @endforeach
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

});
    </script>


@endpush
