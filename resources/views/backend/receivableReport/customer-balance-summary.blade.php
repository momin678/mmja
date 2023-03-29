@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@php
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
@endphp
@section('title', 'Invoice Details')
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content print-hidden">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="tab-content bg-white">
            <div>
                <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                    <div class="row">
                        <div class="col-md-12 text-center mt-2">
                            <h4>{{ $company_name->config_value}}</h4>
                            <h6> Customer Balance Summary</h6>
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <a href="#" class="btn btn-primary mr-1" data-toggle="modal" data-target="#exampleModalCenter">Fitter</a>
                        <a href="{{route('customer-balance-excel-download')}}" class="btn btn-info mr-1">Excel</a>
                        <a href="{{route('customer-balance-pdf-download')}}" class="btn btn-light mr-1">PDF Download</a>
                    </div>
                </section>

                <section class="mr-1 ml-1">
                    <div class="mt-2">
                        {{-- <div class="row mb-1">
                            <div class="col-md-6">
                                <form>
                                <input type="text" name="q" class="form-control inputFieldHeight input-xs pull-right ajax-search" placeholder="Search By Code, Party Name, TRN Number"data-url="{{ route('admin.masterAccSearchAjax', $id = 'partyCenter') }}">
                                </form>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="#" onclick="partyListPrint()" class="btn btn-xs mPrint formButton" title="Print"><img  src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" alt="" srcset="" class="img-fluid" width="30"> Print</a>
                                <a href="#" class="btn btn-xs mExcelButton formButton" onclick="exportTableToCSV('PartyInfos.csv')" title="Export to Excel"><img  src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" alt="" srcset="" class="img-fluid" width="30">Export To Excel</a href="#">
                            </div>
                        </div> --}}
                        <div class="cardStyleChange">
                            <table class="table mb-0 table-sm table-hover">
                                <thead  class="thead-light">
                                    <tr style="height: 50px;">
                                        <th>Customer Name</th>
                                        <th class="text-right pr-2">Invoiced amount</th>
                                        <th class="text-right pr-2">Amount received</th>
                                        <th class="text-right pr-2">Closing balance</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($customers as $key => $customer)
                                        @php
                                            $party = App\PartyInfo::where('pi_code', $customer->customer_name)->first();
                                            $invoices = App\Invoice::where('customer_name', $customer->customer_name)->get();
                                            $invoice_amount = 0;
                                            $received_amount = 0;
                                            foreach ($invoices as $key => $invoice) {
                                                $invoice_amount += ($invoice->invoiceAmount->amount_from - $invoice->invoiceAmount->amount_to);
                                                $received_amount  += $invoice->invoiceAmount->amount_from;
                                            }
                                        @endphp
                                        @if ($party)
                                            <tr class="trFontSize">
                                                <td>
                                                    <a href="#" class="customer-summary-details" id="{{$customer->customer_name}}">
                                                        {{ $party->pi_name }}
                                                    </a>
                                                </td>
                                                <td class="text-right pr-2">{{ $invoice_amount }}</td>
                                                <td class="text-right pr-2">{{ $received_amount }}</td>
                                                <td class="text-right pr-2">{{ $invoice_amount-$received_amount }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-right mt-1">
                            {{ $customers->links() }}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="invoice-modal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="min-width: 90% !important;">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                </div>
            </section>
            <div id="invoice-details-content">
            </div>
            
          </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Customize Report</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="">
                    {{-- <div class="form-group">
                        <label for="">Date Range</label>
                        <select name="date_range" id="" class="form-control">
                            <option value="">Select Option</option>
                            <option value="{{date('Y-m-d')}}">Today</option>
                            <option value="{{date('m')}}">This Week</option>
                            <option value="this_month">This Month</option>
                            <option value="{{date('Y')}}">This Yesr</option>
                        </select>
                    </div> --}}
                    <div class="form-group">
                        <label for="">Single Date</label>
                        <input type="date" name="date" class="form-control">
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="">Date From</label>
                            <input type="date" class="form-control" name="date_from">
                        </div>
                        <div class="col-md-6">
                            <label for="">Date To</label>
                            <input type="date" class="form-control" name="date_to">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>
        $(document).on("click", ".customer-summary-details", function(e) {
          e.preventDefault();
          var id= $(this).attr('id');
          $.ajax({
              url: "{{URL('customer-summary-details')}}",
              method: "POST",
              cache: false,
              data:{
                  _token:'{{ csrf_token() }}',
                  id:id,
              },
              success: function(response){
                  document.getElementById("invoice-details-content").innerHTML = response;
                  $('#invoice-modal').modal('show');
                  showChart();
              }
          });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script>
        function showChart(){
            var xValues = [];
            var barColors = [];
            var yValues = [];
            var amount = [];
            var amount = [];
            $(".amount_list").each(function(i){
                yValues[i]= $(this).val();
                barColors[i]= "green";
            });
            $(".date_list").each(function (i) {
                xValues[i] = $(this).val();
            })
            new Chart("myChart", {
                type: "bar",
                data: {
                    labels: xValues,
                    datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                    }]
                },
                options: {
                    legend: {display: false},
                    title: {
                        display: true,
                        text: "Income this chart displayed in the organization's base currency."
                    }
                }
            });
        }
    </script>
@endpush