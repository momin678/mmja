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
                            <form action="{{ route('finalSaveSaleUpdate',$sale) }}" method="POST" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card d-flex align-items-center" style="min-height: 180px">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Branch</label>
                                                        <select name="branch" class="common-select2" style="width: 100% !important" id="branch" required>
                                                            <option value="">Select...</option>
                                                            @foreach ($projects as $item)
                                                                <option value="{{ $item->id }}" {{ $sale->project_id==$item->id? "selected":"" }}>{{ $item->proj_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="project-error" style="display: none">
                                                            <div class="btn btn-sm btn-danger">Required*
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 form-group d-none">
                                                        <label for="">GL Code</label>
                                                       <input type="text" name="gl_code" id="gl_code" value="{{ $sale->gl_code }}" class="form-control" disabled>

                                                    </div>
                                                    <div class="col-sm-3 form-group" id="printarea">
                                                        <label for="">Date</label>
                                                        <input type="date"
                                                        value="{{ $sale->date }}"
                                                            class="form-control" name="date" id="date" readonly>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Sale Order No</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $sale->sale_order_no }}" name="invoice_no"
                                                            id="invoice_no" readonly>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Customer Name</label>
                                                        <select name="customer_name" id="customer_name"
                                                            class="common-select2" style="width: 100% !important" data-target="" required>
                                                            <option value="">Select...</option>
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->pi_code }}" {{ $sale->customer_name==$customer->pi_code? "selected":"" }}>
                                                                    {{ $customer->pi_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">TRN No</label>
                                                        <input type="text" class="form-control" value="{{  $sale->trn_no }}" name="trn_no" id="trn_no"
                                                            class="form-control" readonly>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Mode</label>
                                                        <select name="pay_mode" id="" class="common-select2" style="width: 100% !important" required>
                                                            <option value="">Select...</option>
                                                            @foreach ($modes as $item)
                                                                <option value="{{ $item->title }}" {{ $sale->pay_mode==$item->title? "selected":"" }}>{{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Terms</label>
                                                        <select name="pay_terms" id="pay_terms" class="common-select2" style="width: 100% !important"
                                                            required>
                                                            <option value="">Select...</option>
                                                            @foreach ($terms as $item)
                                                                <option value="{{ $item->value }}" {{ $sale->pay_terms==$item->value? "selected":"" }}>{{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Due Date</label>
                                                        <input type="date" class="form-control" value="{{ $sale->due_date }}" name="due_date"
                                                            id="due_date" readonly>
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Contact Number</label>
                                                        <input type="text" value="{{ $sale->contact_no }}" class="form-control" name="contact_no"
                                                            id="contact_no" readonly>
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Shipping Address</label>
                                                        <input type="text" value="{{ $sale->address }}" class="form-control" name="address"
                                                            id="address" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pb-1">
                                    <div class="col-12">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <label class="invoice-label" for="">Barcode</label>
                                                        <input type="text" class="form-control item-select-by-term"
                                                            placeholder="Barcode"  name="barcode" id="barcode">
                                                        <span class="stock-out" style="display: none; color:red">Not in stock*</span>
                                                    </div>

                                                    <div class="col-sm-7 search-item">
                                                        <label class="invoice-label" for="">Item Name</label>
                                                        <select name="item_name" id="item_name" class="common-select2" style="width: 100% !important">
                                                            <option value="">Select</option>
                                                            @foreach ($itms as $item)
                                                            <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <label class="invoice-label" for="">QTY</label>
                                                        <input type="number" class="form-control" name="quantity"
                                                            id="quantity" >
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="invoice-label" for="">Unit Price</label>
                                                        <input type="text" class="form-control" name="unit_price"
                                                            id="unit_price" readonly>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <label class="invoice-label" for="">Price</label>
                                                        <input type="text" class="form-control" name="cost_price"
                                                            id="cost_price" readonly>
                                                    </div>
                                                    <div class="col-sm-2 ">
                                                        <label for=""></label>
                                                        <div class="row">
                                                            <input type="button" name="temp_sale" class="btn btn-warning" value="Add" id="temp_sale">
                                                        </div>
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

                                                <th>Unit Price</th>
                                                <th>QTY</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="all-data-area">
                                            @foreach (App\SaleOrderItemTemp::where('sale_order_no',$sale->sale_order_no)->get() as $item)
                                            <tr class="data-row">
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->barcode }}</td>
                                                <td>{{ $item->item->item_name }}</td>
                                                <td>{{ $item->unit }}</td>

                                                <td>{{number_format((float)( $item->cost_price/$item->quantity),'3','.','') }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                {{-- <td>{{ $item->unit_price }}</td> --}}
                                                {{-- <td>{{ $item->vat_rate }}</td> --}}
                                                {{-- <td></td> --}}
                                                {{-- <td>{{ $item->unit_price*$item->quantity }}</td> --}}
                                                <td>{{number_format((float)($item->cost_price),'2','.','') }}</td>

                                                <td class="text-right">

                                                    {{-- <button class="btn btn-danger invoice-item-delete" >Delete</button> --}}
                                                    <span class="btn btn-warning invoice-item-delete" id="" data_target="{{ route('itemDeleteSale',$item) }}"><i class="bx bx-trash"></i></span>


                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                            @endforeach

                                        </tbody>



                                    </table>
                                </div>

                            <div class="row d-flex justify-content-end pt-1">

                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label for="" class="col-5 d-flex align-items-center">Total Amount <small>(AED)</small>:</label>
                                        <input type="number" name="total_gross" placeholder="Final Discount"
                                        min="0" step="any" class="form-control col-7" value="{{number_format((float)( $sale->grossTotal($sale->sale_order_no)),'2','.','') }}"
                                        id="total_gross" readonly>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit"
                                                        class="btn btn-sm final-save-btn only-save-btn  btn-primary">
                                                        Save</button>
                                                        <a  class="btn btn-sm btn-warning" href="{{ route('saleOrderReceive') }}">New</a>
                                                    </div>
                            </div>
                        </form>
                        </div>
                        <div class="col-md-1">
                            <div class="row">
                                <h4>Sale Orders <span ></span></h4>
                                <i class="bx bx-refresh btn btn-sm" id="refresh_invoice">Refresh</i>
                                <div class="invoice-items">
                                    <ul>
                                        @foreach ($sales as $invoice)
                                        <li><a href="{{ route('saleOrderView',$invoice) }}" class="btn {{ $invoice->hasTaxInvoice? 'btn-success':'btn-light' }} btn-sm">{{ $invoice->sale_order_no }}</a></li>

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
            $('#customer_name').change(function() {
                // alert(1);
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('SalePartyInfo') }}",
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
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('findDateSale') }}",
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
                // alert($(this).val().length);
                if ($(this).val().length == 4) {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('findItemSale') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            // console.log(response);
                            var qty = 1;
                            $("div.search-item select").val(response.item.id);
                            $("#unit_price").val(response.total_cost_price);
                            $("#cost_price").val(response.total_cost_price);
                            // $("#net_amount").val(response.net_amount);
                            $("#quantity").focus().val(qty);

                        }

                    })
                }
            });
            // $(document).on("keyup", "#quantity", function(e) {
            //     // alert(1);
            //     if ($(this).val() != '') {
            //         var value = $(this).val();
            //         var _token = $('input[name="_token"]').val();

            //         var c = $('#unit_price').val();
            //         var cost = c * value;
            //         var fCost=parseFloat(cost).toFixed(2);
            //         $("#cost_price").val(fCost);
            //         $("#temp_sale").focus();
            //     }
            // });

            $(document).on("keypress", "#quantity", function(e) {
                var key = e.which;
                if (e.which == 13) {
                    $("#temp_sale").focus();
                    e.preventDefault();
                    return false;
                }

            });
            $(document).on("keyup", "#quantity", function(e) {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    var c = $('#unit_price').val();
                    var cost = c * value;
                    var fCost=parseFloat(cost).toFixed(2);
                    $("#cost_price").val(fCost);
                    // $("#temp_sale").focus();
                }


            });
            $('#temp_sale').click(function() {
                // alert(1);
                var branch = $('#branch').val();
                var barcode = $('#barcode').val();
                var quantity = $('#quantity').val();
                var unit_price = $('#unit_price').val();
                var cost_price = $('#branch').val();
                var branch = $('#branch').val();
                var invoice_no = $('#invoice_no').val();
                var item_name = $('#item_name').val();
                var net_amount = $('#net_amount').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('tempSaleOrder') }}",

                    method: "GET",
                    data: {
                        barcode: barcode,
                        quantity: quantity,
                        unit_price: unit_price,
                        cost_price: cost_price,
                        invoice_no: invoice_no,
                        item_name: item_name,
                        branch : branch,
                        net_amount: net_amount,

                        barcode: barcode,
                        _token: _token,
                    },

                    success: function(response) {
                        if(response.fail)
                        {
                            $('.project-error').show().delay(1200).fadeOut();
                        }
                        else  if(response.stockout)
                        {
                            $('.stock-out').show().delay(1200).fadeOut();
                        }
                        else
                        {

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
                        url: "{{ route('findItemIdSale') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },

                        success: function(response) {
                            // console.log(response);
                            var qty = 1;
                            $("#barcode").val(response.item.barcode);
                            $("#unit_price").val(response.unit_price);
                            $("#cost_price").val(response.price);
                            // $("#net_amount").val(response.net_amount);
                            $("#quantity").focus().val(qty);

                        }

                    })
                }
            });
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });
        });
    </script>
@endpush



