@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
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
                        <div class="col-md-6  mt-2">
                            <h4>Invoice Details </h4>
                        </div>
                        <div class="col-md-6  mt-2 text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                Fitter
                              </button>
                        </div>
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
                                        <th>Status</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Number</th>
                                        <th>Customer order</th>
                                        <th>Customer Name</th>
                                        <th>Total</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($invoicess as $key => $invoice)
                                    <tr class="trFontSize">
                                        <td>
                                            @if ($invoice->invoiceAmount->amount_from == 0)
                                                <span>Unpaid</span>
                                            @elseif($invoice->invoiceAmount->amount_from>0 && $invoice->invoiceAmount->amount_to<0)
                                                <span>Partial</span>
                                            @else
                                                <span>Paid</span>
                                            @endif
                                        </td>
                                        
                                        <td>{{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }} </td>
                                        <td><a href="#" class="invoice-details" id="{{ $invoice->invoice_no }}">{{ $invoice->invoice_no }}</a></td>
                                        <td></td>
                                        <td>{{ $invoice->partyInfo($invoice->customer_name)->pi_name }}</td>
                                        <td><small>(AED) </small>{{ number_format($invoice->grossTotal($invoice->invoice_no),2) }}</td>
                                        <td><small>(AED) </small>{{substr(number_format($invoice->invoiceAmount->amount_to,2),1)  }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-right mt-1">
                            {{ $invoicess->links() }}
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
    </script>
@endpush