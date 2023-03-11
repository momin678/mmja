@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'payment voucher edit')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <form action="{{route('payment-voucher.update', $pv_info->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <h5>Payment Voucher Form</h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">                                        
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">PV No</label>
                                            <input type="text" value="{{$pv_info->payment_voucher_no}}" class="form-control" name="payment_voucher_no" readonly>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">IP No</label>
                                            <input type="text" name="ip_no" class="form-control" required value="{{$pv_info->invoice_posting_no}}" readonly>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">Goods Received No</label>
                                            <input type="text" value="{{$pv_info->goods_received_no}}" class="form-control" name="goods_received_no" readonly>
                                            
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">PO No</label>
                                            <input type="text" required value="{{$pv_info->po_no}}" readonly class="form-control" name="po_no" id="po_no">
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">PR No</label>
                                            <input type="text" required value="{{$pv_info->pr_no}}" readonly class="form-control" name="pr_no" id="pr_no">
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">Supplier Name</label>
                                            <input type="text" readonly value="{{$pv_info->partInfo->pi_name}}" class="form-control">
                                            <input type="hidden" name="supplier_id" value="{{$pv_info->partInfo->id}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Barcode</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Size</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">P Rate</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="tempLists"  class="user-table-body">
                                    @foreach ($ip_items as $item)
                                    <tr class="data-row">
                                        <td> {{$item->itemName->barcode}} </td>
                                        <td> {{$item->itemName->item_name}} </td>
                                        <td> {{$item->itemName->brandName->name}} </td>
                                        <td> {{$item->itemName->group_name}} </td>
                                        <td> {{$item->quantity}} </td>
                                        <td>{{ number_format((float)$item->purchase_rate, 3, '.', '')}}</td>
                                        <td>{{ number_format((float)$item->total_amount, 2, '.', '')}}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="border-top">
                                        <td colspan="5" class="text-right">Amount (AED): </td>
                                        <td colspan="2">
                                            @php
                                                $amount = $ip_items->sum('total_amount') - $ip_items->sum('vat_amount');
                                            @endphp
                                                {{ number_format((float)$amount, 2, '.', '')}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">VAT:</td>
                                        <td colspan="2">
                                            {{ number_format((float)$ip_items->sum('vat_amount'), 2, '.', '')}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">Net Amount (AED):</td>
                                        <td colspan="2">
                                            {{ number_format((float)$ip_items->sum('total_amount'), 2, '.', '')}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <h5>Payment</h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3 col-12">
                                            <label for="mode">Date</label>
                                            <input type="date" name="date" class="form-control" required id="date" value="{{$pv_info->date}}">
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="mode">Method</label>
                                            <select name="payment_method" id="payment_method" class="form-control">
                                                <option value="Cash" {{$pv_info->payment_method == "Cash" ? "selected":""}}>Cash</option>
                                                <option value="Check" {{$pv_info->payment_method == "Check" ? "selected":""}}>Check</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="mode">Pay Amount</label>
                                            <input type="text" value="{{$pv_info->paid_amount}}" name="paid_amount" class="form-control" required id="paid_amount" oninput="validate(this)">
                                            <input type="hidden" name="" id="max_paid" value="{{ number_format((float)$ip_items->sum('total_amount'), 2, '.', '')}}">
                                            <span class="text-danger">Max {{ number_format((float)$ip_items->sum('total_amount'), 2, '.', '')}}</span>
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="mode">Due Amount</label>
                                            <input type="number" name="due_amount" readonly class="form-control" required id="due_amount" value="{{$pv_info->due_amount}}" >
                                        </div>
                                        @if ($pv_info->payment_method == "Check")
                                        <div id="banck_information" class="col-12 col-md-12 col-sm-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-6 col-12">
                                                    <label for="mode">Check No</label>
                                                    <input type="text" name="check_no" class="form-control" required id="check_no" value="{{$pv_info->check_no}}">
                                                </div>                                            
                                                <div class="col-sm-6 col-12">
                                                    <label for="mode">Bank Name</label>
                                                    <input type="text" name="bank_name" class="form-control" required id="bank_name" value="{{$pv_info->bank_name}}">
                                                </div>                                            
                                                <div class="col-sm-6 col-12">
                                                    <label for="mode">Branch Name</label>
                                                    <input type="text" name="branch_name" class="form-control" required id="branch_name" value="{{$pv_info->branch_name}}">
                                                </div>
                                                <div class="col-sm-6 col-12">
                                                    <label for="supplier_name">Supplier Name</label>
                                                    <input type="text" name="supplier_name" class="form-control" id="supplier_name" value="{{$pv_info->supplier_name}}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif                                        
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
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
            if (banck_information.style.display === "none") {
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