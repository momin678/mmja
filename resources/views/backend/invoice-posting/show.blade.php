@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'invoice-posting view')
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
                                <h5>Process Invoice Posting</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            @php
                                                $invoice_posting_no = '';
                                                $temp_invoice_posting_no = '';
                                                $max_no = App\InvoicePosting::whereDate('created_at', '=', date('Y-m-d'))->max('temp_invoice_posting_no');
                                                if($max_no){
                                                    $temp_invoice_posting_no = $max_no+1;
                                                    $invoice_posting_no = $temp_invoice_posting_no."IP";
                                                }else{
                                                        $temp_invoice_posting_no = date("Ymd").'01';
                                                        $invoice_posting_no = $temp_invoice_posting_no."IP";
                                                }

                                            @endphp
                                            
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Invoice Posting No</label>
                                                <input type="text" value="{{$invoice_posting_no}}" class="form-control" name="invoice_posting_no" readonly>
                                                @error('invoice_posting_no')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                                <input type="hidden" value="{{$temp_invoice_posting_no}}" class="form-control" name="temp_invoice_posting_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Goods Received No</label>
                                                <input type="text" value="{{$goods_received->goods_received_no}}" class="form-control" name="goods_received_no" readonly>
                                                
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PO No</label>
                                                <input type="text" required value="{{$goods_received->po_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PR No</label>
                                                <input type="text" required value="{{$goods_received->pr_no}}" readonly class="form-control" name="pr_id" id="pr_id">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="project_id">Branch Name</label>
                                                <input type="text" readonly value="{{$goods_received->projectInfo->proj_name}}" class="form-control">
                                                <input type="hidden" name="project_id" value="{{$goods_received->projectInfo->id}}">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Supplier Name</label>
                                                <input type="text" readonly value="{{$goods_received->partInfo->pi_name}}" class="form-control">
                                                <input type="hidden" name="supplier_id" value="{{$goods_received->partInfo->id}}">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Delivery Note Number</label>
                                                <input type="text" name="challan_number" class="form-control" required>
                                                @error('challan_number')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
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
                                    </tr>
                                </thead>
                                <tbody id="tempLists"  class="user-table-body">
                                    @foreach ($goods_items as $item)
                                    <tr class="data-row">
                                        <td>
                                            {{$item->itemName->barcode}}
                                        </td>
                                        <td>
                                            {{$item->itemName->item_name}}
                                            <input type="hidden" name="item_id[]" value="{{$item->itemName->id}}">
                                        </td>
                                        <td>
                                            {{$item->itemName->brandName->name}}
                                            <input type="hidden" name="color_id[]" value="{{$item->itemName->brandName->id}}">
                                        </td>
                                        <td>
                                            {{$item->itemName->group_name}}
                                            <input type="hidden" name="group_name[]" value="{{$item->itemName->group_name}}">
                                        </td>
                                        <td style="max-width: 100px">
                                            {{$item->received_qty}}
                                            <input style="width: 100%" type="hidden" value="{{$item->received_qty}}" max="{{$item->quantity}}" min="1" required="true"  class="qty" name="qty[]">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mb-3">
                                @empty($goods_received->invoice_posting_check)
                                    <button class="btn btn-success" type="submit">Process</button>
                                @endempty
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive col-md-2 col-sm-2 col-12 col-lg-2">
                        <div><h5>IP No</h5></div>
                        <div class="purchase-items">
                            <ul>
                                @foreach ($invoice_lists as $item)
                                    <li><a href="{{route('ip_details', $item->id)}}">{{$item->invoice_posting_no}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div>{{$invoice_lists->links()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
