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
                                <h4>Sale Return</h4>
                                <hr>
                            </div>
                            <form action="{{ route('finalSaveSaleReturn') }}" method="POST" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card " style="min-height: 180px">
                                            <div class="card-body">
                                                <div class="row">


                                                    <div class="col-md-3 form-group">
                                                        <label for="">Invoice No of Return Sales </label>
                                                        <input type="text" class="form-control" name="invoice_no" id="invoice_no" required>
                                                    </div>

                                                    <div class="col-md-3 form-group">
                                                        <label for=""></label>
                                                        <input type="text" class="form-control" placeholder="Project" name="branch" id="branch" required readonly>
                                                    </div>

                                                    <div class="col-md-3 form-group">
                                                        <label for=""></label>
                                                        <input type="text" class="form-control" placeholder="Date" name="date" id="date" required readonly>
                                                    </div>

                                                    <div class="col-md-3 form-group">
                                                        <label for=""></label>
                                                        <input type="text" class="form-control" placeholder="Due Date" name="date2" id="date2" required readonly>
                                                    </div>

                                                    <div class="col-md-3 form-group">
                                                        <label for=""></label>
                                                        <input type="text" class="form-control" placeholder="TRN No" name="trn_no" id="trn_no" required readonly>
                                                    </div>

                                                    <div class="col-md-3 form-group">
                                                        <label for=""></label>
                                                        <input type="text" class="form-control" value="Customer Name" placeholder="Cash Customer" name="cash_customer" id="cash_customer" required readonly>
                                                    </div>

                                                    <div class="col-md-3 form-group">
                                                        <label for=""></label>
                                                        <input type="text" class="form-control" placeholder="Paymode" name="pay_mode" id="pay_mode" required readonly>
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


                                                    <div class="col-sm-7 search-item">
                                                        <label class="invoice-label" for="">Item Name</label>
                                                        <select name="item_name" id="item_name" class="form-control return-item">
                                                            <option value="">Select</option>

                                                        </select>
                                                    </div>

                                                    <div class="col-sm-5">
                                                        <label class="invoice-label" for="">Barcode</label>
                                                        <input type="text" class="form-control item-select-by-term"
                                                            placeholder="Barcode"  name="barcode" id="barcode" readonly>
                                                        <span class="stock-out" style="display: none; color:red">Not in stock*</span>
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
                                                            <input type="button" name="temp_sale_return" class="btn btn-warning" value="Add" id="temp_sale_return">
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
                                                <th>unit</th>
                                                <th>Unit Price</th>
                                                <th>QTY</th>
                                                {{-- <th>Vat</th> --}}
                                                {{-- <th>Discount</th> --}}
                                                <th>Net Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="all-data-area">


                                        </tbody>



                                    </table>
                                </div>

                            <div class="row d-flex justify-content-end pt-1">


                                {{-- <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="" class="col-5 d-flex align-items-center">Total Gross:</label>
                                        <input type="number" name="total_gross" placeholder="Final Discount"
                                        min="0" step="any" class="form-control col-7" value="0.00"
                                        id="total_gross" readonly>
                                    </div>

                                </div> --}}
                            </div>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit"
                                                        class="btn btn-sm final-save-btn only-save-btn  btn-primary">
                                                        Save</button>
                                                        <a  class="btn btn-sm btn-warning" onClick="refreshPage()">Refresh</a>
                                </div>
                            </div>
                        </form>
                        </div>
                        <div class="col-md-1">
                            <div class="row">
                                <h4>Return Invoices <span ></span></h4>
                                <i class="bx bx-refresh btn btn-sm" id="refresh_invoice">Refresh</i>
                                <div class="invoice-items">
                                    <ul>
                                        @foreach ($saleReturns as $invoice)
                                        <li><a href="{{ route('saleReturnPrint', $invoice->invoice_no) }}" target="_blank">{{ $invoice->invoice_no }}</a></li>

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


            $(document).on("keyup", "#invoice_no", function(e) {
                // alert($(this).val().length);
                if ($(this).val().length == 11) {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('findInvoice') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            var qty = 1;
                            // $("div.search-item select").val(response.item.id);
                            $("#branch").val(response.project.proj_name);
                            $("#date").val(response.item.date);
                            $("#date2").val(response.item.due_date);
                            $("#cash_customer").val(response.customer.pi_name);

                            $("#trn_no").val(response.item.trn_no);
                            $("#pay_mode").val(response.item.pay_mode);
                            $(".return-item").empty().append(response.page);
                            // $(".all-data-area").empty().append(response.page2);
                        }
                    })
                }
            });
            $(document).on("keyup", "#quantity", function(e) {
                // alert(1);
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    var c = $('#unit_price').val();
                    var cost = c * value;
                    var cost = c * value;
                    var fCost=parseFloat(cost).toFixed(2);
                    $("#cost_price").val(fCost);
                    $("#temp_sale").focus();
                }
            });


            $('#item_name').change(function() {
                // alert(1);
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('findItemIdSaleReturn') }}",
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
                            $("#cost_price").val(response.cost_price);
                            // $("#net_amount").val(response.net_amount);
                            $("#quantity").focus().val(qty);

                        }

                    })
                }
            });
            $('#refresh_invoice').click(function() {
                // alert(1);

                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('refresh_saleReturn') }}",
                    method: "GET",
                    data: {
                        _token: _token,
                    },
                    success: function(response) {
                        $(".invoice-items").empty().append(response.page);
                    }
                })
            });


            $('#temp_sale_return').click(function() {
                // alert(1);
                var invoice_no = $('#invoice_no').val();
                var item_name = $('#item_name').val();
                var net_amount = $('#net_amount').val();
                var quantity = $('#quantity').val();

                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('tempSaleOrderReturn') }}",

                    method: "GET",
                    data: {
                        invoice_no: invoice_no,
                        item_name: item_name,
                        quantity: quantity,
                        _token: _token,
                    },

                    success: function(response) {
                        if(response.error)
                        {
                            toastr.error("{{ Session::get('message') }}",(response.error));
                        }
                        else
                        {
                            $(".all-data-area").empty().append(response.page);

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
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });
        });
    </script>
@endpush




