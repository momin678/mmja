@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'purchase return create')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <h3 class="mb-2">Purchase Return</h3>
                        <form action="{{route('purchase-return.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <div class="card">
                                    <div class="card-body content-padding">
                                        <div class="row">
                                            <div class="col-sm-4 col-12">
                                                @php
                                                    $purchase_return_no = '';
                                                    $temp_purchase_return_no = '';
                                                    $max_no = App\PurchaseReturn::whereDate('created_at', '=', date('Y-m-d'))->max('temp_purchase_return_no');
                                                    if($max_no){
                                                        $temp_purchase_return_no = $max_no+1;
                                                        $purchase_return_no = $temp_purchase_return_no."PT";
                                                    }else{
                                                        $temp_purchase_return_no = date("Ymd").'01';
                                                        $purchase_return_no = $temp_purchase_return_no."PT";
                                                    }
                                                @endphp
                                                <label for="mode">Purchase Return No</label>
                                                <input type="text" value="{{$purchase_return_no}}" class="form-control" name="purchase_return_no" readonly id="purchase_return_no">
                                                <input type="hidden" value="{{$temp_purchase_return_no}}" class="form-control" name="temp_purchase_return_no" >
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Goods Receive No</label>
                                                <input type="text" value="{{$gr_info->goods_received_no}}" class="form-control" name="goods_received_no" readonly id="goods_received_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PO No</label>
                                                <input type="text" required value="{{$gr_info->po_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="project_id">Branch Name</label>
                                                <input type="text" readonly value="{{$gr_info->projectInfo->proj_name}}" class="form-control">
                                                <input type="hidden" name="project_id" value="{{$gr_info->projectInfo->id}}">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Supplier Name</label>
                                                <input type="text" readonly value="{{$gr_info->partInfo->pi_name}}" class="form-control">
                                                <input type="hidden" name="supplier_id" value="{{$gr_info->partInfo->id}}">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Delivery Note No</label>
                                                <input type="text" name="challan_number" class="form-control" required readonly value="{{$gr_info->challan_number}}">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="date">PT Date</label>
                                                <input type="date" name="date" id="date" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-body content-padding">
                                    <div class="row">
                                        <div class="col-sm-2 col-12">
                                            <label for="barcode">Barcode</label>
                                            <input type="number" class="form-control" name="barcode" id="barcode"  readonly>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">Item Name</label>
                                            <select name="item_list_id" id="item_list_id" class="form-control common-select2">
                                                <option value=""></option>
                                                @foreach ($gr_items as $itemList)
                                                    <option value="{{$itemList->itemName->id}}">{{$itemList->itemName->item_name}}</option>                                                    
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="item_list_idErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="color">Color</label>
                                            <input type="text" class="form-control" name="color" id="color" readonly>
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="size">Size</label>
                                            <input type="text" class="form-control" name="size" id="size"  readonly>
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="quantity">Receive QTY</label>
                                            <input type="number" class="form-control" name="received_qty" id="received_qty" readonly>
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="return_qty">Return QTY</label>
                                            <input type="number" class="form-control" name="return_qty" id="return_qty">
                                            <span class="text-danger" id="return_qtyErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="comment">Comment</label>
                                            <input type="text" class="form-control" name="comment" id="comment">
                                            <span class="text-danger" id="commentErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-2 d-flex p-1">
                                            <button class="btn btn-success btn-sm p-1 m-0" id="add_product"><i class="bx bx-plus"></i></button>
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
                                        <th scope="col">R Qty</th>
                                        <th scope="col">Return Qty</th>
                                        <th scope="col">Commet</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tempLists"  class="user-table-body">
                                    @php
                                        $temp_items = App\PurchaseReturnDetail::where('purchase_return_no', $purchase_return_no)->get();
                                    @endphp
                                    @isset($temp_items)
                                    @foreach ($temp_items as $item)
                                    <tr class="data-row">
                                        <td>{{$item->itemName->barcode}} </td>
                                        <td>{{$item->itemName->item_name}}</td>
                                        <td>{{$item->itemName->brandName->name}}</td>
                                        <td>{{$item->itemName->group_name}}</td>
                                        <td>{{$item->received_qty}}</td>
                                        <td>{{$item->return_qty}}</td>
                                        <td>{{$item->comment}}</td>
                                        <td>
                                            <a href="{{ route('temp-return-item-list-delete', $item->id)}}" class="btn btn-danger sm-btn"> <i class="bx bx-trash"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                                    @endisset
                                </tbody>
                            </table>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-info">Submit</button>
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
    document.getElementById("date").valueAsDate = new Date();
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });
    // input information get    
    let purchase_return_no = document.getElementById("purchase_return_no");
    let item_list_info = document.getElementById("item_list_id");
    let return_qty = document.getElementById("return_qty");
    let comment = document.getElementById("comment");
    let purchase_no = document.getElementById("purchase_no");
    let barcode = document.getElementById("barcode");
    let add_product = document.getElementById("add_product");
    let new_product = document.getElementById("new_product");
    let form_submmit = document.getElementById("form_submmit");
    let received_qty = document.getElementById("received_qty");
    let size = document.getElementById("size");
    let color = document.getElementById("color");
    let goods_received_no = document.getElementById("goods_received_no");
    // temporary item store in table
    $('#add_product').on('click',function(e){
        e.preventDefault();

        if(Number(return_qty.value) > Number(received_qty.value)){
            document.getElementById("return_qtyErrorMsg").innerHTML = "Can not return excess of Received Qty";
        }else{
            $.ajax({
            url: "{{URL::to('purchase-return-item-store')}}",
            type:"post",
                data:{
                    purchase_return_no:purchase_return_no.value,
                    item_id:item_list_info.value,
                    received_qty:received_qty.value,
                    return_qty:return_qty.value,
                    comment:comment.value,
                },
                success:function(response){
                    document.getElementById("tempLists").innerHTML = response;
                    var x = document.getElementById("item_list_id");
                    x.remove(x.selectedIndex);
                    barcode.value = '';
                    return_qty.value = '';
                    received_qty.value = '';
                    size.value = '';
                    color.value = '';
                    comment.value = '';
                    document.getElementById('item_list_idErrorMsg').innerHTML = '';
                    document.getElementById('commentErrorMsg').innerHTML = '';
                    document.getElementById('return_qtyErrorMsg').innerHTML = '';
                },
                error: function(response) {
                    if(response.responseJSON.errors.item_id){
                        document.getElementById('item_list_idErrorMsg').innerHTML = response.responseJSON.errors.item_id;
                    }else{
                        document.getElementById('item_list_idErrorMsg').innerHTML = '';
                    }
                    if(response.responseJSON.errors.return_qty){
                        document.getElementById('return_qtyErrorMsg').innerHTML = response.responseJSON.errors.return_qty;
                    }else{
                        document.getElementById('return_qtyErrorMsg').innerHTML = '';
                    }
                    if(response.responseJSON.errors.comment){
                        document.getElementById('commentErrorMsg').innerHTML = response.responseJSON.errors.comment;
                    }else{
                        document.getElementById('commentErrorMsg').innerHTML = '';
                    }
                },
            });
        }
        
    });
    // barcode fetche
    $("#item_list_id").change(function(e){
        e.preventDefault();
        $.ajax({
            url:"{{URL::to('pt-item-barcode')}}",
            type:"POST",
            data:{
                "item_id":this.value,
                "goods_received_no":goods_received_no.value
            },
            success:function(data){
                barcode.value = data[1]['barcode'];
                size.value = data[1]['group_name'];
                color.value = data[0]['name'];
                received_qty.value = data[2]['received_qty'];
            }
        })
    });
</script>
@endpush