@extends('layouts.backend.app')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
$currency= \App\Setting::where('config_name', 'currency')->first();

@endphp
@section('title', 'AP Ageing Details By Invoice Due Date')
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
                            <h4> AP Ageing Details By Invoice Due Date</h4>
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
                            <table class="table table-sm table-hover exprortTable">
                                <thead class="thead-light">
                                    <tr style="height: 50px; border-top: 1px solid;">
                                        <th>Date</th>
                                        <th>Transaction#</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Vendor Name</th>
                                        <th>Age</th>
                                        <th>Amount</th>
                                        <th>Balance Due</th>
                                    </tr>
                                </thead>
                                <tbody class="invoice-tbody">

                                    <tr>
                                        <td class="text-left"> <b> 1-15 Days </b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach($purchase_1 as $purch)
                                    <tr>
                                        <td>{{ $purch->date }}</td>
                                        <td>{{ $purch->purchase_no }}</td>
                                        <td>{{ 'Purchase' }}</td>
                                        <td>{{ 'Receive' }}</td>
                                        <td>{{$purch->partInfo->pi_name }}</td>
                                        <td>
                                            @php

                                                $date = \Carbon\Carbon::parse($purch->pay_date);
                                                $now = \Carbon\Carbon::now();
                                                echo $diff = $date->diffInDays($now).' Days';

                                            @endphp
                                        </td>
                                        <td>{{ $purch->grand_total }}</td>
                                        <td>{{ $purch->grand_total }}</td>
                                    </tr>
                                    @endforeach

                                <tr>
                                    <td class="text-left"> <b> 16-30 Days </b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>        
                                </tr>
                               @foreach($purchase_2 as $purch)


                               <tr>
                                <td>{{ $purch->date }}</td>
                                <td>{{ $purch->purchase_no }}</td>
                                <td>{{ 'Invoice' }}</td>
                                <td>{{ 'Receive' }}</td>
                                <td>{{$purch->partInfo->pi_name }}</td>
                                <td>
                                    @php

                                        $date = \Carbon\Carbon::parse($purch->pay_date);
                                        $now = \Carbon\Carbon::now();
                                        echo $diff = $date->diffInDays($now).' Days';

                                    @endphp
                                </td>
                                <td>{{ $purch->grand_total }}</td>
                                <td>{{ $purch->grand_total }}</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td class="text-left"> <b> 31-45 Days </b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                               @foreach($purchase_3 as $purch)


                               <tr>
                                <td>{{ $purch->date }}</td>
                                <td>{{ $purch->purchase_no }}</td>
                                <td>{{ 'Invoice' }}</td>
                                <td>{{ 'Receive' }}</td>
                                <td>{{$purch->partInfo->pi_name }}</td>
                                <td>
                                    @php

                                        $date = \Carbon\Carbon::parse($purch->pay_date);
                                        $now = \Carbon\Carbon::now();
                                        echo $diff = $date->diffInDays($now).' Days';

                                    @endphp
                                </td>
                                <td>{{ $purch->grand_total }}</td>
                                <td>{{ $purch->grand_total }}</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td class="text-left"> <b> 45-60 Days </b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                               @foreach($purchase_4 as $purch)


                               <tr>
                                <td>{{ $purch->date }}</td>
                                <td>{{ $purch->purchase_no }}</td>
                                <td>{{ 'Invoice' }}</td>
                                <td>{{ 'Receive' }}</td>
                                <td>{{$purch->partInfo->pi_name }}</td>
                                <td>
                                    @php

                                        $date = \Carbon\Carbon::parse($purch->pay_date);
                                        $now = \Carbon\Carbon::now();
                                        echo $diff = $date->diffInDays($now).' Days';

                                    @endphp
                                </td>
                                <td>{{ $purch->grand_total }}</td>
                                <td>{{ $purch->grand_total }}</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td class="text-left"> <b> >60 Days </b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                               @foreach($purchase_5 as $purch)


                               <tr>
                                <td>{{ $purch->date }}</td>
                                <td>{{ $purch->purchase_no }}</td>
                                <td>{{ 'Invoice' }}</td>
                                <td>{{ 'Receive' }}</td>
                                <td>{{$purch->partInfo->pi_name }}</td>
                                <td>
                                    @php

                                        $date = \Carbon\Carbon::parse($purch->pay_date);
                                        $now = \Carbon\Carbon::now();
                                        echo $diff = $date->diffInDays($now).' Days';

                                    @endphp
                                </td>
                                <td>{{ $purch->grand_total }}</td>
                                <td>{{ $purch->grand_total }}</td>
                                </tr>
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

});
    </script>


@endpush
