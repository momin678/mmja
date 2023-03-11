@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'pv authorize view')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">
                        <form action="{{route('payment-voucher.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h5>Payment Voucher Authorize</h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">PV No</label>
                                            <input type="text" value="{{$pv_info->payment_voucher_no}}" class="form-control" name="payment_voucher_no" readonly>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">IP No</label>
                                            <input type="text" name="ip_no" class="form-control" required value="{{$pv_info->ip_no}}" readonly>
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
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">PV Date</label>
                                            <input type="text" readonly value="{{date('d-m-y',strtotime($pv_info->date))}}" class="form-control">
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
                                            <input type="date" name="date" class="form-control" required id="date" value="{{$pv_info->date}}" readonly>
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="mode">Method</label>
                                            <select name="payment_method" id="payment_method" class="form-control" disabled>
                                                <option value="Cash" {{$pv_info->payment_method == "Cash" ? "selected":""}}>Cash</option>
                                                <option value="Check" {{$pv_info->payment_method == "Check" ? "selected":""}}>Check</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="mode">Pay Amount</label>
                                            <input type="text" name="paid_amount" class="form-control" required id="paid_amount" value="{{$pv_info->paid_amount}}" readonly>
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="mode">Due Amount</label>
                                            <input type="number" name="due_amount" readonly class="form-control" required id="due_amount" value="{{$pv_info->due_amount}}">
                                        </div>
                                        @if ($pv_info->payment_method == "Check")
                                            <div id="banck_information" class="col-12 col-md-12 col-sm-12 col-lg-12">
                                                <div class="row">
                                                    <div class="col-sm-6 col-12">
                                                        <label for="mode">Check No</label>
                                                        <input type="text" name="check_no" class="form-control" required id="check_no" value="{{$pv_info->check_no}}" readonly>
                                                    </div>                                            
                                                    <div class="col-sm-6 col-12">
                                                        <label for="mode">Bank Name</label>
                                                        <input type="text" name="bank_name" class="form-control" required id="bank_name" value="{{$pv_info->bank_name}}" readonly>
                                                    </div>                                            
                                                    <div class="col-sm-6 col-12">
                                                        <label for="mode">Branch Name</label>
                                                        <input type="text" name="branch_name" class="form-control" required id="branch_name" value="{{$pv_info->branch_name}}" readonly>
                                                    </div>
                                                    <div class="col-sm-6 col-12">
                                                        <label for="supplier_name">Supplier Name</label>
                                                        <input type="text" name="supplier_name" class="form-control" id="supplier_name" value="{{$pv_info->supplier_name}}"readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="mb-3">
                            <a class="btn btn-info" href="#" onclick="apr_reviece()">Revise</a>
                            <a class="btn btn-warning" href="{{route('rejected-pv-authorizer', $pv_info->id)}}">Reject</a>
                            <a class="btn btn-success" href="{{route('pv-approve-authorizer', $pv_info->id)}}">Approve</a>
                        </div>
                        <div id="approveRejectedForm" style="display: none;">
                            <form action="{{route("revise-pv-submit-authorizer")}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-10 col-12">
                                        <label for="mode">Comment</label>
                                        <input type="text" required placeholder="Comment" class="form-control" name="comment">
                                        <input type="hidden" required value="{{$pv_info->payment_voucher_no}}" class="form-control" name="payment_voucher_no">
                                    </div>
                                    <div class="col-sm-2 col-12 mt-2">
                                        <button class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('js')
<script>
    function apr_reviece(e) {
        var x = document.getElementById("approveRejectedForm");
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
    }
</script>
@endpush