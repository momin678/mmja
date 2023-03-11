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
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <form action="{{route('item-purchase.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <h5>PO Generation</h5>
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
                            <a class="btn btn-info" href="#" onclick="apr_reviece()">Revise</a>
                            {{-- <a class="btn btn-warning" href="{{route('approver-pr-rejected', $purchase_info->id)}}">Reject</a> --}}
                            <a class="btn btn-success" href="{{route('approve-po-submit', $purchase_info->id)}}">Approve</a>
                        </div>
                        <div id="approveRejectedForm" style="display: none;">
                            <form action="{{route("approve-po-reviece")}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-10 col-12">
                                        <label for="mode">Comment</label>
                                        <input type="text" required placeholder="Comment" class="form-control" name="comment">
                                        <input type="hidden" required value="{{$purchase_info->purchase_no}}" class="form-control" name="purchase_no">
                                    </div>
                                    <div class="col-sm-2 col-12 mt-2">
                                        <button class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('js')
    <script>
        function apr_reviece() {
            var x = document.getElementById("approveRejectedForm");
            if (x.style.display === "block") {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }
        }
    </script>
@endpush