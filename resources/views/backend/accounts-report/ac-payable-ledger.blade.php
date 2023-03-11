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
                            <h4>Accounts Payable Ledger
                                @php
                                    if(isset($date)){
                                        echo $date;
                                    }elseif(isset($from) && isset($to)){
                                        echo $from.' to '.$to;
                                    }
                                @endphp
                            </h4>
                        </div>
                           <div class="col-md-2 text-right">
                            <form action="{{ route('ac-payable-ledger') }}" method="GET">
                               <div class="row form-group">
                                <input type="text" class="form-control col-9" name="date"  placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                               </div>
                            </form>
                           </div>
                           <div class="col-md-6  col-left-padding">
                                <form action="{{ route('ac-payable-ledger') }}" method="GET">
                                    
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
                                <th colspan="5">General Ledger </th>
                            </tr>
                            @php
                                $acc_head= App\Models\AccountHead::find($ac_payable_id);
                            @endphp
                            
                            <tr>                                
                                <th>{{ $acc_head->fld_ac_code}}</th>
                                <th>{{ $acc_head->fld_ac_head}}</th>
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
                                    if(isset($date)){
                                        $records= App\JournalRecordsTemp::where('journal_date',$date)->where('account_head_id', $ac_payable_id )->get();
                                    }elseif(isset($from) && isset($to)){
                                        $records= App\JournalRecordsTemp::whereBetween('journal_date',[$from,$to])->where('account_head_id', $ac_payable_id )->get();
                                    }else{
                                        $records= App\JournalRecordsTemp::where('account_head_id', $ac_payable_id )->get();
                                    }
                                @endphp
                                @foreach ($records as $record)
                                    
                                    @php
                                        $reverse= $record->transaction_type== "DR" ? "CR" : "DR";
                                        if(isset($date)){
                                            $ledger_records= App\JournalRecordsTemp::where('journal_date',$date)->where('journal_temp_id',$record->journal_temp_id)->where('transaction_type', $reverse)->get();
                                            
                                        }elseif(isset($from) && isset($to)){
                                            $ledger_records= App\JournalRecordsTemp::whereBetween('journal_date',[$from,$to])->where('journal_temp_id',$record->journal_temp_id)->where('transaction_type', $reverse)->get();
                                            
                                        }else{
                                            $ledger_records= App\JournalRecordsTemp::where('journal_temp_id',$record->journal_temp_id)->where('transaction_type', $reverse)->get();
                                            
                                        }   
                                    @endphp
                                    @foreach ($ledger_records as $ledger_record)
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
