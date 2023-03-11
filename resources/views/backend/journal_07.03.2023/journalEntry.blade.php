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
                                <form action="{{ route('journalEntryEditPost', $journalF) }}" method="POST">
                                @else
                                    <form action="{{ route('journalEntryPost') }}" method="POST">
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
                                                            <label for="">Date</label>
                                                            <input type="date"
                                                                value="{{ isset($journalF) ? $journalF->date : Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                class="form-control" name="date" id="date" placeholder="dd-mm-yyyy" >
                                                            @error('date')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-sm-4 form-group">
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
                                                            {{-- <ul class="list-unstyled mb-0">
                                                                @foreach ($txnTypes as $item)
                                                                <li class="d-inline-block mr-2 mb-1">
                                                                    <fieldset>
                                                                        <div class="radio" id="radio_control">
                                                                            <input type="radio" name="txn_type" class="transection-type" id="radio{{$item->id}}" value="{{ $item->title }}" {{ isset($journalF) ? ($journalF->txn_type == $item->title ? 'checked' : '') : '' }}>
                                                                            <label for="radio{{$item->id}}">{{$item->title}}</label>
                                                                        </div>
                                                                    </fieldset>
                                                                </li>
                                                                @endforeach
                                                            </ul> --}}
                                                            @error('txn_type')
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


                                                        <div class="col-sm-12 row">
                                                            <div class="col-sm-6 form-group">
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
                                                                {{-- <ul class="list-unstyled mb-0">
                                                                    @foreach ($modes as $item)
                                                                    <li class="d-inline-block mr-2 mb-1">
                                                                        <fieldset>
                                                                            <div class="radio" >
                                                                                <input type="radio" name="pay_mode" class="pay_mode" id="payment-mode-{{$item->id}}" value="{{ $item->title }}"  {{ isset($journalF) ? ($journalF->txn_mode == $item->title ? 'checked' : '') : '' }}>
                                                                                <label for="payment-mode-{{$item->id}}">{{$item->title}}</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    @endforeach
                                                                </ul> --}}
                                                                @error('pay_mode')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-sm-6 form-group credit-party-info" style="display: {{ isset($journalF) ? ($journalF->txn_mode == "Credit" ? '' : 'none') : 'none' }}">
                                                                <label for="">Credited Party Info</label>
                                                                <select name="credit_party_info" id="credit_party_info"
                                                                class="common-select2 credit_party_info" style="width: 100% !important" data-target="" >
                                                                    <option value="">Select...</option>
                                                                    @foreach ($pInfos as $item)
                                                                        <option value="{{ $item->id }}"
                                                                            {{ isset($journalF) ? ($journalF->credit_party_info == $item->id ? 'selected' : '') : '' }}>
                                                                            {{ $item->pi_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('party_info')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-2 form-group">
                                                            <label for="">A/C Code</label>
                                                            <input type="text" class="form-control" name="ac_code"
                                                                id="ac_code" placeholder="Account Head Code"
                                                                value="{{ isset($journalF) ? $journalF->accHead->fld_ac_code : '' }}"
                                                                required>
                                                        </div>
                                                        <div class="col-sm-2 form-group search-item-head">
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
                                                        </div>
                                                        <div class="col-sm-2 form-group">
                                                            <label for="">Amount</label>
                                                            <input type="text" class="form-control" name="amount"
                                                                id="amount" placeholder="Amount"
                                                                value="{{ isset($journalF) ? $journalF->amount : '' }}"
                                                                required>
                                                        </div>

                                                        <div class="col-sm-2 form-group">
                                                            <label for="">Vat Rate</label>
                                                            <select name="tax_rate" id="tax_rate"   class="common-select2" style="width: 100% !important"
                                                                required>
                                                                <option value="">Select...</option>
                                                                @foreach ($vats as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ isset($journalF) ? ($journalF->tax_rate == $item->id ? 'selected' : '') : '' }}>
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-sm-2 form-group">
                                                            <label for="">Vat Amount</label>
                                                            <input type="text" class="form-control" name="vat_amount"
                                                                id="vat_amount" placeholder="Vat Amount"
                                                                value="{{ isset($journalF) ? $journalF->vat_amount : '' }}"
                                                                readonly>
                                                        </div>

                                                        <div class="col-sm-2 form-group">
                                                            <label for="">Total Amount</label>
                                                            <input type="text" class="form-control" name="total_amount"
                                                                id="total_amount" placeholder="Total Amount"
                                                                value="{{ isset($journalF) ? $journalF->total_amount : '' }}"
                                                                readonly>
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

                                                        {{-- <div class="col-sm-2 form-group">
                                                            <label for="">Owner</label>
                                                            <input type="text" class="form-control" id="owner"
                                                                value="{{ isset($journalF) ? $journalF->project->owner_name : '' }}"
                                                                name="owner" placeholder="Owner Name" readonly>
                                                            @error('owner')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-2 form-group">
                                                            <label for="">Location</label>
                                                            <input type="text" class="form-control" id="location"
                                                                value="{{ isset($journalF) ? $journalF->project->address : '' }}"
                                                                name="location" placeholder="Location" readonly>
                                                            @error('location')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-2 form-group">
                                                            <label for="">Mobile Number</label>
                                                            <input type="text" class="form-control" id="mobile"
                                                                name="mobile"
                                                                value="{{ isset($journalF) ? $journalF->project->cont_no : '' }}"
                                                                placeholder="Mobile Number" readonly>
                                                            @error('mobile')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div> --}}

                                                        <div class="col-sm-12 text-right">
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
                                        <th>Journal No</th>
                                        <th>Date</th>
                                        <th>Invoice No</th>
                                        <th>Party Name</th>
                                        {{-- <th>Account No</th> --}}
                                        <th>Account Head</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody class="user-table-body">
                                    @foreach ($journals as $journal)
                                        <tr>
                                            <td>{{ $journal->journal_no }}</td>
                                            <td>{{ $journal->date }}</td>
                                            <td>{{ $journal->invoice_no }}</td>
                                            <td>{{ $journal->PartyInfo->pi_name }}</td>
                                            {{-- <td>{{ $journal->accHead->fld_ac_code }}</td> --}}
                                            <td>{{ $journal->accHead->fld_ac_head }}</td>
                                            <td>{{ $journal->total_amount }}</td>


                                            <td style="white-space: nowrap">
                                                <a href="{{ route('journalView', $journal) }}"
                                                    class="btn btn-sm btn-warning" target="_blank"><i
                                                        class="bx bx-hide "></i></a>
                                                <a href="{{ route('journalEdit', $journal) }}"
                                                    class="btn btn-sm btn-warning"><i class="bx bx-edit "></i></a>
                                                <a href="{{ route('journalDelete', $journal) }}"
                                                    onclick="return confirm('about to delete journal. Please, Confirm?')"
                                                    class="btn btn-sm btn-danger"><i class="bx bx-trash "
                                                        aria-hidden="true"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>


                            </table>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 text-right">
                            {{ $journals->links() }}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        function refreshPage() {
            window.location.reload();
        }



        $(document).ready(function() {
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
                    if (value=="Credit") {
                        $('.credit-party-info').show();
                        $("#credit_party_info").focus();
                        $('.common-select2').select2();


                    } else {
                        $('.credit-party-info').hide();
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

            $('#tax_rate').change(function() {

                    var value = $(this).val();
                    var amount = $('#amount').val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findTaxRate') }}",
                        method: "POST",
                        data: {
                            value: value,
                            amount: amount,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            $("#vat_amount").val(response.vat_amount);
                            $("#total_amount").val(response.total_amount);
                            $("#narration").focus();
                        }
                    })

            });

            $(document).on("keyup", "#amount", function(e) {
                var amount = $(this).val();
                var tax_rate = $('#tax_rate').val();
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
                            $("#vat_amount").val(response.vat_amount);
                            $("#total_amount").val(response.total_amount);

                    }
                })
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
