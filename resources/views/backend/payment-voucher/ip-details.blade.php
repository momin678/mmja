@extends('layouts.backend.app')
@push('css')
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
@section('title', 'invoice posting details')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <form action="{{route('purchase-temp-trasfer')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <h5>Invoice Posting Details</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Invoice Posting No</label>
                                                <input type="text" value="{{$invoice_posting->invoice_posting_no}}" class="form-control" name="goods_received_no" readonly>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Goods Received No</label>
                                                <input type="text" value="{{$invoice_posting->goods_received_no}}" class="form-control" name="goods_received_no" readonly>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PO No</label>
                                                <input type="text" required value="{{$invoice_posting->po_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PR No</label>
                                                <input type="text" required value="{{$invoice_posting->pr_no}}" readonly class="form-control" name="pr_id" id="pr_id">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="project_id">Branch Name</label>
                                                <input type="text" readonly value="{{$invoice_posting->projectInfo->proj_name}}" class="form-control">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Supplier Name</label>
                                                <input type="text" readonly value="{{$invoice_posting->partInfo->pi_name}}" class="form-control">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Delivery Note Number</label>
                                                <input type="text" name="challan_number" class="form-control" required value="{{$invoice_posting->delivery_note}}" readonly>
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
                                        <th scope="col">Rate</th>
                                    </tr>
                                </thead>
                                <tbody id="tempLists"  class="user-table-body">
                                    @foreach ($details as $item)
                                    <tr class="data-row">
                                        <td>
                                            {{$item->itemName->barcode}}
                                        </td>
                                        <td>
                                            {{$item->itemName->item_name}}
                                        </td>
                                        <td>
                                            {{$item->itemName->brandName->name}}
                                        </td>
                                        <td>
                                            {{$item->itemName->group_name}}
                                        </td>
                                        <td>
                                            {{$item->quantity}}
                                        </td>
                                        <td>
                                            {{$item->purchase_rate}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
