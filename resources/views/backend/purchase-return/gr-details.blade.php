@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'purchase return details')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <h3 class="mb-2">Purchase Return</h3>
                        <form action="{{route('purchase-temp-trasfer')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <h5>Goods Receive</h5>
                                <div class="card">
                                    <div class="card-body content-padding">
                                        <div class="row">
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Goods Receive No</label>
                                                <input type="text" value="{{$gr_info->goods_received_no}}" class="form-control" name="goods_received_no" readonly>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PO No</label>
                                                <input type="text" required value="{{$gr_info->po_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PR No</label>
                                                <input type="text" required value="{{$gr_info->pr_no}}" readonly class="form-control" name="pr_id" id="pr_id">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="project_id">Branch Name</label>
                                                <input type="text" readonly value="{{$gr_info->projectInfo->proj_name}}" class="form-control">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Supplier Name</label>
                                                <input type="text" readonly value="{{$gr_info->partInfo->pi_name}}" class="form-control">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Delivery Note No</label>
                                                <input type="text" name="challan_number" class="form-control" required value="{{$gr_info->challan_number}}" readonly>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PT Date</label>
                                                <input type="text" name="date" class="form-control" required value="{{date('d-m-Y', strtotime($gr_info->date))}}" readonly>
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
                                        <th scope="col">Size</th>
                                        <th scope="col">Received Qty</th>
                                        <th scope="col">Pandding Qty</th>
                                    </tr>
                                </thead>
                                <tbody id="tempLists"  class="user-table-body">
                                    @foreach ($goods_received_details as $item)
                                    <tr class="data-row">
                                        <td>
                                            {{$item->itemName->barcode}}
                                        </td>
                                        <td>
                                            {{$item->itemName->item_name}}
                                            <input type="hidden" name="item_id[]" value="{{$item->itemName->id}}">
                                        </td>
                                        <td>
                                            {{$item->itemName->group_name}}
                                            <input type="hidden" name="group_name[]" value="{{$item->itemName->group_name}}">
                                        </td>
                                        <td>
                                            {{$item->received_qty}}
                                        </td>
                                        <td>
                                            {{$item->pandding_qty}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="table-responsive col-md-2 col-sm-2 col-12 col-lg-2">
                        <div><h5>PT No</h5></div>
                        <div class="purchase-items">
                            <ul>
                                @foreach ($goods_received as $received)
                                    <li><a href="{{route('pt-details', $received->id)}}">{{$received->goods_received_no}}</a></li>
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
