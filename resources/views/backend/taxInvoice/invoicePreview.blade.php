@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        .table-bordered {
            border: 1px solid #f4f4f4;
        }

        element.style {}

        /* .select2-container--default .select2-results>.select2-results__options {
        max-height: 200px !important;
        width: 500px !important;
        overflow-y: auto !important;
        border: none !important;
    } */
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

        option {
            width: 450px !important;
        }

        .invoice-label {
            font-size: 10px !important
        }

        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 740px !important;
                margin: 1.75rem auto;
            }
        }


        /* .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
        position: relative;
        width: 100%;
        padding-right: 15px;
        padding-left: 0px !important;
    } */
    </style>
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-12">
                                    <h4>Tax Invoice</h4>

                                </div>
                            </div>
                            <form action="{{ route('finalSaveInvoice') }}" method="POST" onsubmit="return confirm('Please, confirm the invoice.')">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card d-flex align-items-center">
                                            <div class="card-body">
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Branch</label>
                                                        <select name="branch" class="form-control"
                                                            style="width: 100% !important" id="branch" required readonly>
                                                            @foreach ($projects as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ $invoice->project_id == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->proj_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="project-error" style="display: none">
                                                            <div class="btn btn-sm btn-danger">Required*
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">GL Code</label>
                                                        <input type="text" name="gl_code" id="gl_code"
                                                            value="{{ isset($gl_code) ? $gl_code->fld_ac_code : '' }}"
                                                            class="form-control" readonly>

                                                    </div>
                                                    <div class="col-sm-3 form-group" id="printarea">
                                                        <label for="">Invoice Date</label>
                                                        <input type="date" value="{{ $invoice->date }}"
                                                            class="form-control" name="date" id="date" required readonly>
                                                    </div>
                                                    <div class="col-sm-3 form-group d-none">
                                                        <label for="">Tax Invoice No</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $invoice->invoice_no }}" name="invoice_no"
                                                            id="invoice_no" readonly >
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Mode</label>
                                                        <select name="pay_mode" id="pay_mode" class="form-control"
                                                            style="width: 100% !important" required readonly>
                                                            <option value="">Select...</option>
                                                            @foreach ($modes as $item)
                                                                <option value="{{ $item->title }}"
                                                                    {{ $invoice->pay_mode == $item->title ? 'selected' : '' }}>
                                                                    {{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 form-group pay-term">
                                                        <label for="">Payment Terms</label>
                                                        <select name="pay_terms" id="pay_terms" class="form-control"
                                                            style="width: 100% !important" required readonly>
                                                            <option value="">Select...</option>
                                                            @foreach ($terms as $item)
                                                                <option value="{{ $item->value }}"
                                                                    {{ $invoice->pay_terms == $item->value ? 'selected' : '' }}>
                                                                    {{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Due Date</label>
                                                        <input type="date" class="form-control" name="due_date"
                                                            id="due_date" value="{{ $invoice->due_date }}" readonly readonly>
                                                    </div>
                                                    <div class="col-sm-4 form-group customer-select">
                                                        <label for="">Customer Name</label>
                                                        <select name="customer_name" id="customer_name"
                                                            class="form-control party-info customer"
                                                            style="width: 100% !important" data-target="" required readonly>
                                                            <option value="">Select...</option>
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->pi_code }}"
                                                                    {{ $customer->pi_code == $invoice->customer_name ? 'selected' : '' }}>
                                                                    {{ $customer->pi_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">TRN</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $invoice->trn_no }}" name="trn_no" id="trn_no"
                                                            class="form-control" readonly readonly>
                                                    </div>


                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Contact Number</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $invoice->contact_no }}" name="contact_no"
                                                            id="contact_no" readonly>
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Shipping Address</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $invoice->address }}" name="address" id="address"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered all-data-area">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Barcode</th>
                                                <th>Item Name</th>
                                                <th>Unit Price</th>
                                                <th>QTY</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            @foreach ($items as $item)
                                                <tr class="data-row">
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $item->barcode }}</td>
                                                    <td>{{ $item->item->item_name }}</td>

                                                    <td>{{ number_format((float) ($item->cost_price / $item->quantity), 3, '.', '') }}
                                                    </td>

                                                    <td>{{ $item->quantity }}</td>
                                                    {{-- <td>{{ $item->unit_price }}</td> --}}
                                                    {{-- <td>{{ $item->vat_rate }}</td> --}}
                                                    {{-- <td></td> --}}
                                                    {{-- <td>{{ $item->unit_price*$item->quantity }}</td> --}}
                                                    <td>{{ number_format((float) $item->cost_price, 2, '.', '') }}</td>


                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row d-flex justify-content-end pt-1">
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for=""
                                                class="col-7 d-flex align-items-center col-right-padding col-left-padding">TAXABLE
                                                SUPPLIES (AED):</label>
                                            <input type="text" class="form-control col-5 col-right-padding"
                                                name="tax_sup" id="tarek" min="0" step="any"
                                                class="form-control" value="{{number_format((float)( App\InvoiceItemTemp::where('invoice_no', $invoice->invoice_no)->sum('total_unit_price') ), 2, '.', '') }}"  readonly>
                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for=""
                                                class="col-5 d-flex align-items-center col-right-padding">VAT
                                                (AED):</label>
                                            <input type="number" placeholder="VAT" min="0" step="any"
                                                class="form-control col-7 col-right-padding" value="{{number_format((float)( App\InvoiceItemTemp::where('invoice_no', $invoice->invoice_no)->sum('vat_amount') ), 2, '.', '') }}"
                                                name="total_vat" id="total_vat" readonly>
                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for=""
                                                class="col-6 d-flex align-items-center col-right-padding">Total Gross
                                                (AED):</label>
                                            <input type="number" name="total_gross" placeholder="Final Discount"
                                                min="0" step="any"
                                                class="form-control col-6 col-right-padding" value="{{number_format((float)( App\InvoiceItemTemp::where('invoice_no', $invoice->invoice_no)->sum('cost_price') ), 2, '.', '') }}"
                                                id="total_gross" readonly>
                                        </div>

                                    </div>
                                </div>
                                <div class="row d-flex justify-content-end pt-1">
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="" class="col-6 d-flex align-items-center">Total QTY:</label>
                                            <input type="number" name="t_qty" placeholder="Total QTY"
                                            min="0" step="any" value="{{ $invoice->quantity() }}"  class="form-control col-6"
                                            id="t_qty" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group row">
                                            <label for="" class="col-8 d-flex align-items-center">Amount From
                                                Customer:</label>
                                            <input type="number" name="amount_from" placeholder="Amount" min="0"
                                                step="any" value="{{ $amountFrom }}" class="form-control col-4" id="amount_from">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="" class="col-8 d-flex align-items-center">Amount To
                                                Customer:</label>
                                            <input type="number" name="amount_to" placeholder="Amount" step="any"
                                                class="form-control col-4" value="{{ $amountTo }}" id="amount_to" readonly>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit"
                                            class="btn btn-sm final-save-btn only-save-btn  btn-primary" id="final_save">
                                            Confirm</button>
                                        <a class="btn btn-sm btn-warning" href="{{ route('updatePreviewInv', $invoice) }}" onClick="refreshPage()">Update</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <h5 style="white-space: nowrap;">Invoices </h5>
                                <input type="text" class="form-control w-100" placeholder="Serach Invoice No"
                                    name="invoice_no" id="invoice_no_s">
                                <i class="bx bx-refresh btn btn-sm" id="refresh_invoice">Refresh</i>
                                <div class="invoice-items">
                                    <ul>
                                        @foreach ($invoicess as $invoice)
                                            <li><a
                                                    href="{{ route('invoiceView', $invoice) }}">{{ $invoice->invoice_no }}</a>
                                            </li>
                                        @endforeach
                                    </ul>



                                </div>
                                <hr>
                            </div>

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
            $("#item_name").focus();

            $(document).on("keyup", "#amount_from", function(e) {
                var value = $(this).val();
                var c = $('#total_gross').val();

                var to = value - c;
                $("#amount_to").val(to);

            });

            $(document).on("keypress", "#amount_from", function(e) {
                var key = e.which;
                if (e.which == 13) {
                    $("#final_save").focus();
                    e.preventDefault();
                    return false;
                }

            });
            $(document).on("keypress", "#barcode", function(e) {
                var key = e.which;
                if (e.which == 13) {
                    $("#amount_from").focus();
                    $("#amount_from").val($('#total_gross').val());
                    // e.preventDefault();
                    return false;
                }

            });



            $(document).on("change", "#branch", function(e) {
                $("#customer_name").focus();
            });

            $(document).on("change", "#date", function(e) {
                var value = $('#pay_terms').val();
                // alert(date);

                var date = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findDate') }}",
                    method: "POST",
                    data: {
                        value: value,
                        date: date,
                        _token: _token,
                    },
                    success: function(response) {
                        $("#due_date").val(response);
                    }

                })
            });

            $(document).on("change", "#customer_name", function(e) {
                $("#pay_mode").focus();
            });

            $(document).on("keyup", "#invoice_no_s", function(e) {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('searchInvoice') }}",
                    method: "GET",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        // console.log(response);
                        $(".invoice-items").empty().append(response.page);
                    }
                })
            });
            $('#customer_name').change(function() {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('partyInfoInvoice') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            $("#trn_no").val(response.trn_no);
                            $("#contact_no").val(response.con_no);
                            $("#address").val(response.address);
                        }
                    })
                }
            });
            $('#pay_terms').change(function() {
                if ($(this).val() != '') {
                    var date = $('#date').val();
                    // alert(date);

                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findDate') }}",
                        method: "POST",
                        data: {
                            value: value,
                            date: date,
                            _token: _token,
                        },
                        success: function(response) {
                            $("#due_date").val(response);
                        }

                    })
                }
            });
            $(document).on("keyup", "#barcode", function(e) {
                if ($(this).val().length > 3) {
                    var invoice_no = $('#invoice_no').val();

                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findItem') }}",
                        method: "POST",
                        data: {
                            value: value,
                            invoice_no: invoice_no,
                            _token: _token,
                        },
                        success: function(response) {
                            var qty = 1;
                            $("div.search-item select").val(response.item.id);
                            $("#unit_price").val(response.item.total_amount);
                            $("#quantity").focus().val(qty);
                            $("#net_amount").val(response.net_amount);
                            $("#cost_price").val(response.cost_price);
                            $('.common-select2').select2();
                        }

                    })
                }
            });
            $(document).on("keypress", "#quantity", function(e) {
                var key = e.which;
                if (e.which == 13) {
                    $("#temp_invoice").focus();
                    e.preventDefault();
                    return false;
                } else if ($(this).val() != '') {
                    var value = $(this).val();
                    var c = $('#unit_price').val();

                    var cost = c * value;
                    $("#net_amount").val(cost);
                }
            });
            $(document).on("keyup", "#quantity", function(e) {

                var key = e.which;
                if (e.which == 13) {
                    $("#temp_invoice").focus();
                    e.preventDefault();
                    return false;
                } else if ($(this).val() != '') {
                    var value = $(this).val();
                    var invoice_no = $('#invoice_no').val();

                    var unit_price = $('#unit_price').val();
                    var item_name = $('#item_name').val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('quantityFifo') }}",
                        method: "POST",
                        data: {
                            value: value,
                            invoice_no: invoice_no,
                            unit_price: unit_price,
                            item_name: item_name,
                            _token: _token,
                        },
                        success: function(response) {
                            if (response.fail) {
                                $('.project-error').show().delay(1200).fadeOut();
                            } else if (response.stockout) {
                                $('.stock-out').show().delay(1200).fadeOut();
                            } else {
                                $("#net_amount").val(response.net_amount);
                                $("#cost_price").val(response.cost_price);
                            }
                        }
                    })
                }


            });
            $('#temp_invoice').click(function() {
                // alert(1);
                var branch = $('#branch').val();
                var barcode = $('#barcode').val();
                var quantity = $('#quantity').val();
                var unit_price = $('#unit_price').val();
                var cost_price = $('#cost_price').val();
                var branch = $('#branch').val();
                var invoice_no = $('#invoice_no').val();
                var item_name = $('#item_name').val();
                var net_amount = $('#net_amount').val();
                var _token = $('input[name="_token"]').val();
                // alert(cost_price);
                $.ajax({
                    url: "{{ route('tempInvoice') }}",
                    method: "GET",
                    data: {
                        barcode: barcode,
                        quantity: quantity,
                        unit_price: unit_price,
                        cost_price: cost_price,
                        invoice_no: invoice_no,
                        item_name: item_name,
                        branch: branch,
                        net_amount: net_amount,

                        barcode: barcode,
                        _token: _token,
                    },
                    success: function(response) {
                        if (response.fail) {
                            $('.project-error').show().delay(1200).fadeOut();
                        } else if (response.stockout) {
                            $('.stock-out').show().delay(1200).fadeOut();
                        } else {
                            var vat = response.total_cost_price - response.total_unit_price;
                            $(".all-data-area").empty().append(response.page);
                            $("#total_gross").val(response.total_cost_price);
                            $("#tarek").val(response.total_unit_price);
                            $("#total_vat").val(response.total_vat_amount);
                            // $("#item_name").val('');
                            $("div.search-item select").val('');
                            $("#unit_price").val('');
                            $("#cost_price").val('');
                            $("#net_amount").val('');
                            $("#quantity").val('');
                            $("#barcode").focus().val('');
                        }
                    }
                })


            });
            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();
            $(document).on("click", '.invoice-item-delete', function(event) {
                event.preventDefault();
                var that = $(this);
                var urls = that.attr("data_target");
                var _token = $('input[name="_token"]').val();
                var invoice_no = $('#invoice_no').val();
                // alert(invoice_no);
                $.ajax({
                    url: urls,
                    method: "GET",
                    invoice_no: invoice_no,
                    _token: _token,

                    success: function(response) {
                        // alert("hukka");
                        console.log(response);
                        $(".all-data-area").empty().append(response.page);
                        $("#total_gross").val(response.total_cost_price);
                        $("#tarek").val(response.total_unit_price);
                        $("#total_vat").val(response.total_vat_amount);

                    },
                    error: function() {
                        //   alert('no');
                    }
                });

            });
            $('#refresh_invoice').click(function() {
                // alert(1);

                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('refresh_invoice') }}",
                    method: "GET",
                    data: {
                        _token: _token,
                    },
                    success: function(response) {
                        $(".invoice-items").empty().append(response.page);
                    }
                })
            });
            $('#item_name').change(function() {
                if ($(this).val() != '') {
                    var invoice_no = $('#invoice_no').val();

                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('findItemId') }}",
                        method: "POST",
                        data: {
                            value: value,
                            invoice_no: invoice_no,
                            _token: _token,
                        },
                        success: function(response) {
                            var qty = 1;
                            $("#barcode").val(response.item.barcode);
                            $("#unit_price").val(response.item.total_amount);
                            $("#quantity").focus().val(qty);
                            $("#net_amount").val(response.net_amount);
                            $("#cost_price").val(response.cost_price);
                        }
                    })
                }
            });
            $('#pay_mode').change(function() {

                if ($(this).val() == 'Cash') {
                    $("div.pay-term select").val(0);
                    $('.common-select2').select2();
                    var value = $('#pay_terms').val()
                    // var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('findDate') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            $("#due_date").val(response);
                            $("#item_name").focus();
                        }
                    })
                } else if ($(this).val() != 'Cash') {
                    $("#pay_terms").focus();
                }
            });

            $("#customerAddNew").submit(function(e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                var form = $(this);
                var url = form.attr('action');
                var pi_name = $("#pi_name").val();
                var pi_type = $("#pi_type").val();
                var trn_no = $("#trn_no2").val();
                var address = $("#address2").val();
                var con_person = $("#con_person").val();
                var con_no = $("#con_no").val();
                var phone_no = $("#phone_no").val();
                var email = $("#email").val();
                // alert(mobile);
                $.ajax({
                    url: url,
                    method: "POST",
                    data: {
                        pi_name: pi_name,
                        pi_type: pi_type,
                        trn_no: trn_no,
                        address: address,
                        con_person: con_person,
                        con_no: con_no,
                        phone_no: phone_no,
                        phone_no: phone_no,
                        email: email,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $(".customer").empty().append(response.page);
                        $("div.customer-select select").val(response.newCustomer.pi_code);
                        $("#trn_no").val(response.newCustomer.trn_no);
                        $("#contact_no").val(response.newCustomer.con_no);
                        $("#address").val(response.newCustomer.address);
                        $("#customerModal").modal('hide');
                    }
                })
            });

            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });


        });
    </script>
@endpush
