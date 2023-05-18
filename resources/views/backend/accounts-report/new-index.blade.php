
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
@php
    $grand_total_value=0;
    $grand_total_pcs=0;
@endphp
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route("new-general-ledger")}}" class="nav-item nav-link tabPadding active" role="tab" aria-controls="nav-contact" aria-selected="false">
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
                <a href="{{route('new-trial-balance')}}" class="nav-item nav-link tabPadding" role="tab" aria-controls="nav-contact" aria-selected="false">
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
                                        <h4 class="card-title flex-grow-1">General Ledger</h4>
                                        <div>
                                            <button type="button" class="btn mExcelButton formButton mr-1" title="Export" onclick="exportTableToCSV('general-ledger-{{ date('d M Y') }}.csv')">
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
                                        <div class="col-md-3">
                                            <form action="{{ route('new-general-ledger-by-date') }}" method="GET" class="d-flex row">
                                                <div class="row form-group col-md-7">
                                                    <input type="text" class="inputFieldHeight form-control" name="date"  placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                                </div>
                                                <div class="col-md-5">
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
                                        <div class="col-md-5">
                                            <form action="{{ route('new-general-ledger-by-date-range') }}" method="GET" class="d-flex">
                                                <div class="row">
                                                    <div class="col-4 ">
                                                        <input type="text" class="inputFieldHeight form-control" name="from" placeholder="From"  value="{{ isset($searchDatefrom)? $searchDatefrom:"" }}"  onfocus="(this.type='date')"  id="from" required>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" class="inputFieldHeight form-control" name="to"
                                                        placeholder="To" value="{{ isset($searchDateto)? $searchDateto:"" }}" onfocus="(this.type='date')" id="to" required>
                                                    </div>
                                                    <div class="col-4">
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
    
                                        <div class="col-md-4 padding-right">
                                            <form action="{{ route('new-general-filter-range-all') }}" method="GET">
                                                <div class="d-flex">
                                                    <div class="col-md-8">
                                                        <select name="head" class="form-control inputFieldHeight" id="head" required>
                                                            <option value="">Select...</option>
                                                            @foreach (App\JournalRecord::distinct()->get('account_head_id') as $unique_acc_head)
                                                            <option value="{{ $unique_acc_head->account_head_id}}">{{ $unique_acc_head->ac_head->fld_ac_head}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
    
                                                    <div class="col-md-4 text-right" style="padding-right: 5px;">
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
                                <div class="card-body pt-0 pb-0">
                                    <table class="table table-sm">
                                        @foreach (App\JournalRecord::where('journal_id', '!=',0)->distinct()->get('account_head_id') as $unique_acc_head)
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
                                            @foreach (App\JournalRecord::where('account_head_id', $unique_acc_head->account_head_id )->where('journal_id', '!=',0)->get() as $record)

                                                @php
                                                    $reverse= $record->transaction_type== "DR" ? "CR" : "DR";
                                                @endphp
                                                @foreach (App\JournalRecord::where('journal_id',$record->journal_id)->where('transaction_type', $reverse)->get() as $ledger_record)
                                                <tr class="trFontSize">
                                                    <td>{{ \Carbon\Carbon::parse($ledger_record->journal_date)->format('d.m.Y')}}</td>
                                                    <td>
                                                        {{$ledger_record->account_head}}
                                                    </td>
                                                    <td></td>
                                                    <td class="text-right">{{ $dr_amount= $record->transaction_type=='DR' ? $record->amount : 0 }} </td>
                                                    <td class="text-right">{{ $cr_amount= $record->transaction_type=='CR' ? $record->amount : 0 }}</td>
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
                                                <th colspan="3"></th>
                                                <th>Balance C/D</th>
                                                <th class="text-right">{{ number_format($each_ledger_dr-$each_ledger_cr,2)}}</th>
                                            </tr>
                                            <tr>
                                                <td> <p></p></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
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
        <table class="table table-sm">
            @foreach (App\JournalRecord::distinct()->get('account_head_id') as $unique_acc_head)
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
                @foreach (App\JournalRecord::where('account_head_id', $unique_acc_head->account_head_id )->get() as $record)

                    @php
                        $reverse= $record->transaction_type== "DR" ? "CR" : "DR";
                    @endphp
                    @foreach (App\JournalRecord::where('journal_id',$record->journal_id)->where('transaction_type', $reverse)->get() as $ledger_record)
                    <tr class="trFontSize">
                        <td>{{ \Carbon\Carbon::parse($ledger_record->created_at)->format('d.m.Y')}}</td>
                        <td>
                            {{$ledger_record->account_head}}
                        </td>
                        <td></td>
                        <td class="text-right">{{ $dr_amount= $record->transaction_type=='DR' ? $record->amount : 0 }} </td>
                        <td class="text-right">{{ $cr_amount= $record->transaction_type=='CR' ? $record->amount : 0 }}</td>
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
        </table>
    </div>
    @include('layouts.backend.partial.modal-footer-info')
</section>
