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
                                <h4>Receipt voucher</h4>
                                <hr>
                            </div>
                            @isset($journalF)
                                <form action="{{ route('journalEntryEditPost', $journalF) }}" method="POST" enctype="multipart/form-data">
                                @else
                                    <form action="{{ route('store-receipt-voucher') }}" method="POST" enctype="multipart/form-data">
                                  @endisset

                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">

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
                                                            <label for="">Date</label>
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

                                                        {{-- <div class="col-sm-2 form-group">
                                                            <label for="">A/C Code</label>
                                                            <input type="text" class="form-control" name="ac_code"
                                                                id="ac_code" placeholder="Account Head Code"
                                                                value="{{ isset($journalF) ? $journalF->accHead->fld_ac_code : '' }}"
                                                                required>
                                                        </div>
                                                        <div class="col-sm-4 form-group search-item-head">
                                                            <label for="">Account Head</label>
                                                            <select name="acc_head" id="acc_head"   class="common-select2" style="width: 100% !important"
                                                                required>
                                                                <option value="">Select...</option>
                                                                @foreach ($acHeads as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ isset($journalF) ? ($journalF->ac_head_id == $item->id ? 'selected' : '') : '' }}>
                                                                        {{ $item->fld_ac_head }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> --}}
                                                        <div class="col-sm-4 form-group">
                                                            <label for="">Type</label>
                                                            <select name="voucher_type" id="voucher_type"   class="common-select2 " style="width: 100% !important"
                                                                required>
                                                                <option value="due" selected>Due Payment</option>
                                                                <option value="advance">Advance Payment</option>
                                                            </select>
                                                            @error('voucher_type')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>


                                                        
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
                                                            </select>
                                                            @error('pay_mode')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
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
                                                                        <label for="invoice_no">Invoice No</label>
                                                                        <select name="invoice_no" class="form-control common-select2 invoice_no input-due-payment">
                                                                            <option value="">Select Invoice</option>
                                                                            @foreach ($invoices as $invoice)
                                                                            <option value="{{$invoice->invoice_no}}">{{$invoice->invoice_no}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12 form-group">
                                                                        <label for="password">Invoice Amount</label>
                                                                        <input type="number" class="form-control invoice_amount" placeholder="Invoice Amount" readonly>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12 form-group">
                                                                        <label for="password">Due Amount</label>
                                                                        <input type="number" class="form-control due_amount" placeholder="Due Amount" readonly>
                                                                    </div>

                                                                    <div class="col-md-2 col-sm-12 form-group">
                                                                        <label for="password">Payment Amount</label>
                                                                        <input type="number" name="payment_amount" class="form-control payment_amount input-due-payment"  step="any" placeholder="Payment Amount">
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
                                                                <button class="btn btn-primary" data-repeater-create type="button"><i class="bx bx-plus"></i>
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
                
                                                        <div class="col-md-8 col-12">
                                                            <div class="form-group">
                                                                <label for="class-name">Narration</label>
                                                                <input type="text" name="remark" id="remark" class="form-control" value="{{isset($fee_collection) && $fee_collection->remark ? $fee_collection->remark : ''}}" placeholder="Remark" >
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                
                                                    <div class="row">
                                                        <div class="col-12 d-flex justify-content-end">
                                                            
                                                            <button type="submit" class="btn btn-primary mr-1">
                                                                Submit
                                                                {{-- @isset($account)
                                                                    Update
                                                                @else
                                                                    Save
                                                                @endisset --}}
                                                            </button>
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
                                        <th>Narration</th>
                                        <th>Payment Mode</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody class="user-table-body">
                                    @foreach ($receipt_vouchers as $voucher)
                                        @php
                                            // $rowcount=$journal->records->count(); 
                                        @endphp
                                        <tr>
                                            <td>{{ $voucher->payment_date }}</td>
                                            <td>{{ $voucher->narration }}</td>
                                            <td>{{ $voucher->pay_mode }}</td>
                                            <td>{{ $voucher->amount }}</td>
                                            <td>
                                                <a href="{{ route('store-receipt-print', $voucher->id)}}" target="_blank" rel="noopener noreferrer">Print</a>
                                            </td>
                                        </tr>
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
        function refreshPage() {
            window.location.reload();
        }



        $(document).ready(function() {
            









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


            // on change invoice no
            $('.repeater-default').on('change', '.invoice_no', function(){              
                // alert('Alhamdulillah');
                if ($(this).val() != '') {
                    var invoice_amount_obj= $(this).closest('.every-form-row').find('.invoice_amount');
                    var due_amount_obj= $(this).closest('.every-form-row').find('.due_amount');
                    var payment_amount_obj= $(this).closest('.every-form-row').find('.payment_amount');
                    var invoice_no = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    // alert(value);
                    $.ajax({
                        url: "{{ route('get-invoice-details') }}",
                        method: "POST",
                        data: {
                            invoice_no: invoice_no,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            invoice_amount_obj.val(response.invoice_amount);
                            due_amount_obj.val(response.due_amount);
                            payment_amount_obj.attr('max',response.due_amount);

                        }
                    })
                }
            });


            $('#voucher_type').change(function(){
                var type= $(this).val();
                if(type=='due'){
                    $('#form-repeat-container').show();
                    $('.input-due-payment').attr('required', true);
                    // $('#total_amount').attr('readonly',true);
                }else{
                    $('#form-repeat-container').hide();
                    $('.input-due-payment').attr('required',false);
                    // $('#total_amount').attr('readonly', false);
                }
            });

            $('.repeater-default').on('keyup', '.payment_amount', function(){
                console.log('sum done');
                sum_all_amount();
            });



            function sum_all_amount(){
                var sum=0;
                $('.payment_amount').each(function() {                    
                    var this_amount= $(this).val();
                    this_amount = (this_amount === '') ? 0 : this_amount;
                    this_amount= parseInt(this_amount);
                    // 
                    sum = sum+this_amount;
                });
                console.log(sum);
                $('#total_amount').val(sum);
            }


        });
    </script>

@endpush
