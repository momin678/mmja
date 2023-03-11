@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        .table-bordered {
            border: 1px solid #f4f4f4;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        table {
            background-color: transparent;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        .tarek-container {
            width: 85%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 88% 12%;
            background-color: #ffff;
        }

        .invoice-label {
            font-size: 10px !important
        }

        .card {
    margin-bottom: 0.2rem;
    box-shadow: -8px 12px 18px 0 rgb(25 42 70 / 13%);
    transition: all .3s ease-in-out, background 0s, color 0s, border-color 0s;
}

.form-group {
    margin-bottom: 0px !important;
}
    </style>
@endpush
@php

@endphp
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <h4>Journal Entry</h4>
                                <hr>
                            </div>
                            @isset($journalF)
                                <form action="{{ route('journalEntryEditPost', $journalF) }}" method="POST" enctype="multipart/form-data">
                                @else
                                    <form action="{{ route('journalEntryPost') }}" method="POST" enctype="multipart/form-data">
                                  @endisset

                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">

                                                        <div class="col-sm-2 form-group">
                                                            <label for="">Journal Entry No</label>
                                                            <input type="text" class="form-control" id="journal_no"
                                                                value="{{ isset($journalF) ? $journalF->journal_no : "$journal_no" }}"
                                                                name="journal_no" placeholder="Journal Entry No" readonly>
                                                            @error('journal_no')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-4 form-group">
                                                            <label for="">Project</label>
                                                            <select name="project" class="common-select2" style="width: 100% !important" id="project"
                                                                required>
                                                                @foreach ($projects as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ isset($journalF) ? ($journalF->project_id == $item->id ? 'selected' : '') : '' }}>
                                                                        {{ $item->proj_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('project')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-2 form-group" id="printarea">
                                                            <label for="">Journal Date</label>
                                                            <input type="date"
                                                                value="{{ isset($journalF) ? $journalF->date : Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                class="form-control" name="date" id="date" placeholder="dd-mm-yyyy" >
                                                            @error('date')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>

                                                        {{-- <div class="col-sm-4 form-group">
                                                            <label for="">TRANSACTION Type</label>
                                                            <select name="txn_type" id="txn_type"   class="common-select2" style="width: 100% !important"
                                                                required>
                                                                <option value="">Select...</option>
                                                                @foreach ($txnTypes as $item)
                                                                    <option value="{{ $item->title }}"
                                                                        {{ isset($journalF) ? ($journalF->txn_type == $item->title ? 'selected' : '') : '' }}>
                                                                        {{ $item->title }}</option>
                                                                @endforeach
                                                            </select>                                                            
                                                            @error('txn_type')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">


                                                        <div class="col-sm-2 form-group">
                                                            <label for="">Cost Center Code</label>
                                                            <input type="text" name="cc_code" id="cc_code"
                                                                value="{{ isset($journalF) ? $journalF->costCenter->cc_code : '' }}"
                                                                class="form-control" placeholder="Cost Center Code"
                                                                required>
                                                            @error('cc_code')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-2 form-group search-item">
                                                            <label for="">Cost Center Name</label>
                                                            <select name="cost_center_name" id="cost_center_name"
                                                            class="common-select2 party-info " style="width: 100% !important" data-target="" required>
                                                                <option value="">Select...</option>
                                                                @foreach ($cCenters as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ isset($journalF) ? ($journalF->cost_center_id == $item->id ? 'selected' : '') : '' }}>
                                                                        {{ $item->cc_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('cost_center_name')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="row">
                                                                <div class="col-sm-2 form-group">
                                                                    <label for="">Party Code</label>
                                                                    <input type="text" name="pi_code" id="pi_code" class="form-control " name="" id="" required>
                                                                    @error('party_info')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                        <div class="col-sm-5 form-group search-item-pi">
                                                            <label for="">Party Name</label>
                                                            <select name="party_info" id="party_info"
                                                            class="common-select2 party-info" style="width: 100% !important" data-target="" required>
                                                                <option value="">Select...</option>
                                                                @foreach ($pInfos as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ isset($journalF) ? ($journalF->party_info_id == $item->id ? 'selected' : '') : '' }}>
                                                                        {{ $item->pi_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('party_info')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>


                                                            <div class="col-sm-2 form-group">
                                                                <label for="">TRN</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ isset($journalF) ? $journalF->partyInfo->trn_no : '' }}"
                                                                    name="trn_no" id="trn_no" class="form-control" readonly>
                                                                @error('trn_no')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>

                                                            <div class="col-sm-3 form-group">
                                                                <label for="">Invoice No</label>
                                                                <input type="text" class="form-control" name="invoice_no"
                                                                    value="{{ isset($journalF) ? $journalF->invoice_no : '' }}"
                                                                    id="invoice_no" placeholder="Invoice No" required>
                                                                @error('invoice_no')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                       </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-4 form-group">
                                                            <label for="">Transaction Type</label>
                                                            <select name="transaction_type" id="transaction_type"   class="common-select2 " style="width: 100% !important"
                                                                required>
                                                                <option value="Increase" selected>General</option>
                                                                <option value="Decrease">Adjustment</option>
                                                            </select>
                                                            @error('transaction_type')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>


                                                        <div class="col-sm-12 row">
                                                            <div class="col-sm-4 form-group">
                                                                <label for="">Payment Mode</label>
                                                                <select name="pay_mode" id="pay_mode"   class="common-select2 " style="width: 100% !important"
                                                                    required>
                                                                    <option value="">Select...</option>
                                                                    
                                                                    @foreach ($modes as $item)
                                                                        <option value="{{ $item->title }}"
                                                                            {{ isset($journalF) ? ($journalF->txn_mode == $item->title ? 'selected' : '') : '' }}>
                                                                            {{ $item->title }}</option>
                                                                    @endforeach
                                                                    <option value="NonCash">Special Transaction</option>
                                                                    
                                                                </select>
                                                                @error('pay_mode')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-sm-4 form-group non-cash-account-head" style="display: {{ isset($journalF) ? ($journalF->txn_mode == "Credit" ? '' : 'none') : 'none' }}">
                                                                <label for="">Account Head</label>
                                                                <select name="acc_head_2" id="acc_head_2" class="common-select2" style="width: 100% !important"
                                                                    >
                                                                    <option value="">Select...</option>
                                                                    @foreach ($acHeads as $item)
                                                                        <option value="{{ $item->id }}"
                                                                            {{ isset($journalF) ? ($journalF->ac_head_id == $item->id ? 'selected' : '') : '' }}>
                                                                            {{ $item->fld_ac_code }} - {{ $item->fld_ac_head }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>                                                            
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="repeater-default" id="form-repeat-container">
                                                        <div data-repeater-list="group-a">
                                                            <div data-repeater-item>
                                                                <div class="row justify-content-between every-form-row">
                                                                    <div class="col-md-2 col-sm-12 form-group">
                                                                        <label for="invoice_no">A/C Head</label>
                                                                        <select name="multi_acc_head" class="form-control common-select2 multi-acc-head input-due-payment">
                                                                            <option value="">Select A/C Head</option>
                                                                            @foreach ($acHeads as $item)
                                                                                <option value="{{ $item->id }}"
                                                                                    {{ isset($journalF) ? ($journalF->ac_head_id == $item->id ? 'selected' : '') : '' }}>
                                                                                    {{ $item->fld_ac_head }}</option>
                                                                            @endforeach
                                                                            
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12 form-group">
                                                                        <label for="password">Total Amount</label>
                                                                        <input type="number" name="multi_total_amount" class="form-control amount_withvat" placeholder="Total Amount">
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12 form-group">
                                                                        <label for="password">Vat Rate</label>
                                                                        <select name="multi_tax_rate"  class="common-select2 form-control multi-tax-rate" style="width: 100% !important"
                                                                        required>
                                                                        @foreach ($vats as $item)
                                                                            <option value="{{ $item->id }}" >
                                                                                {{ $item->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    </div>

                                                                    <div class="col-md-2 col-sm-12 form-group">
                                                                        <label for="password">Amount</label>
                                                                        <input type="number" name="multi_amount" class="form-control amount_without_vat"  step="any" placeholder="Amount">
                                                                    </div>
                                                                    
                                                                    <div class="col-md-2 col-sm-12 form-group d-flex align-items-center pt-2">
                                                                        <button class="btn btn-danger text-nowrap px-1" data-repeater-delete type="button"> <i class="bx bx-x"></i>
                                                                            Delete
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col p-0">
                                                                <button class="btn btn-primary btn_create" data-repeater-create type="button"><i class="bx bx-plus"></i>
                                                                    Add
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group">
                                                                <label for="class-name">Total Amount</label>
                                                                <input type="text" id="total_amount" class="form-control @error('total_amount') error @enderror" name="total_amount" value="{{ isset($fee_collection) && $fee_collection->total_amount ? $fee_collection->total_amount : 0}}" placeholder="Total" required>
                                                                @error('total_amount')
                                                                <span class="error">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                
                                                        
                                                    </div>
                
                                                   
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-8 form-group">
                                                            <label for="">Narration</label>
                                                            <input type="text" class="form-control" name="narration"
                                                                id="narration" placeholder="Narration"
                                                                value="{{ isset($journalF) ? $journalF->narration : '' }}"
                                                                required>
                                                        </div>

                                                        <div class="col-sm-3 form-group">
                                                            <label for="">Voucher Scan/File</label>
                                                            <input type="file" class="form-control" name="voucher_scan" >
                                                        </div>

                                                        

                                                        <div class="col-sm-12 text-right">
                                                            <br>
                                                            <a href="{{ route('journalEntry') }}"
                                                                class="btn btn-primary {{ isset($journalF) ? '' : 'disabled' }}">New</a>
                                                            <button class="btn btn-info" type="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            {{-- <form>
                                <input type="text" name="q" class="form-control input-xs pull-right ajax-search"
                                    placeholder="Search By Project No, Project Name, Mobile Number"
                                    data-url="{{ route('admin.masterAccSearchAjax', $id = 'projectDetails') }}">

                            </form> --}}
                        </div>
                        <div class="col-md-6 text-right">
                            {{-- <a href="{{ route('pdf', $id = 'projDetails') }}" class="btn btn-xs btn-info float-right"
                                target="_blank">Print</a> --}}
                            <button class="btn btn-xs btn-info float-right" onclick="exportTableToCSV('journal.csv')">Export
                                To CSV</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>

                                <tbody class="user-table-body">
                                    @foreach ($journals as $journal)
                                        @php
                                            $rowcount=$journal->records->count(); 
                                        @endphp
                                        @foreach ($journal->records as $record)
                                        <tr>
                                            @if ($loop->index==0)
                                                <td rowspan="{{$rowcount}}">{{ \Carbon\Carbon::parse($record->created_at)->format('d.m.Y')}}</td>
                                            @endif
                                            
                                            <td>{{ $record->account_head }}</td>
                                            <td>{{ $retVal = ($record->transaction_type=='DR') ? $record->amount : ''  }}</td>
                                            <td>{{ $retVal = ($record->transaction_type=='CR') ? $record->amount : ''  }}</td>
                                            {{-- <td style="white-space: nowrap">
                                                <a href="{{ route('journalView', $journal) }}"
                                                    class="btn btn-sm btn-warning" target="_blank"><i
                                                        class="bx bx-hide "></i></a>
                                                <a href="{{ route('journalEdit', $journal) }}"
                                                    class="btn btn-sm btn-warning"><i class="bx bx-edit "></i></a>
                                                <a href="{{ route('journalDelete', $journal) }}"
                                                    onclick="return confirm('about to delete journal. Please, Confirm?')"
                                                    class="btn btn-sm btn-danger"><i class="bx bx-trash "
                                                        aria-hidden="true"></i></a>

                                            </td> --}}
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>


                            </table>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 text-right">
                            {{-- {{ $journals->links() }} --}}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>

    <script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/select/form-select2.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/form-repeater.js"></script>
    
    <script>

        $(document).ready(function() {

            $('.btn_create').click(function(){
                // alert('Alhamdulillah');
                setTimeout(function() {
                    $('.multi-acc-head').select2();
                    $('.multi-tax-rate').select2();
                }, 1000);
            });


            // on change amount
            $('.repeater-default').on("keyup", ".amount_withvat", function(e) {
                
                var amount = $(this).val();
                var tax_rate= $(this).closest('.every-form-row').find('.multi-tax-rate').val();
                var amount_obj= $(this).closest('.every-form-row').find('.amount_without_vat');
                
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findamount') }}",
                    method: "POST",
                    data: {
                        amount: amount,
                        tax_rate:tax_rate,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                            $(amount_obj).val(response.total_amount);
                            sum_all_amount();

                    }
                })
            });
            
            // on change tax rate
            $('.repeater-default').on('change', '.multi-tax-rate', function(){ 
                
                    var value = $(this).val();
                    var amount_withvat= $(this).closest('.every-form-row').find('.amount_withvat').val();
                    var amount_obj= $(this).closest('.every-form-row').find('.amount_without_vat');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findTaxRate') }}",
                        method: "POST",
                        data: {
                            value: value,
                            amount: amount_withvat,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            $(amount_obj).val(response.total_amount);
                            
                        }
                    })

            });

            function sum_all_amount(){
                var sum=0;
                $('.amount_withvat').each(function() {                    
                    var this_amount= $(this).val();
                    this_amount = (this_amount === '') ? 0 : this_amount;
                    this_amount= parseInt(this_amount);
                    // 
                    sum = sum+this_amount;
                });
                console.log(sum);
                $('#total_amount').val(sum);
            }
            
            
            $("#date").focus();
            

            $(document).on("change", "#date", function(e) {
                $("#txn_type").focus();

            })

            $(document).on("keypress", "#date", function(e) {
                var key = e.which;
                var value = $(this).val();
                if (e.which == 13) {
                    $("#txn_type").focus();
                    e.preventDefault();
                    return false;
                }

            });

            $('#txn_type').change(function() {
                $("#cc_code").focus();

            })





            var value = $('#project').val();
            var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findProject') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            $("#owner").val(response.owner_name);
                            $("#location").val(response.address);
                            $("#address").val(response.address);
                            $("#mobile").val(response.cont_no);

                        }
                    })

            $('#project').change(function() {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findProject') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            $("#owner").val(response.owner_name);
                            $("#location").val(response.address);
                            $("#address").val(response.address);
                            $("#mobile").val(response.cont_no);

                        }
                    })
                }
            });

            $('#pay_mode').change(function() {

                    var value = $(this).val();
                    if (value=="NonCash") {
                        $('.non-cash-account-head').show();
                        // $("#acc_head_2").focus();
                        $('.common-select2').select2();

                    } else {
                        $('.non-cash-account-head').hide();
                        $("#ac_code").focus();
                    }


            });


            $(document).on("change", "#credit_party_info", function(e) {

                    $("#ac_code").focus();

            });

            $(document).on("keyup", "#cc_code", function(e) {
                var value = $(this).val();

                var _token = $('input[name="_token"]').val();
                if ($(this).val() != '') {
                $.ajax({
                    url: "{{ route('findCostCenter') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        var qty = 1;
                        if(respons != '')
                        {
                            $("div.search-item select").val(response.id);
                        $('.common-select2').select2();
                        $("#pi_code").focus();
                        }
                    }
                })
            }
            });


            $(document).on("keypress", "#cc_code", function(e) {
                var key = e.which;
                var value = $(this).val();
                if (e.which == 13) {
                    $("#cost_center_name").focus();
                    e.preventDefault();
                    return false;
                }

            });


            $('#cost_center_name').change(function() {

                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findCostCenterId') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            $("#cc_code").val(response.cc_code);
                            $("#pi_code").focus();


                        }
                    })
                }
            });

            $('#party_info').change(function() {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('partyInfoInvoice2') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            $("#trn_no").val(response.trn_no);
                            $("#pi_code").val(response.pi_code);
                            $("#invoice_no").focus();

                        }
                    })
                }
            });



            $(document).on("keyup", "#pi_code", function(e) {
                // alert(1);
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                if ($(this).val() != '') {
                $.ajax({
                    url: "{{ route('partyInfoInvoice3') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        var qty = 1;
                        if (response != '') {

                            $("div.search-item-pi select").val(response.id);
                            $('.common-select2').select2();
                            $("#trn_no").val(response.trn_no);

                            $("#invoice_no").focus();
                        }


                    }
                })
            }
            });

            $(document).on("keypress", "#pi_code", function(e) {
                var key = e.which;
                var value = $(this).val();
                if (e.which == 13) {


                    $("#party_info").focus();
                    e.preventDefault();
                    return false;
                }

            });


            $(document).on("keypress", "#invoice_no", function(e) {
                var key = e.which;
                var value = $(this).val();
                if (e.which == 13) {


                    $("#pay_mode").focus();
                    e.preventDefault();
                    return false;
                }

            });

            $(document).on("keyup", "#ac_code", function(e) {
                // alert(1);
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                if ($(this).val() != '') {
                $.ajax({
                    url: "{{ route('findAccHead') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        var qty = 1;
                        if (response != '') {

                        $("div.search-item-head select").val(response.id);
                        $("#amount").focus();
                        $('.common-select2').select2();
                        }


                    }
                })
            }
            });

            $(document).on("keypress", "#ac_code", function(e) {
                var key = e.which;
                var value = $(this).val();
                    if (e.which == 13) {
                    $("#acc_head").focus();
                    e.preventDefault();
                    return false;
                }


            });


            $('#acc_head').change(function() {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findAccHeadId') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            $("#ac_code").val(response.fld_ac_code);
                            $("#amount").focus();
                        }
                    })
                }
            });





            $(document).on("keypress", "#amount", function(e) {
                var key = e.which;
                var value = $(this).val();
                    if (e.which == 13) {
                    $("#tax_rate").focus();
                    e.preventDefault();
                    return false;
                }
            });




        });
    </script>

@endpush
