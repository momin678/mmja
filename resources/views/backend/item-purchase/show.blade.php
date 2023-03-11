@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'item-purchase view')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <form action="{{route('item-purchase.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <h5>Product Purchase Order</h5>
                                <div class="card">
                                    <div class="card-body content-padding">
                                        <div class="row">
                                            <div class="col-sm-3 col-12">
                                                <label for="mode">PO No</label>
                                                <input type="text" required value="{{$purchase_info->purchase_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="mode">PR No</label>
                                                <input type="text" required value="{{$purchase_info->prInfo->purchase_no}}" readonly class="form-control" name="pr_id" id="pr_id">
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="project_id">Branch Name</label>
                                                <input type="text" readonly value="{{$purchase_info->projectInfo->proj_name}}" class="form-control">
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="mode">Supplier Name</label>
                                                <input type="text" readonly value="{{$purchase_info->partInfo->pi_name}}" class="form-control">
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="contact_no">Contact No</label>
                                                <input type="text" required class="form-control" name="contact_no" id="contact_no" value="{{$purchase_info->partInfo->con_no}}" readonly>
                                                @error('contact_no')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="address">Address</label>
                                                <input type="text" name="address" class="form-control" id="address" readonly value="{{$purchase_info->partInfo->address}}">
                                                @error('address')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="trn">TRN</label>
                                                <input type="text" name="trn" class="form-control" id="trn" readonly value="{{$purchase_info->partInfo->trn_no}}">
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="tax_invoice_no">Quotation / Reference No</label>
                                                <input type="text" required class="form-control" name="tax_invoice_no" id="tax_invoice_no" value="{{$purchase_info->tax_invoice_no}}" readonly>
                                                @error('tax_invoice_no')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="pay_mode">Payment Mode</label>
                                                <select name="pay_mode" id="pay_mode" class="form-control" required disabled>
                                                    <option value=""></option>
                                                    @foreach ($payMode as $payMode)
                                                        <option value="{{$payMode->title}}" {{$purchase_info->pay_mode == $payMode->title ? "selected":""}}>{{$payMode->title}}</option>                                                    
                                                    @endforeach
                                                </select>
                                                @error('pay_mode')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="pay_term">Payment Terms</label>
                                                <select name="pay_term" id="pay_term" class="form-control" required disabled>
                                                    <option value=""></option>
                                                    @foreach ($payTerms as $payTerm)
                                                        <option value="{{$payTerm->value}}" {{$purchase_info->pay_term == $payTerm->value ? "selected":""}}>{{$payTerm->title}}</option>                                                    
                                                    @endforeach
                                                </select>
                                                @error('pay_term')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="pay_date">Payment Date</label>
                                                <input type="date" name="pay_date" class="form-control" id="pay_date" readonly value="{{$purchase_info->pay_date}}">                                    
                                                @error('pay_date')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="pay_date">Shippment</label>
                                                <input type="text" class="form-control" readonly value="{{$purchase_info->shipping_id}}">
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="pay_date">Date</label>
                                                <input type="text" class="form-control" readonly value="{{date('d-m-Y', strtotime($purchase_info->date))}}">
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
                                        <th scope="col">Vat</th>
                                        <th scope="col">Pur. Rate</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="tempLists"  class="user-table-body">
                                    @foreach ($purchase_items as $item)
                                    <tr class="data-row">
                                        <td>{{$item->itemName->barcode}}</td>
                                        <td>{{$item->itemName->item_name}}</td>
                                        <td>{{$item->brandName->name}}</td>
                                        <td>{{$item->vatRate->name}}</td>
                                        <td>{{$item->purchase_rate}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{number_format((float)$item->total_amount, 2, '.', '') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="border-top">
                                        <td colspan="5"  class="text-right">Amount (AED): </td>
                                        <td colspan="2">
                                            @php
                                                $amount = $purchase_items->sum('total_amount') - $purchase_items->sum('vat_amount');
                                            @endphp
                                                {{ number_format((float)$amount, 2, '.', '')}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">VAT:</td>
                                        <td colspan="2">
                                            {{ number_format((float)$purchase_items->sum('vat_amount'), 2, '.', '')}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">Net Amount (AED):</td>
                                        <td colspan="2">
                                            {{ number_format((float)$purchase_items->sum('total_amount'), 2, '.', '')}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        <div class="mb-3">
                            @if ($purchase_info->status == 10)
                                <a class="btn btn-warning" href="{{route('purchase.edit', $purchase_info->id)}}">Edit</a>
                                <a class="btn btn-info" href="{{route('purchase-process', $purchase_info->id)}}">Process</a>
                            @endif
                            <a href="{{route('purchase-print', $purchase_info->id)}}" class="btn btn-light" target="_blank">Print</a>
                        </div>
                    </div>
                    <div class="table-responsive col-md-2 col-sm-2 col-12 col-lg-2">
                        <div class="d-flex">
                            <div class="mr-auto">
                                <h5>PO No</h5>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
                                    <i class='bx bx-filter'></i>
                                  </button>
                            </div>
                         </div>
                        <div class="purchase-items ">
                            <ul id="po_list_show">
                                @foreach ($product_purchases as $product_purchase)
                                    <li><a href="{{route('item-purchase.show', $product_purchase->id)}}">{{$product_purchase->purchase_no}}</a></li>
                                    <small>
                                        {{$product_purchase->gr_details_check($product_purchase->purchase_no)}}
                                        /{{$product_purchase->purchase_details->sum("quantity")}}
                                    </small>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            {{$product_purchases->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <!-- PO filter Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">PO Filter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="10" id="create" name="create" onclick="po_filter()">
                            <label class="form-check-label" for="create">
                            PO Create
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="approval" name="approval" onclick="po_filter()">
                            <label class="form-check-label" for="approval">
                            PO Approval
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="101" id="completed" name="completed" onclick="po_filter()">
                            <label class="form-check-label" for="completed">
                            PO Completed
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="0" id="process" name="process" onclick="po_filter()">
                            <label class="form-check-label" for="process">
                            PO Process
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="99" id="revise" name="revise" onclick="po_filter()">
                            <label class="form-check-label" for="revise">
                                PO Revise
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="select-all">
                            <label class="form-check-label" for="select-all">All Select</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary btn-sm float-right mt-1"  data-dismiss="modal" id="filter_check">Check</button>
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
            po_filter();
        });        
    });
    
    function po_filter(){
        var filter_value = [];
        $.each($("input:checkbox[type='checkbox']:checked"), function () {
            filter_value.push($(this).val());
        });
        $.ajax({
            url: "{{URL::to('po-filter')}}",
            type:"post",
            data:{
                filter_value:filter_value,
            },
            success:function(response){
                document.getElementById("po_list_show").innerHTML = response;
            }
        });
    }
    </script>
@endpush
