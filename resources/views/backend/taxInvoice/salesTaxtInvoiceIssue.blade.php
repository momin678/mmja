@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>

    </style>
@endpush
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4>Tax Invoice</h4>

                                </div>
                                <div class="col-md-5 text-right">
                                    {{-- <a href="{{ route('taxInvoIssue') }}" class="btn btn-primary btn-block  mb-1 text-center">Tax Invoice <small>Without SO</small></a> --}}

                                </div>
                                 <div class="col-md-3 text-right">
                                    <a href="{{ route('taxInvoiceList') }}" class="btn btn-info btn-block mx-1 mb-1 text-center active-sale">
                                        Tax Invoice <small>(List)</small>
                                       </a>
                                </div>
                                <hr>
                            </div>


                          <div class="row details-view">

                            @if (isset($invoice))
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card d-flex align-items-center" style="min-height: 180px">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Project</label>
                                                        <select name="branch" class="form-control" id="" readonly disabled>
                                                            <option value="">Select...</option>
                                                            @foreach ($projects as $item)
                                                                <option value="{{ $item->proj_no }}"
                                                                    {{ $invoice->project_id == $item->id ? 'selected' : '' }}>{{ $item->proj_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-3 form-group d-none">
                                                        <label for="">GL Code</label>
                                                        <input type="text" name="gl_code" id="gl_code" value="{{ $invoice->gl_code }}"
                                                            class="form-control" disabled>

                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Date</label>
                                                        <input type="date" value="{{ $invoice->date }}" class="form-control" name="date"
                                                            id="date" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Sale Order No</label>
                                                        <input type="text" class="form-control" value="{{ $invoice->sale_order_no }}"
                                                            name="invoice_no" id="invoice_no" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Customer Name</label>
                                                        <select name="customer_name" id="customer_name" class="form-control party-info"
                                                            data-target="" readonly disabled>
                                                            <option value="">Select...</option>
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->cc_code }}"
                                                                    {{ $invoice->customer_name == $customer->pi_code ? 'selected' : '' }}>
                                                                    {{ $customer->pi_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">TRN</label>
                                                        <input type="text" class="form-control" value="{{ $invoice->trn_no }}" name="trn_no"
                                                            id="trn_no" class="form-control" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Mode</label>
                                                        <select name="pay_mode" id="" class="form-control" readonly disabled>
                                                            <option value="">Select...</option>
                                                            @foreach ($modes as $item)
                                                                <option value="{{ $item->title }}"
                                                                    {{ $invoice->pay_mode == $item->title ? 'selected' : '' }}>{{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Terms </label>
                                                        <select name="pay_terms" id="pay_terms" class="form-control" readonly disabled>
                                                            <option value="">Select...</option>

                                                            @foreach ($terms as $item)
                                                                <option value="{{ $item->value }}"
                                                                    {{ $invoice->pay_terms == $item->value ? 'selected' : '' }}>{{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2 form-group">
                                                        <label for="">Due Date</label>
                                                        <input type="date" value="{{ $invoice->due_date }}" class="form-control"
                                                            name="due_date" id="due_date" readonly disabled>
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Contact Number</label>
                                                        <input type="text" value="{{ $invoice->contact_no }}" class="form-control"
                                                            name="contact_no" id="contact_no" readonly disabled>
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Shipping Address</label>
                                                        <input type="text" value="{{ $invoice->address }}" class="form-control" name="address"
                                                            id="address" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-4 form-group">
                                                        <form action="{{ route('asignDeliveryNote', $invoice) }}" method="POST">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="">Delivery Note No</label>
                                                                    <input type="number" name="note_no" class="form-control" list="browsers"
                                                                        value="{{ isset($invoice->deliveryNoteSale) ? $invoice->deliveryNoteSale->deliveryNote->delivery_note_no : '' }}"
                                                                        id="" required  readonly disabled>
                                                                    <datalist id="browsers">
                                                                        @foreach ($notes as $item)
                                                                            <option value="{{ $item->delivery_note_no }}">
                                                                                {{ $item->delivery_note_no }}</option>
                                                                        @endforeach
                                                                    </datalist>
                                                                </div>

                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Barcode</th>
                                                <th>Item Name</th>
                                                <th>QTY</th>

                                            </tr>
                                        </thead>
                                        <tbody class="all-data-area">
                                            @foreach (App\SaleOrderItemTemp::where('sale_order_no', $invoice->sale_order_no)->get() as $item)
                                                <tr class="data-row">
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $item->barcode }}</td>
                                                    <td>{{ $item->item->item_name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach

                                        </tbody>



                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-center">
                                        <a href="{{ route('saleOrderPrint', $invoice) }}" class="btn btn-sm btn-secondary"
                                            target="_blank">print</a>

                                    </div>
                                </div>
                                </form>
                            </div>

                            @endif

                          </div>
                        </div>




                        <div class="col-md-2 ">
                            <div class="row">
                                <h4>Delivery Note <span></span></h4>
                                <div class="col-12 pb-1">
                                    <button class="btn btn-warning btn-sm btn-block" value="hide"
                                        id="searchSO">Search</button>
                                </div>
                                <div class="col-md-12">
                                    <div class="row search-class" style="display: none">
                                        <div class="col-md-12 d-flex justify-content-center ">
                                            <input type="text" class="form-control" id="dNo"
                                                placeholder="Delivery Note No">
                                        </div>

                                        <div class="col-md-12 d-flex justify-content-center ">
                                            <input type="text" class="form-control" id="month"
                                            placeholder="Month Wise"  onfocus="(this.type='month')">

                                        </div>
                                        <div class="col-md-12 d-flex justify-content-center pb-1">
                                            <input type="text" class="form-control" id="date"
                                                placeholder="Date Wise"  onfocus="(this.type='date')">

                                        </div>

                                        <div class="col-md-12 d-flex justify-content-center ">
                                            <input type="text" class="form-control" id="from"
                                            placeholder="From"  onfocus="(this.type='date')">

                                        </div>

                                        <div class="col-md-12 d-flex justify-content-center pb-1">
                                            <input type="text" class="form-control" id="to"
                                            placeholder="To"  onfocus="(this.type='date')">

                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-12">





                                    <div class="row delivery-note">

                                        @foreach ($dNotes as $item)
                                            <div class="col-md-12 btn btn-light btn-sm  mx-1 mb-1 text-center"
                                                id="sale-order-details"
                                                data_target="{{ route('deliveryNotInvoice', $item) }}">
                                                {{ $item->delivery_note_no }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                        </div>


                    </div>
                </section>
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

    <script>
        $(document).ready(function() {

            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();
            $(document).on("click", "#sale-order-details", function(e) {
                e.preventDefault();
                $(this).addClass('active-button-sale').siblings('div').removeClass('active-button-sale');
                var that = $(this);
                var urls = that.attr("data_target");
                // alert(urls);
                delay(function() {
                    $.ajax({
                        url: urls,
                        type: 'GET',
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            //   alert('ok');
                            console.log(response);
                            $(".details-view").empty().append(response.page);

                        },
                        error: function() {
                              alert('Problem Found');
                        }
                    });
                }, 999);
            });


            $(document).on("keyup", "#dNo", function(e) {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('searchDNo') }}",
                    method: "GET",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        // console.log(response);
                        $(".delivery-note").empty().append(response.page);
                    }
                })
            });
            $('#month').change(function() {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('searchDNoMonth') }}",
                    method: "GET",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        // console.log(response);
                        $(".delivery-note").empty().append(response.page);
                    }
                })
            });

            $('#date').change(function() {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('searchDNoDate') }}",
                    method: "GET",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        // console.log(response);
                        $(".delivery-note").empty().append(response.page);
                    }
                })
            });

            $('#to').change(function() {
                var to = $(this).val();
                var from = $('#from').val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('searchDNoDateRange') }}",
                    method: "GET",
                    data: {
                        from: from,
                        to:to,
                        _token: _token,
                    },
                    success: function(response) {
                        // console.log(response);
                        $(".delivery-note").empty().append(response.page);
                    }
                })
            });

            $(document).on("click", "#sale-order-details", function(e) {
                e.preventDefault();
                $(this).addClass('active-button-sale').siblings('div').removeClass('active-button-sale');

                var that = $(this);
                var urls = that.attr("data_target");
                // alert(urls);
                delay(function() {
                    $.ajax({
                        url: urls,
                        type: 'GET',
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            //   alert('ok');
                            console.log(response);
                            $(".details-view").empty().append(response.page);
                        },
                        error: function() {
                            alert('Problem Found');
                        }
                    });
                }, 999);
            });

            $(document).on("click", "#searchSO", function(e) {
                var value = $(this).val();
                if (value == 'hide') {
                    $("#searchSO").val('show');
                    $(".search-class").show();

                } else {
                    $("#searchSO").val('hide');
                    $(".search-class").hide();
                }

            });


        });

    </script>
@endpush
