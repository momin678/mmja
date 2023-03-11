@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        
    </style>
@endpush
@php
    $grand_total_value=0;
    $grand_total_pcs=0;
@endphp
@section('title', 'General Ledger')

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
                            {{-- {{ date('d M Y') }} --}}
                            <h4>General Ledger</h4>
                        </div>
                           <div class="col-md-2 text-right">
                            <form action="{{ route('general-ledger-by-date') }}" method="GET">
                               <div class="row form-group">
                                <input type="text" class="form-control col-9" name="date"  placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                               </div>
                            </form>
                           </div>
                           <div class="col-md-6  col-left-padding">
                                <form action="{{ route('general-ledger-by-date-range') }}" method="GET">
                                    
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
                           </div>
                            <input type="hidden" name="hidden_date_from" value="{{ isset($from)? $from:"" }}" id="hidden_date_from">
                            <input type="hidden" name="hidden_date_to" value="{{ isset($to)? $to:"" }}" id="hidden_date_to">
                        
                        </div>
                    </div>

                    <div class="row pt-2">
                        <div class="col-md-12">
                            <a href="{{ route('print-gl') }}" class="btn btn-sm btn-info float-right"
                            target="_blank">Print</a>
                            <button class="btn  btn-info btn-sm float-right mr-1"
                        onclick="exportTableToCSV('general-ledger-{{ date('d M Y') }}.csv')">Export To CSV</button>
                        </div>
                        <table   class="table table-sm table-bordered">
                            <tr>
                                <th colspan="5">General Ledger</th>
                            </tr>

                            @foreach (App\JournalRecordsTemp::distinct()->get('account_head_id') as $unique_acc_head)
                            <tr>                                
                                <th>{{ $unique_acc_head->ac_head->fld_ac_code}}</th>
                                <th>{{ $unique_acc_head->ac_head->fld_ac_head}}</th>
                                <th></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                            </tr>
                            <tr>                                
                                <th>Date</th>
                                <th>Narration</th>
                                <th>Ref. No.</th>
                                <th class="text-right">Debit</th>
                                <th class="text-right">Credit</th>
                            </tr>
                                @php
                                    $each_ledger_dr=0;
                                    $each_ledger_cr=0;
                                @endphp
                                @foreach (App\JournalRecordsTemp::where('account_head_id', $unique_acc_head->account_head_id )->get() as $record)
                                    
                                    @php
                                        $reverse= $record->transaction_type== "DR" ? "CR" : "DR";   
                                    @endphp
                                    @foreach (App\JournalRecordsTemp::where('journal_temp_id',$record->journal_temp_id)->where('transaction_type', $reverse)->get() as $ledger_record)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($ledger_record->created_at)->format('d.m.Y')}}</td>
                                        <td>
                                            {{$ledger_record->account_head}}
                                        </td>
                                        <td></td>
                                        <td class="text-right">{{ $dr_amount= $record->transaction_type=='DR' ? $ledger_record->amount : 0 }} </td>
                                        <td class="text-right">{{ $cr_amount= $record->transaction_type=='CR' ? $ledger_record->amount : 0 }}</td>
                                    </tr>
                                    @php
                                        $each_ledger_dr= $each_ledger_dr+$dr_amount;
                                        $each_ledger_cr= $each_ledger_cr+$cr_amount;
                                    @endphp

                                    @endforeach

                                @endforeach
                                <tr>                                
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th class="text-right">{{ number_format($each_ledger_dr,2) }}</th>
                                    <th class="text-right">{{ number_format($each_ledger_cr,2)}}</th>
                                </tr>

                                <tr>                                
                                    <td> <p></p></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>


                            @endforeach
                            {{-- <tr>
                                <th></th>
                                <th>Grand Total (Pcs)</th>
                                <td>{{ $grand_total_pcs }}</td>
                                <th>Grand Total</th>
                                <td>{{number_format((float) $grand_total_value,'2','.','') }}</td>
                            </tr> --}}
                        </table>

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
