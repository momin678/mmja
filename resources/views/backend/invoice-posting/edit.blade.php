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
@section('title', 'invoice-posting edit')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <form action="{{route("purchase-temp-trasfer")}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <h5>Goods Received</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            @php
                                                $goods_received_no = '';
                                                $temp_goods_received_no = '';
                                                $max_no = App\GoodsReceived::whereDate('created_at', '=', date('Y-m-d'))->max('temp_goods_received_no');
                                                if($max_no){
                                                    $temp_goods_received_no = $max_no+1;
                                                    $goods_received_no = $max_no."GR";
                                                }else{
                                                        $temp_goods_received_no = date("Ymd").'01';
                                                        $goods_received_no = $temp_goods_received_no."GR";
                                                }
                                            @endphp
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Goods Received No</label>
                                                <input type="text" value="{{$goods_received_no}}" class="form-control" name="goods_received_no" readonly>
                                                <input type="hidden" value="{{$temp_goods_received_no}}" class="form-control" name="temp_goods_received_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PO No</label>
                                                <input type="text" required value="{{$purchase_info->purchase_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PR No</label>
                                                <input type="text" required value="{{$purchase_info->prInfo->purchase_no}}" readonly class="form-control" name="pr_id" id="pr_id">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="project_id">Project Name</label>
                                                <input type="text" readonly value="{{$purchase_info->projectInfo->proj_name}}" class="form-control">
                                                <input type="hidden" name="project_id" value="{{$purchase_info->projectInfo->id}}">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Supplier Name</label>
                                                <input type="text" readonly value="{{$purchase_info->partInfo->pi_name}}" class="form-control">
                                                <input type="hidden" name="supplier_id" value="{{$purchase_info->partInfo->id}}">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Challan Number</label>
                                                <input type="text" name="challan_number" class="form-control" required>
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
                                    @foreach ($purchase_items as $item)
                                    <tr class="data-row">
                                        <td>
                                            {{$item->itemName->barcode}}
                                        </td>
                                        <td>
                                            {{$item->itemName->item_name}}
                                            <input type="hidden" name="item_id[]" value="{{$item->itemName->id}}">
                                        </td>
                                        <td>
                                            {{$item->brandName->name}}
                                            <input type="hidden" name="color_id[]" value="{{$item->brandName->id}}">
                                        </td>
                                        <td>
                                            {{$item->itemName->group_name}}
                                            <input type="hidden" name="group_name[]" value="{{$item->itemName->group_name}}">
                                        </td>
                                        <td style="max-width: 100px">
                                            <input style="width: 100%" type="number" value="{{$item->quantity}}" max="{{$item->quantity}}" min="1" required="true"  class="qty" name="qty[]">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mb-3">
                                <button class="btn btn-success" type="submit">Process</button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive col-md-2 col-sm-2 col-12 col-lg-2">
                        <div><h5>GR No</h5></div>
                        <div class="purchase-items">
                            <ul>
                                @foreach ($goods_received as $received)
                                    <li><a href="{{route('gr-details', $received->id)}}">{{$received->goods_received_no}}</a></li>
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
@push('js')

@endpush