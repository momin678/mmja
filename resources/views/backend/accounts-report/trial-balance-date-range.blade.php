@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        
    </style>
@endpush

@section('title', 'Trial Balance')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-6">
                            {{-- {{ date('d M Y') }} --}}
                            <h4>Trial Balance</h4>
                           </div>
                           <div class="col-md-2 text-right">
                            <form action="{{ route('trial-balance-date') }}" method="GET">
                               <div class="row form-group">
                                <input type="text" class="form-control col-9" name="date"  placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                               </div>
                            </form>
                           </div>
                           <div class="col-md-4  col-left-padding">
                                <form action="{{ route('trial-balance-date-range') }}" method="GET">
                                    
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
                            <a href="{{ route('trial-balance-print-date-range',[$from,$to]) }}" class="btn btn-sm btn-info float-right"
                            target="_blank">Print</a>
                            <button class="btn  btn-info btn-sm float-right mr-1"
                        onclick="exportTableToCSV('trial-balance-{{ date('d M Y') }}.csv')">Export To CSV</button>
                        </div>
                        <table   class="table table-sm table-bordered">
                            <tr>
                                <th colspan="4" class="text-center">
                                    <h2>Trial Balance</h2>
                                    <h4>From {{$from}} to {{$to}}</h4>
                                </th>
                            </tr>
                            <tr>                                
                                <th>A/C Head</th>
                                <th></th>
                                <th class="text-right">Debit</th>
                                <th class="text-right">Credit</th>
                            </tr>
                            @php
                                $total_debit=0;
                                $total_credit=0;
                            @endphp
                            @foreach (App\JournalRecordsTemp::whereBetween('journal_date', [$from,$to])->distinct()->get('master_account_id') as $unique_master_ac)

                            <tr>                                
                                <th>{{$unique_master_ac->master_ac->mst_definition}}</th>
                                <th></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                            </tr>
                                @php
                                    $each_ledger_dr=0;
                                    $each_ledger_cr=0;
                                @endphp
                                @foreach (App\JournalRecordsTemp::where('master_account_id', $unique_master_ac->master_account_id )->whereBetween('journal_date', [$from,$to])->distinct()->get('account_head_id') as $account_head_id)
                                    
                                    @php
                                        $single_dr=0;
                                        $single_cr=0;
                                    @endphp
                                    @foreach (App\JournalRecordsTemp::where('account_head_id', $account_head_id->account_head_id)->whereBetween('journal_date', [$from,$to])->get() as $single_jl_entry)

                                    @php                                        
                                    if($single_jl_entry->transaction_type=="DR"){
                                        $single_dr= $single_dr+ $single_jl_entry->amount;
                                    }else{
                                        $single_cr =$single_cr+ $single_jl_entry->amount;
                                    }   
                                    @endphp
                                        
                                    @endforeach
                                    
                                    @php
                                        if($single_dr> $single_cr){
                                                $debit_balance = $single_dr- $single_cr;
                                                $credit_balance=0;
                                                $total_debit= $total_debit+ $debit_balance;
                                            }elseif($single_cr> $single_dr){
                                                $credit_balance = $single_cr- $single_dr;
                                                $debit_balance=0;
                                                $total_credit = $total_credit + $credit_balance;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{$account_head_id->ac_head->fld_ac_head}}</td>
                                        <td></td>
                                        <td>{{$debit_balance}}</td>
                                        <td>{{$credit_balance}}</td>
                                    </tr>

                                @endforeach
                                

                                <tr>                                
                                    <td> <p></p></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>


                            @endforeach
                            <tr>
                                <th></th>
                                <th>Grand Total</th>
                                <th>{{ number_format($total_debit,2)}} </th>
                                <th>{{ number_format($total_credit,2)}}</th>
                            </tr>
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
