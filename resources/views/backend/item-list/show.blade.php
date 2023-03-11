@extends('layouts.backend.app')

@section('title', 'item-list view')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header content-title">
                                <h4>Item List</h4>
                            </div>
                            <div class="card-body">
                                <form action="#" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-4 col-12">
                                            <label for="item_type_no">Style ID</label>
                                            <input type="text" value="{{$item_info->style->style_name}}" readonly class="form-control">
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="brand_id">Color</label>
                                            <input type="text" value="{{$item_info->brandName->name}}" readonly class="form-control">
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="item_type">Size</label>
                                            <input type="text" value="{{$item_info->group_name}}" readonly class="form-control">
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="country">Made In Country</label>
                                            <input type="text" class="form-control" name="country" id="country" readonly required value="{{$item_info->brandName->origin}}">
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="mode">UPC/Barcode</label>
                                            <input type="text" required value="{{$item_info->barcode}}" readonly class="form-control" name="barcode" id="barcode">
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">Item Name</label>
                                            <input type="text" required class="form-control" name="item_name" id="item_name" value="{{$item_info->item_name}}" readonly>
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="mode">Unit</label>
                                            <input type="text" value="{{$item_info->unit}}" readonly class="form-control">
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="description">Description</label>
                                            <input type="text" class="form-control" name="description" id="description" value="{{$item_info->description}}" readonly>
                                            @error('description')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="sell_price">Base Price</label>
                                            <input type="number" required class="form-control" name="sell_price" id="sell_price" value="{{$item_info->sell_price}}" readonly>
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="mode">Vat Rate</label>
                                            <input type="text" value="{{$item_info->vatRate->name}}" readonly class="form-control">
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="mode">Vat </label>
                                            <input type="text" value="{{$item_info->vat_amount}}" readonly class="form-control">
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="mode">Sell Price</label>
                                            <input type="text" value="{{$item_info->total_amount}}" readonly class="form-control">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive card">
                            <div class="col-md-6 mt-1">
                                <form>
                                    <input type="text" name="q" class="form-control input-xs pull-right ajax-search" placeholder="Search By Barcode, Item Name, B Price, Vat" data-url="{{ route('admin.masterAccSearchAjax',$id="iteList") }}">
                                </form>
                            </div>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Barcode</th>
                                        <th>Item Name</th>
                                        <th>B Price</th>
                                        <th>Vat</th>
                                        <th>S Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($itme_lists as $itme_list)
                                        <tr  class="data-row">
                                            <td>{{$itme_list->barcode}}</td>
                                            <td>{{$itme_list->item_name}}</td>
                                            <td>{{$itme_list->sell_price}}</td>
                                            <td>{{$itme_list->vat_amount}}</td>
                                            <td>{{$itme_list->total_amount}}</td>
                                            <td>
                                                <div class="btn-group ">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="{{route('item-list.edit', $itme_list->id)}}">Edit</a>
                                                            <a class="dropdown-item" href="{{route('item-list.show', $itme_list->id)}}">View</a>
                                                            <a class="dropdown-item" href="{{ route('item-list.item-delete', $itme_list->id)}}">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>{{$itme_lists->links()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });
     // Item type
    $("#item_type").change(function (e) { 
        e.preventDefault();
        var item_type = $('#item_type option:selected').val();
        $.ajax({
            type:"post",
            url: "{{URL::to('item-type')}}",
            data:{
                "item_type":item_type
            },
            success:function(data){
                $('#item_type_no').empty();
                var optionHtml = '<option value=""> Select Section </option>';
                data.forEach(function(element, index) {
                    var isSelected = '';
                    if(item_type == element.item_type){
                        isSelected = 'selected';
                    }
                    optionHtml += "<option value='"+element.group_no +"' "+isSelected+">"+ element.group_no+"</option>";
                });
                $('#item_type_no').html(optionHtml);
            }
        });
    });
    // Item type no
    $("#item_type_no").change(function (e) {
        e.preventDefault();
        var item_type_no = $('#item_type_no').val();
        console.log(item_type_no);
        $.ajax({
            type:"post",
            url: "{{URL::to('item-type-no')}}",
            data:{
                "item_type_no":item_type_no
            },
            success:function(data){
                $('#item_type').empty();
                var optionHtml = '<option value=""> Select Section </option>';
                data.forEach(function(element, index) {
                    var isSelected = '';
                    if(item_type_no == element.group_no){
                        isSelected = 'selected';
                    }
                    optionHtml += "<option value='"+element.group_name +"' "+isSelected+">"+ element.group_name+"</option>";
                });
                $('#item_type').html(optionHtml);
            }
        })
    });
     // Brand country get
    $("#brand_id").change(function (e) { 
        e.preventDefault();
        var brand_id = $('#brand_id option:selected').val();
        $.ajax({
            type:"post",
            url: "{{URL::to('brand-country')}}",
            data:{
                "brand_id":brand_id
            },
            success:function(data){
                $('#country').empty();
                document.getElementById("country").value = data;              
            }
        });
    });
</script>
@endpush