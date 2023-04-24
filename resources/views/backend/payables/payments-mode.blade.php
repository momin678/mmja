@extends('layouts.backend.app')
@php
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
@endphp
@section('title', 'Payments Mode')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        td{
            font-size: 12px !important;
        }
    </style>
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
                        <div class="col-md-12  mt-2 text-center">
                            <h4>{{ $company_name->config_value}}</h4>
                            <h5>Payments Mode</h5>
                        </div>
                        {{-- <div class="col-md-6  mt-2 text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                Fitter
                              </button>
                        </div> --}}
                    </div>
                </section>

                <section class="mr-1 ml-1">
                    <div class="mt-2">
                        <div class="cardStyleChange">
                            <table class="table mb-0 table-sm table-hover exprortTable">
                                <thead  class="thead-light">
                                    <tr style="height: 50px;">
                                        <th>Date</th>
                                        <th>Referance#</th>
                                        <th>Bill#</th>
                                        <th>Vendor Name</th>
                                        <th>Payment Mode</th>
                                        <th>Notes</th>
                                        <th>Paid Through</th>
                                        <th class="text-right pl-2">Amount</th>
                                        <th class="text-right pl-2"> Amount (FCY)</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($journals as $key => $journal)
                                        <tr>
                                            <td>{{$journal->date}} </td>
                                            <td>
                                                @if ($journal->referance)
                                                    {{$journal->referance->name}}
                                                @endif
                                            </td>
                                            <td>{{$journal->journal_no}}</td>
                                            <td>{{$journal->party->pi_name}}</td>
                                            <td>{{$journal->pay_mode}}</td>
                                            <td></td>
                                            <td>
                                                @if ($journal->pay_mode == 'Credit')
                                                    @php
                                                        $user = App\User::find($journal->approved_by);
                                                    @endphp
                                                    Petty Cash - {{$user->name}}
                                                @endif
                                                @if ($journal->pay_mode == 'Cash')
                                                    @php
                                                        $user = App\User::find($journal->approved_by);
                                                    @endphp
                                                    {{$user->name}} Portal
                                                @endif
                                                @if ($journal->pay_mode == 'Card')
                                                    @php
                                                        $bank = App\Models\BankDetail::first();
                                                    @endphp
                                                    @if ($bank)
                                                        {{$bank->bank_name}}
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-right"><small>(AED)</small> {{number_format($journal->total_amount,2)}}</td>
                                            <td class="text-right"><small>(AED)</small> {{number_format($journal->total_amount,2)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="vendor-balances-modal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="min-width: 90% !important;">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                </div>
            </section>
            <div id="vendor-balances-details-content">
                
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
        $(document).on("click", ".vendor-balances-details", function(e) {
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{URL('vendor-balances-details')}}",
                method: "POST",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){
                    document.getElementById("vendor-balances-details-content").innerHTML = response;
                    $('#vendor-balances-modal').modal('show');
                }
            });
        });
    </script>
@endpush