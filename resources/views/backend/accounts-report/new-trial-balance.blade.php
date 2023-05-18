
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
                <a href="{{route('new-party-ledger')}}" class="nav-item nav-link tabPadding" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/income-statement-icon.png')}}" class="img-fluid" width="50">
                    </div>
                    <div>&nbsp; Party Ledger &nbsp;</div>
                </a>
                <a href="{{route('new-trial-balance')}}" class="nav-item nav-link tabPadding active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/trial-balence-icon.png')}}" class="img-fluid" width="50">
                    </div>
                    <div>&nbsp;Trial Balance &nbsp;</div>
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
                                            <a href="#" class="btn btn_create mPrint formButton" title="Print" onclick="window.print()">
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
                                        <div class="col-md-4">
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
                                        <div class="col-md-6 padding-right">
                                            <form action="{{ route('new-trial-balance-date-range') }}" method="GET" >
                                                <div class="d-flex">
                                                    <div class="col-md-5 ">
                                                        <input type="text" class="inputFieldHeight form-control" name="from" placeholder="From"  value="{{ isset($searchDatefrom)? $searchDatefrom:"" }}"  onfocus="(this.type='date')"  id="from" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="inputFieldHeight form-control" name="to"
                                                        placeholder="To" value="{{ isset($searchDateto)? $searchDateto:"" }}" onfocus="(this.type='date')" id="to" required>
                                                    </div>
                                                    <div class="col-md-3 text-right" >
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
                                        <div class="col-md-2">
                                            <form action="{{ route('import-trial-balance') }}" method="POST" enctype="multipart/form-data" class="d-flex row">
                                                @csrf
                                                <div class="row form-group col-md-8">
                                                    <input type="file" class="inputFieldHeight form-control" name="xlfile" required>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <button type="submit" class="btn mExcelButton formButton mr-1" title="Import">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" width="25">
                                                            </div>
                                                            <div><span>Import</span></div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <input type="hidden" name="hidden_date_from" value="{{ isset($from)? $from:"" }}" id="hidden_date_from">
                                        <input type="hidden" name="hidden_date_to" value="{{ isset($to)? $to:"" }}" id="hidden_date_to">
                                    </div>
                                </div>
                            </div>
        
                            <div class="card-body pt-0 pb-0">
                                <table  class="table table-sm table-hover">
                                    <tr>
                                        <th colspan="4" class="text-center">
                                            <h2>Trial Balance</h2>
                                            <h4>January {{ date('Y') }} - December {{ date('Y') }}</h4>
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
                                    @foreach (App\JournalRecord::distinct()->get('master_account_id') as $unique_master_ac)
        
                                    <tr>                                
                                        <th>{{$unique_master_ac->master_ac->mst_ac_head}}</th>
                                        <th></th>
                                        <th class="text-right"></th>
                                        <th class="text-right"></th>
                                    </tr>
                                        @php
                                            $each_ledger_dr=0;
                                            $each_ledger_cr=0;
                                        @endphp
                                        @foreach (App\JournalRecord::where('master_account_id', $unique_master_ac->master_account_id )->distinct()->get('account_head_id') as $account_head_id)
                                            
                                            @php
                                                $single_dr=0;
                                                $single_cr=0;
                                            @endphp
                                            @foreach (App\JournalRecord::where('account_head_id', $account_head_id->account_head_id)->get() as $single_jl_entry)
        
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
<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers tr:hover {background-color: #ddd;}
    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
        text-transform: uppercase;

    }
    .graph-7{background: url(../img/graphs/graph-7.jpg) no-repeat;}
    .graph-image img{display: none;}
    @media screen {
    div.divFooter {
        display: none;
    }
    }
    @media print {
        div.divFooter {
            position: fixed;
            bottom: 0;
        }
    }
    th{
        text-transform: uppercase;
    }
</style>
<style>
    .print-layout{
        display: none;
    }
    @media print{
        .print-layout{
            display: block;
            overflow: hidden;
        }
    }
 </style>
<section class="print-layout">
@include('layouts.backend.partial.modal-header-info')

<div class="card-body pt-0 pb-0">
    <table  class="table table-sm table-hover">
        <tr>
            <th colspan="4" class="text-center">
                <h2>Trial Balance</h2>
                <h4>January {{ date('Y') }} - December {{ date('Y') }}</h4>
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
        @foreach (App\JournalRecord::distinct()->get('master_account_id') as $unique_master_ac)

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
            @foreach (App\JournalRecord::where('master_account_id', $unique_master_ac->master_account_id )->distinct()->get('account_head_id') as $account_head_id)
                
                @php
                    $single_dr=0;
                    $single_cr=0;
                @endphp
                @foreach (App\JournalRecord::where('account_head_id', $account_head_id->account_head_id)->get() as $single_jl_entry)

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
            <th class="text-right">{{ number_format($total_debit,2)}} </th>
            <th class="text-right">{{ number_format($total_credit,2)}}</th>
        </tr>
    </table>
</div>
@include('layouts.backend.partial.modal-footer-info')
</section>