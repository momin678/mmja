@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'payment voucher process')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <form action="{{route('invoice-posting-submit')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <h5>Invoice (Posted) Information</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">                                            
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Invoice No</label>
                                                <input type="text" value="{{$ip_info->invoice_posting_no}}" class="form-control" name="invoice_posting_no" readonly>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Goods Received No</label>
                                                <input type="text" value="{{$ip_info->goods_received_no}}" class="form-control" name="goods_received_no" readonly>
                                                
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PO No</label>
                                                <input type="text" required value="{{$ip_info->po_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PR No</label>
                                                <input type="text" required value="{{$ip_info->pr_no}}" readonly class="form-control" name="pr_id" id="pr_id">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Supplier Name</label>
                                                <input type="text" readonly value="{{$ip_info->partInfo->pi_name}}" class="form-control">
                                                <input type="hidden" name="supplier_id" value="{{$ip_info->partInfo->id}}">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Delivery Note Number</label>
                                                <input type="text" name="challan_number" class="form-control" required readonly value="{{$ip_info->delivery_note}}">
                                            </div>
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
                            <div class="mb-3">
                                <a class="btn btn-warning" href="{{route('pv-create', $ip_info->id)}}">Process</a>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive col-md-2 col-sm-2 col-12 col-lg-2">
                        <div class="d-flex">
                            <div class="mr-auto">
                                <h5>PV No</h5>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
                                    <i class='bx bx-filter'></i>
                                </button>
                            </div>
                        </div>
                        <div class="purchase-items">
                            <ul  id="pr_list_show">
                                @foreach ($payment_voucher as $item)
                                    <li><a href="{{route('payment-voucher.show', $item->id)}}">{{$item->payment_voucher_no}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div>{{$payment_voucher->links()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">PV Filter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="0" id="create" name="create" onclick="pv_filter()">
                            <label class="form-check-label" for="create">
                            PV Create
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="authorize" name="authorize" onclick="pv_filter()">
                            <label class="form-check-label" for="authorize">
                            PV Authorize
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="2" id="approval" name="approval" onclick="pv_filter()">
                            <label class="form-check-label" for="approval">
                                PV Approval
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="3" id="update" name="update" onclick="pv_filter()">
                            <label class="form-check-label" for="update">
                            PV Partial
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="99" id="revise" name="revise" onclick="pv_filter()">
                            <label class="form-check-label" for="revise">
                                PV Revise
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="100" id="rejected" name="rejected" onclick="pv_filter()">
                            <label class="form-check-label" for="rejected">
                            PV Rejected
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="2" id="completed" name="completed" onclick="pv_filter()">
                            <label class="form-check-label" for="completed">
                            PV Completed
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="select-all">
                            <label class="form-check-label" for="select-all">All Select</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary btn-sm float-right mt-1" id="filter_check" data-dismiss="modal">Check</button>
            </div>
        </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });
    $(document).ready(function() {
        // Page Script
        $('#select-all').click(function (event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function () {
                    this.checked = false;
                });
            }
        pv_filter();
        });
    });
    function pv_filter(e){
        var filter_value = [];
        $.each($("input:checkbox[type='checkbox']:checked"), function () {
            filter_value.push($(this).val());
        });
        $.ajax({
            url: "{{URL::to('pv-filter')}}",
            type:"post",
            data:{
                filter_value:filter_value,
            },
            success:function(response){
                document.getElementById("pr_list_show").innerHTML = response;
            }
        });
    }

</script>
@endpush