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


        .tarek-container{
    width: 85%;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 88% 12%;
    background-color: #ffff;
}

.invoice-label{
    font-size: 10px !important
}

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
                                <h4>Sales Order</h4>
                                <hr>
                            </div>
                            <form >
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card d-flex align-items-center" style="min-height: 180px">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Branch</label>
                                                        <select name="branch" class="form-control" id="" readonly disabled>
                                                            <option value="">Select...</option>
                                                            @foreach ($projects as $item)
                                                                <option value="{{ $item->proj_no }}" {{ $invoice->project_id==$item->id? "selected":"" }}>{{ $item->proj_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-3 form-group d-none">
                                                        <label for="">GL Code</label>
                                                       <input type="text" name="gl_code" id="gl_code" value="{{ $invoice->gl_code }}" class="form-control" disabled>

                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Date</label>
                                                        <input type="date"
                                                            value="{{ $invoice->date }}"
                                                            class="form-control" name="date" id="date" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Sale Order No</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $invoice->sale_order_no }}" name="invoice_no"
                                                            id="invoice_no" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Customer Name</label>
                                                        <select name="customer_name" id="customer_name"
                                                            class="form-control party-info" data-target="" readonly disabled>
                                                            <option value="">Select...</option>
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->pi_code }}" {{ $invoice->customer_name==$customer->pi_code? "selected":"" }}>
                                                                    {{ $customer->pi_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">TRN No</label>
                                                        <input type="text" class="form-control" value="{{  $invoice->trn_no }}" name="trn_no" id="trn_no"
                                                            class="form-control" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Mode</label>
                                                        <select name="pay_mode" id="" class="form-control" readonly disabled>
                                                            <option value="">Select...</option>
                                                            @foreach ($modes as $item)
                                                                <option value="{{ $item->title }}" {{ $invoice->pay_mode==$item->title? "selected":"" }}>{{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Terms </label>
                                                        <select name="pay_terms" id="pay_terms" class="form-control"
                                                            readonly disabled>
                                                            <option value="">Select...</option>

                                                            @foreach ($terms as $item)
                                                                <option value="{{ $item->value }}" {{ $invoice->pay_terms==$item->value? "selected":"" }}>{{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Due Date</label>
                                                        <input type="date" value="{{ $invoice->due_date }}" class="form-control" name="due_date"
                                                            id="due_date" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Contact Number</label>
                                                        <input type="text" value="{{ $invoice->contact_no }}" class="form-control" name="contact_no"
                                                            id="contact_no" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Shipping Address</label>
                                                        <input type="text" value="{{ $invoice->address }}" class="form-control" name="address"
                                                            id="address" readonly disabled>
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
                                                <th>Unit</th>

                                                <th>Sale Price</th>
                                                <th>QTY</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody class="all-data-area">
                                            @foreach (App\SaleOrderItem::where('sale_order_no',$invoice->sale_order_no)->orderBy('barcode','ASC')->get() as $item)
                                            <tr class="data-row">
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->barcode }}</td>
                                                <td>{{ $item->item->item_name }}</td>
                                                <td>{{ $item->unit }}</td>

                                                <td>{{number_format((float)( $item->cost_price/$item->quantity),'3','.','') }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{number_format((float)($item->cost_price),'2','.','') }}</td>

                                            </tr>
                                            @endforeach

                                        </tbody>



                                    </table>
                                </div>

                                <div class="row d-flex justify-content-end pt-1">
                                    <div class="col-md-5">
                                        <div class="form-group row">
                                            <label for="" class="col-5 d-flex align-items-center">Total Amount (AED):</label>
                                            <input type="number" name="total_gross" placeholder="Final Discount"
                                            min="0" step="any" class="form-control col-7" value="{{number_format((float)( $invoice->grossTotal($invoice->sale_order_no)),'2','.','') }}"
                                            id="total_gross" readonly>
                                        </div>

                                    </div>
                                </div>

                            <div class="row">
                                <div class="col-12 text-center">
                                 <a  class="btn btn-sm btn-warning" href="{{ route('saleOrderReceive') }}">New</a>
                                 @isset($invoice->deliveryNoteSale)
                                 @else
                                   <a href="{{ route('saleOrderEdit',$invoice) }}" class="btn btn-sm btn-primary" >Edit</a>
                                @endisset
                                   <a href="{{ route('saleOrderPrint', $invoice) }}" class="btn btn-sm btn-secondary" target="_blank">print</a>

                                </div>
                            </div>
                        </form>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <h5 style="white-space: nowrap;">Sale Orders </h5>
                                <input type="text" class="form-control w-100" placeholder="Serach SO No" name="invoice_no" id="invoice_no_s">
                                <i class="bx bx-refresh btn btn-sm" id="refresh_invoice">Refresh</i>
                                <div class="invoice-items">
                                    <ul>
                                        @foreach ($invoicess as $invoice)
                                        <li><a href="{{ route('saleOrderView',$invoice) }}" class="btn btn-light {{ $invoice->hasTaxInvoice? 'bx bx-check font-small-2':'' }} btn-sm">{{ $invoice->sale_order_no }}</a></li>

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

function refreshPage(){
    window.location.reload();
}
        $(document).ready(function() {

            $(document).on("keyup", "#invoice_no_s", function(e) {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('searchSO') }}",
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
                // alert(1);
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
                            // alert('ok');



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
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('findDate') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },

                        success: function(response) {
                            // console.log(response.date);
                            // alert(1);
                            $("#due_date").val(response);



                        }

                    })
                }
            });

            $(document).on("keyup", "#barcode", function(e) {
                if ($(this).val().length == 4) {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('findItem') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },

                        success: function(response) {
                            console.log(response);
                            var qty = 0;
                            $("#item_name").val(response.item_name);
                            $("div.search-item select").val(response.barcode);
                            $("#unit_price").val(response.sell_price);
                            $("#cost_price").val(response.sell_price);
                            $("#net_amount").val(response.sell_price);
                            $("#quantity").focus().val(qty);
                        }

                    })
                }
            });
            $(document).on("keyup", "#quantity", function(e) {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    var c = $('#net_amount').val();
                    var cost = c * value;
                    $("#cost_price").val(cost);
                    $("#temp_invoice").focus();
                }
            });
            $('#temp_invoice').click(function() {
                var barcode = $('#barcode').val();
                var quantity = $('#quantity').val();
                var unit_price = $('#unit_price').val();
                var cost_price = $('#cost_price').val();
                var invoice_no = $('#invoice_no').val();
                var item_name = $('#item_name').val();
                var net_amount = $('#net_amount').val();
                var _token = $('input[name="_token"]').val();
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
                        net_amount: net_amount,
                        barcode: barcode,
                        _token: _token,
                    },

                    success: function(response) {
                        // alert(response.total_vat_amount);
                        var vat = response.total_cost_price - response.total_unit_price;
                        $(".all-data-area").empty().append(response.page);
                        $("#total_gross").val(response.total_cost_price);
                        $("#tarek").val(response.total_unit_price);
                        $("#total_vat").val(response.total_vat_amount);
                        $("#item_name").val('');
                            $("div.search-item select").val('');
                            $("#unit_price").val('');
                            $("#cost_price").val('');
                            $("#net_amount").val('');
                            $("#quantity").val('');
                            $("#barcode").focus().val('');
                            // $("#item_name").val(response.item_name);

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
                    url: "{{ route('refresh_sale_order') }}",
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
                // alert(1);
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('findItem') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },

                        success: function(response) {
                            console.log(response);
                            var qty = 1;
                            // alert(response.item_name);
                            $("#barcode").val(response.barcode);
                            $("div.search-item select").val(response.barcode);
                            $("#unit_price").val(response.sell_price);
                            $("#cost_price").val(response.sell_price);
                            $("#net_amount").val(response.sell_price);
                            $("#quantity").focus().val(qty);
                            // $('#qua').focus()

                        }

                    })
                }
            });





            $("#quantity").enterKey(function () {
    alert('Enter!');
})



            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });


        });
    </script>
@endpush
