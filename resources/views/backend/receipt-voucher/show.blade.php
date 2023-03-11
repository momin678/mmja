@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
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
                                <h4>Receipt Voucher</h4>
                                <hr>
                            </div>
                            <form action="{{ route('receipt-voucher.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card d-flex align-items-center" style="min-height: 180px">
                                            <div class="card-body">
                                                <div class="row">
                                                    
                                                    <div class="col-sm-3 col-12">
                                                        <label for="mode">RV No</label>
                                                        <input type="text" required value="{{$rv_info->rv_no}}" readonly class="form-control" name="rv_no" id="rv_no">
                                                    </div>
                                                    <div class="col-sm-3 col-12">
                                                        <label for="mode">TI No</label>
                                                        <input type="text" required value="{{$rv_info->tax_invoice->invoice_no}}" readonly class="form-control" name="rv_no" id="rv_no">
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Project Name</label>
                                                        <input type="text" class="form-control" readonly value="{{$rv_info->project->proj_name}}">
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">GL Code</label>
                                                       <input type="text" name="gl_code" id="gl_code" value="{{ $rv_info->tax_invoice->gl_code }}" class="form-control" disabled>

                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">TI Date</label>
                                                        <input type="date"
                                                            value="{{ $rv_info->tax_invoice->date }}"
                                                            class="form-control" name="date" id="date" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Tax Invoice No</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $rv_info->tax_invoice->invoice_no }}" name="invoice_no"
                                                            id="invoice_no" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Customer Name</label>
                                                        <input type="text" readonly class="form-control" value="{{$rv_info->partyInfo->pi_name}}">
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">TRN</label>
                                                        <input type="text" class="form-control" value="{{  $rv_info->tax_invoice->trn_no }}" name="trn_no" id="trn_no"
                                                            class="form-control" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Mode</label>
                                                        <input type="text" class="form-control" value="{{  $rv_info->tax_invoice->paymode }}" name="trn_no" id="trn_no"
                                                            class="form-control" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Terms </label>
                                                        <select name="pay_terms" id="pay_terms" class="form-control"
                                                            readonly disabled>
                                                            <option value="">Select...</option>

                                                            @foreach ($terms as $item)
                                                                <option value="{{ $item->value }}" {{ $rv_info->tax_invoice->pay_terms==$item->value? "selected":"" }}>{{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Due Date</label>
                                                        <input type="date" value="{{ $rv_info->tax_invoice->due_date }}" class="form-control" name="due_date"
                                                            id="due_date" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Contact Number</label>
                                                        <input type="text" value="{{ $rv_info->tax_invoice->contact_no }}" class="form-control" name="contact_no"
                                                            id="contact_no" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Shipping Address</label>
                                                        <input type="text" value="{{ $rv_info->tax_invoice->address }}" class="form-control" name="address"
                                                            id="address" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">RV Issu Date</label>
                                                        <input type="text" value="{{ date("d-m-y"), strtotime($rv_info->date) }}" class="form-control" name="address"
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
                                                <th>QTY</th>
                                                <th>Unit</th>
                                                <th>Unit Price</th>
                                                <th>Vat</th>
                                                <th>Discount</th>
                                                <th>Total Price </th>
                                            </tr>
                                        </thead>
                                        <tbody class="all-data-area">
                                            @foreach ($rv_info->tax_invoice_items($rv_info->tax_invoice_id) as $i => $item)
                                            <tr class="data-row">
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $item->barcode }}</td>
                                                <td>{{ $item->item->item_name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->unit }}</td>
                                                <td>{{ $item->unit_price }}</td>
                                                <td>{{ $item->vat_amount }}</td>
                                                <td></td>
                                                <td>{{number_format((float)( $item->cost_price),'2','.','') }}</td>
                                            </tr>
                                            @endforeach
                                            <tr class="border-top">
                                                <td colspan="7" class="text-right">TAXABLE SUPPLIES (AED): </td>
                                                <td colspan="2">
                                                    {{number_format((float)( $rv_info->tax_invoice_items($rv_info->tax_invoice_id)->sum("total_unit_price")),'2','.','') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="text-right">VAT (AED):</td>
                                                <td colspan="2">
                                                    {{number_format((float)( $rv_info->tax_invoice_items($rv_info->tax_invoice_id)->sum("vat_amount")),'2','.','') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="text-right">Total Gross (AED):</td>
                                                <td colspan="2">
                                                    {{number_format((float)( $rv_info->tax_invoice_items($rv_info->tax_invoice_id)->sum("vat_amount") + $rv_info->tax_invoice_items($rv_info->tax_invoice_id)->sum("total_unit_price")),'2','.','') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            
                                <h5>Payment</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3 col-12">
                                                <label for="mode">Date</label>
                                                <input type="date" name="date" class="form-control" required id="date" value="{{$rv_info->date}}" readonly>
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="mode">Method</label>
                                                <input type="text" name="date" class="form-control" required id="date" value="{{$rv_info->payment_method}}" readonly>                                                
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="mode">Total Amount</label>
                                                <input type="text" value="{{$rv_info->total_amount}}" class="form-control" required readonly>
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="mode">Pay Amount</label>
                                                <input type="text" value="{{$rv_info->paid_amount}}" name="paid_amount" class="form-control" required id="paid_amount" oninput="validate(this)" readonly>
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="mode">Due Amount</label>
                                                <input type="number" value="{{$rv_info->due_amount}}" name="due_amount" readonly class="form-control" required id="due_amount" readonly>
                                            </div>
                                            @if ($rv_info->payment_method == "Check")
                                                <div id="banck_information" class="col-12 col-md-12 col-sm-12 col-lg-12">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-12">
                                                            <label for="mode">Check No</label>
                                                            <input type="text" name="check_no" class="form-control" id="check_no" value="{{$rv_info->check_no}}" readonly>
                                                        </div>                                            
                                                        <div class="col-sm-6 col-12">
                                                            <label for="mode">Bank Name</label>
                                                            <input type="text" name="bank_name" class="form-control" id="bank_name" value="{{$rv_info->bank_name}}" readonly>
                                                        </div>                                            
                                                        <div class="col-sm-6 col-12">
                                                            <label for="mode">Branch Name</label>
                                                            <input type="text" name="branch_name" class="form-control" id="branch_name" value="{{$rv_info->branch_name}}" readonly>
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            <label for="customer_name">Supplier Name</label>
                                                            <input type="text" name="customer_name" class="form-control" id="customer_name" value="{{$rv_info->customer_name}}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    @if ($rv_info->status == 0)
                                        <a  class="btn btn-info" href="{{ route('receipt-voucher-process', $rv_info->id) }}">Process</a>
                                        <a href="{{ route('receipt-voucher.edit', $rv_info->id) }}" class="btn btn-warning">Edit</a>
                                    @else
                                    <a class="btn btn-light" href="{{ route('receipt-voucher-print', $rv_info->id) }}" target="_blank">Print</a>
                                    @endif
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    document.getElementById('date').valueAsDate = new Date();
    let max_paid_amount = document.getElementById('max_paid').value;
    var validate = function(e) {
        var t = e.value;
        e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 4)) : t;
        var max = Number(max_paid_amount);
        var min = Number(t);
        let due_amount = max-min;
        document.getElementById("due_amount").value = due_amount.toFixed(2);
        if (min > max) {
            $('#paid_amount').val(max);
            document.getElementById("due_amount").value = 0.00.toFixed(2);
        }
    }
    let payment_method = document.getElementById("payment_method");
    let banck_information = document.getElementById("banck_information");
    let check_no = document.getElementById("check_no");
    let bank_name = document.getElementById("bank_name");
    let branch_name = document.getElementById("branch_name");
    payment_method.addEventListener("change", function(e){ 
        e.preventDefault();
        if(this.value == "Check"){
            if (banck_information.style.display = "none") {
                banck_information.style.display = "block";
                check_no.setAttribute("required", "");
                bank_name.setAttribute("required", "");
                branch_name.setAttribute("required", "");
                check_no.value = "";
                bank_name.value = "";
                branch_name.value = "";
            } else {
                banck_information.style.display = "none";
                check_no.removeAttribute("required");
                bank_name.removeAttribute("required");
                branch_name.removeAttribute("required");
                check_no.value = "";
                bank_name.value = "";
                branch_name.value = "";
            }
        }else{
            banck_information.style.display = "none";
            check_no.removeAttribute("required");
            bank_name.removeAttribute("required");
            branch_name.removeAttribute("required");
            check_no.value = "";
            bank_name.value = "";
            branch_name.value = "";
        }
    })
</script>
@endpush