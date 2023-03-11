
@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<style>
    .tabPadding{
        padding: 5px;
    }
    .padding-right{
        padding-right: 10px;
    }
    @media(min-width:1300px){
        .padding-right{
            padding-right: 0px !important;
        }
    }
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route("new-general-ledger")}}" class="nav-item nav-link tabPadding" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/ledger-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>General Ledger</div>
                </a>
                <a href="{{route('new-trial-balance')}}" class="nav-item nav-link tabPadding active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/trial-balence-icon.png')}}" class="img-fluid" width="50">
                    </div>
                    <div>Trial Balance</div>
                </a>
                <a href="#" class="nav-item nav-link tabPadding" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/income-statement-icon.png')}}" class="img-fluid" width="50">
                    </div>
                    <div>Income Statement</div>
                </a>
                <a href="#" class="nav-item nav-link tabPadding" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/balence-sheet-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Balance Sheet</div>
                </a>
                <a href="#" class="nav-item nav-link tabPadding" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/cash-flow-statment-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Cash Statement</div>
                </a>
                <a href="{{route("new-accounts-payable-ledger")}}" class="nav-item nav-link tabPadding" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/account-payable-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Payable Ledger</div>
                </a>
                <a href="{{route("new-accounts-receivable-ledger")}}" class="nav-item nav-link tabPadding" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/account-recieved-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Receivable Ledger</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="content-body">
                        <section id="widgets-Statistics">
                            <div class="cardStyleChange">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h4 class="card-title flex-grow-1">Trial Balance</h4>
                                        <div>
                                            <button type="button" class="btn mExcelButton formButton mr-1" title="Export" onclick="exportTableToCSV('trial-balance-{{ date('d M Y') }}.csv')">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" width="25">
                                                    </div>
                                                    <div><span>Export To CSV</span></div>
                                                </div>
                                            </button>
                                            <a href="{{ route('trial-balance-print') }}" class="btn btn_create mPrint formButton" title="Print" target="blank">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                    </div>
                                                    <div><span>Print</span></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="col-md-5 text-right">
                                            <form action="{{ route('new-trial-balance-date') }}" method="GET" class="d-flex row">
                                                <div class="row form-group col-md-8">
                                                    <input type="text" class="inputFieldHeight form-control" name="date"  placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn mSearchingBotton mb-2 formButton" title="Search" >
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" width="25">
                                                            </div>
                                                            <div><span>Search</span></div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-7 padding-right">
                                            <form action="{{ route('new-trial-balance-date-range') }}" method="GET">
                                                <div class="d-flex">
                                                    <div class="col-5 ">
                                                        <input type="text" class="inputFieldHeight form-control" name="from" placeholder="From"  value="{{ isset($searchDatefrom)? $searchDatefrom:"" }}"  onfocus="(this.type='date')"  id="from" required>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" class="inputFieldHeight form-control" name="to"
                                                        placeholder="To" value="{{ isset($searchDateto)? $searchDateto:"" }}" onfocus="(this.type='date')" id="to" required>
                                                    </div>
                                                    <div class="col-md-2 text-right" style="padding-right: 0;">
                                                        <button type="submit" class="btn mSearchingBotton mb-2 formButton" title="Search" >
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" width="25">
                                                                </div>
                                                                <div><span>Search</span></div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <input type="hidden" name="hidden_date_from" value="{{ isset($from)? $from:"" }}" id="hidden_date_from">
                                        <input type="hidden" name="hidden_date_to" value="{{ isset($to)? $to:"" }}" id="hidden_date_to">
                                    </div>
                                </div>
                            </div>
        
                            <div class="card-body pt-0 pb-0">
                                <table class="table table-sm">
                                    <tr>
                                        <th colspan="4" class="text-center">
                                            <h5>Trial Balance</h5>
                                            <h6>From {{$from}} to {{$to}}</h6>
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
                                    @foreach (App\JournalRecord::whereBetween('journal_date', [$from,$to])->distinct()->get('master_account_id') as $unique_master_ac)
        
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
                                        @foreach (App\JournalRecord::where('master_account_id', $unique_master_ac->master_account_id )->distinct()->whereBetween('journal_date', [$from,$to])->get('account_head_id') as $account_head_id)
                                            
                                            @php
                                                $single_dr=0;
                                                $single_cr=0;
                                            @endphp
                                            @foreach (App\JournalRecord::where('account_head_id', $account_head_id->account_head_id)->whereBetween('journal_date', [$from,$to])->get() as $single_jl_entry)
        
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
                                                <td class="text-right">{{$debit_balance}}</td>
                                                <td class="text-right">{{$credit_balance}}</td>
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
                                        <th class="text-right">{{ number_format($total_debit,2)}} </th>
                                        <th class="text-right">{{ number_format($total_credit,2)}}</th>
                                    </tr>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush