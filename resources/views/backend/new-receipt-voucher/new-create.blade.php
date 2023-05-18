@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@php

@endphp
@section('content')
@include('layouts.backend.partial.style')
<style>
    .changeColStyle span{
        min-width: 16%;
    }
    .changeColStyle .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
</style>
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                    {{-- @if (Auth::user()->hasPermission('receipt_voucher_view')) --}}
					<a href="{{route("receipt-voucher-list")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
                        </div>
                        <div>Receipt Voucher View</div>
                    </a>
					{{-- @endif
					@if (Auth::user()->hasPermission('receipt_voucher_create')) --}}
                    <a href="{{route("form-receipt-voucher")}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div>Receipt Voucher Entry</div>
                    </a>
					{{-- @endif
					@if (Auth::user()->hasPermission('receipt_voucher_authorize')) --}}
                    <a  href="{{route("receipt-voucher-authorize")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/authorization-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div>Authorization</div>
                    </a>
					{{-- @endif
					@if (Auth::user()->hasPermission('receipt_voucher_approval')) --}}
                    <a href="{{route("receipt-voucher-approval")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/approval-icon.png')}}" alt="" srcset="" class="img-fluid" width="60">
                        </div>
                        <div> &nbsp;&nbsp; Approval  &nbsp;&nbsp;</div>
                    </a>
					{{-- @endif --}}
					<a href="{{route("receipt-voucher-reject-list")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/invoice-declined-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div> &nbsp;&nbsp; Rejected  &nbsp;&nbsp;</div>
                    </a>
                </div>
                <div class="tab-content bg-white">
                    <div id="journaCreation" class="tab-pane active">
                            
                        <section id="widgets-Statistics">
                            @isset($journalF)
                            <form action="{{ route('journalEntryEditPost', $journalF) }}" method="POST" enctype="multipart/form-data">
                            @else
                                <form action="{{ route('store-receipt-voucher') }}" method="POST" enctype="multipart/form-data">
                                @endisset
    
                                @csrf
                                <div class="cardStyleChange">
                                    <div class="card-body" style="padding-bottom: 5px;">
                                        <div class="row m-1">
    
                                            <div class="col-sm-3 changeColStyle">
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
                                            <div class="col-sm-2 changeColStyle">
                                                <label for="">Cost Center Code</label>
                                                <input type="text" name="cc_code" id="cc_code"
                                                    value="{{ isset($journalF) ? $journalF->costCenter->cc_code : '' }}"
                                                    class="form-control inputFieldHeight" placeholder="Cost Center Code"
                                                    required>
                                                @error('cc_code')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3 changeColStyle search-item">
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
                                            <div class="col-sm-2 changeColStyle">
                                                <label for="">Party Code</label>
                                                <input type="text" name="pi_code" id="pi_code" class="form-control inputFieldHeight" name="" id="" required>
                                                @error('party_info')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-2" style="padding-right:5px;
                                            padding-left:5px;
                                            padding-bottom:5px;"> 
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
                                            <div class="col-sm-3 changeColStyle search-item-pi">
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
                                            <div class="col-sm-2 changeColStyle">
                                                <label for="">TRN</label>
                                                <input type="text" class="form-control inputFieldHeight"
                                                    value=""
                                                    name="trn_no" id="trn_no" class="form-control" readonly>
                                                @error('trn_no')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3 changeColStyle">
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
                                            <div class="col-sm-2 changeColStyle">
                                                <label for="">Invoice No</label>
                                                <input type="text" class="form-control inputFieldHeight" name="invoice_no"
                                                    value="{{ isset($journalF) ? $journalF->invoice_no : '' }}"
                                                    id="invoice_no" placeholder="Invoice No" required>
                                                @error('invoice_no')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-2 changeColStyle" id="printarea">
                                                <label for="">Journal Date</label>
                                                <input type="date" value="{{ isset($journalF) ? $journalF->date : Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control inputFieldHeight" name="date" id="date" placeholder="dd-mm-yyyy" >
                                                @error('date')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row m-1">
                                        <div class="cardStyleChange border-top" style="width: 100%">
                                            <div class="card-body" style="padding-bottom: 5px;">
                                                <div class="repeater-default" id="form-repeat-container">
                                                    <div data-repeater-list="group-a">
                                                        <div data-repeater-item>
                                                            <div class="row justify-content-between every-form-row">
                                                                <div class="col-md-3 col-sm-12 changeColStyle">
                                                                    <label for="invoice_no">Invoice No</label>
                                                                    <select name="invoice_no" class="form-control common-select2 invoice_no input-due-payment inputFieldHeight">
                                                                        <option value="">Select Invoice</option>
                                                                        @foreach ($invoices as $invoice)
                                                                        <option value="{{$invoice->invoice_no}}">{{$invoice->invoice_no}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2 col-sm-12 changeColStyle">
                                                                    <label for="password">Invoice Amount</label>
                                                                    <input type="number" class="form-control invoice_amount inputFieldHeight" placeholder="Invoice Amount" readonly>
                                                                </div>
                                                                <div class="col-md-2 col-sm-12 changeColStyle">
                                                                    <label for="password">Due Amount</label>
                                                                    <input type="number" class="form-control due_amount inputFieldHeight" placeholder="Due Amount" readonly>
                                                                </div>


                                                                <div class="col-md-2 col-sm-12 changeColStyle">
                                                                    <label for="password">Payment Amount</label>
                                                                    <input type="number" name="payment_amount" class="form-control payment_amount inputFieldHeight"  step="any" placeholder="Payment Amount">
                                                                </div>
                                                                <div class="col-md-2 col-sm-12 d-flex pt-2 changeColStyle justify-content-end">
                                                                    <button type="button" class="btn btn-danger formButton mDeleteIcon" data-repeater-delete title="Delete">
                                                                        <div class="d-flex align-items-right">
                                                                            <div class="formSaveIcon">
                                                                                <img  src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" alt="" srcset=""  width="25">
                                                                            </div>
                                                                            <div><span> Delete</span></div>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <div class="col p-0">
                                                                    <button type="button" class="btn btn-primary btn_create formButton" data-repeater-delete title="Add" data-repeater-create>
                                                                        <div class="d-flex">
                                                                            <div class="formSaveIcon">
                                                                                <img  src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset=""  width="25">
                                                                            </div>
                                                                            <div><span>Add</span></div>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                    </div>
                                </div>
                                <div class="cardStyleChange">
                                    <div class="card-body" style="padding-top: 0; padding-bottom: 0;">
                                        <div class="row m-1">
                                            <div class="col-sm-4 form-group">
                                                <label for="class-name">Total Amount</label>
                                                <input type="text" id="total_amount" class="form-control inputFieldHeight @error('total_amount') error @enderror" name="total_amount" value="{{ isset($fee_collection) && $fee_collection->total_amount ? $fee_collection->total_amount : 0}}" placeholder="Total" required>
                                                @error('total_amount')
                                                <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-sm-6 form-group">
                                                <label for="">Narration</label>
                                                <input type="text" class="form-control inputFieldHeight" name="remark"
                                                    id="remark" placeholder="Narration"
                                                    value="{{ isset($journalF) ? $journalF->remark : '' }}"
                                                    required>
                                            </div>
    
                                            
                                            <div class="col-sm-2 text-right d-flex justify-content-end mt-2 mb-1">
                                                <button type="submit" class="btn btn-primary formButton" data-repeater-delete title="Add" data-repeater-create>
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset=""  width="25">
                                                        </div>
                                                        <div><span>Save</span></div>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    
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
                    var this_amount= Number($(this).val());
                    this_amount = (this_amount === '') ? 0 : this_amount;
                    var total_amount = Number(this_amount);
                    // 
                    sum = sum+this_amount;
                });
                console.log(sum);
                $('#total_amount').val(Number(sum).toFixed(2));
            }


        });
    </script>

@endpush
