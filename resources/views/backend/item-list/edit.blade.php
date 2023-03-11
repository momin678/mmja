@extends('layouts.backend.app')

@section('title', 'item-list edit')
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
                                <form action="{{route('item-list.update', $item_info->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method("PUT")
                                    <div class="row">
                                        <div class="col-sm-4 col-12">
                                            <label for="style_id">Style ID</label>
                                            <select name="style_id" id="style_id" class="form-control common-select2" required disabled>
                                                <option value=""></option>
                                                @foreach ($styles as $style)
                                                    <option value="{{$style->id}}" {{ $style->id == $item_info->style_id ? "selected" : "" }}>{{$style->style_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('style_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                            <input type="hidden" name="style_id" value="{{$item_info->style_id}}">
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="brand_id">Color</label>
                                            <select name="brand_id" id="brand_id" class="form-control" required disabled>
                                                <option value=""></option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{$brand->id}}" {{ $item_info->brand_id == $brand->id ? "selected" : "" }}>{{$brand->name}}</option>                                                    
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                            <input type="hidden" name="brand_id" value="{{$item_info->brand_id}}">
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="item_type">Size</label>
                                            <select name="item_type" id="item_type" class="form-control common-select2" required disabled>
                                                @foreach ($groups as $itme_list)
                                                <option value="{{$itme_list->id}}" {{$item_info->group_name == $itme_list->group_name ? "selected" : "" }}>{{$itme_list->group_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('item_type')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                            <input type="hidden" name="item_type" value="{{$item_info->group_name}}">
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="country">Made In Country</label>
                                            <input type="text" class="form-control" name="country" id="country" readonly required value="{{$item_info->country}}">
                                            @error('country')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="mode">UPC/Barcode</label>
                                            <input type="text" required value="{{$item_info->barcode}}" readonly class="form-control" name="barcode" id="barcode">
                                            
                                            @error('barcode')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">Item Name</label>
                                            <input type="text" required class="form-control" name="item_name" id="item_name" value="{{$item_info->item_name}}" readonly>
                                            @error('item_name')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="mode">Unit</label>
                                            <select name="unit" id="unit" class="form-control" required>
                                                <option value=""></option>
                                                @foreach ($units as $unit)
                                                    <option value="{{$unit->name}}" {{ $item_info->unit == $unit->name ? "selected" : "" }}>{{$unit->name}}</option>                                                    
                                                @endforeach
                                            </select>
                                            @error('unit')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="description">Description</label>
                                            <input type="text" class="form-control" name="description" id="description"  value="{{$item_info->description}}">
                                            @error('description')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="sell_price">Base Price</label>
                                            <input type="number" required class="form-control" name="sell_price" id="sell_price" value="{{$item_info->sell_price}}" step=".001">
                                            @error('sell_price')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="mode">Vat Rate</label>
                                            <select name="vat_rate" id="vat_rate" class="form-control" required>
                                                <option value=""></option>
                                                @foreach ($vatRates as $vatRate)
                                                    <option value="{{$vatRate->id}}" {{ $vatRate->id == $item_info->vat_rate ? "selected" : "" }}>{{$vatRate->name}}</option>                                                    
                                                @endforeach
                                            </select>
                                            @error('vat_rate')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="vat_amount">Vat</label>
                                            <input type="text" class="form-control" name="vat_amount" id="vat_amount" readonly required value="{{$item_info->vat_amount}}">
                                            @error('vat_amount')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 col-12">
                                            <label for="total_amount">Sell Price</label>
                                            <input type="text" class="form-control" name="total_amount" id="total_amount" readonly required value="{{$item_info->total_amount}}">
                                            @error('total_amount')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-2 mt-1 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Update</button>
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
    $(document).ready(function() {
            $('.common-select2').select2();
    })
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });
     // item name set
    get_style_id_change();
    get_brand_id_change();
    get_group_id_change();
    var get_style_id = '';
    var get_brand_no = '';
    var get_group_no = '';
    let style_id = document.getElementById("style_id");
    let brand_id = document.getElementById("brand_id");
    let item_type = document.getElementById("item_type");
    let item_name = document.getElementById("item_name");
    let barcode = document.getElementById("barcode");
    $("#style_id").change(function(e){
        e.preventDefault();
        get_style_id_change();
    });
    function get_style_id_change(){
        let style_id = $('#style_id option:selected').val();
        $.ajax({
            type:"post",
            url: "{{URL::to('style-id')}}",
            data:{
                "style_id":style_id
            },
            success:function(data){
                let text = data['style_no'].toString();
                get_style_id = text;
                item_name_create();
            }
        });
    }
     // Brand country get
    $("#brand_id").change(function (e) {
        e.preventDefault();
        get_brand_id_change()
    });
    function get_brand_id_change(){
        var brand_id = $('#brand_id option:selected').val();
        $.ajax({
            type:"post",
            url: "{{URL::to('brand-country')}}",
            data:{
                "brand_id":brand_id
            },
            success:function(data){
                $('#country').empty();
                document.getElementById("country").value = data['origin'];
                let text = data['brand_id'].toString();
                get_brand_no = text;
                item_name_create();
            }
        });
    }
    // item type
    $("#item_type").change(function (e) {
        e.preventDefault();
        get_group_id_change()
    });
    function get_group_id_change(){
        let group_id = $('#item_type option:selected').val();
        $.ajax({
            type:"post",
            url: "{{URL::to('group-id')}}",
            data:{
                "group_id":group_id
            },
            success:function(data){
                let text = data['group_no'].toString();
                get_group_no = text;
                item_name_create();
            }
        });
    }
    function item_name_create(){
        let style_id_text = style_id.options[style_id.selectedIndex].text;
        let brand_id_text = brand_id.options[brand_id.selectedIndex].text;
        let item_type_text = item_type.options[item_type.selectedIndex].text;
        let item_name_count = style_id_text+' '+brand_id_text+' '+item_type_text;
        item_name.value = item_name_count;
        let barcode_count = get_style_id+get_brand_no+get_group_no;
        // barcode.value = barcode_count;
        if(barcode_count.length == 6){
            $.ajax({
                type:"post",
                url: "{{URL::to('item-barcode-check')}}",
                data:{
                    "barcode":barcode_count,
                },
                success:function(data){
                    if(data){
                        var element = document.getElementById("barcode_check");
                        if(element){
                            element.textContent = "same product exist"
                        }
                    }
                }
            });
        }
    }

    // vat amount coute
    let purchase_rate_val = document.getElementById('sell_price');
    let vat_rate_info = document.getElementById('vat_rate');
    let vat_amount_val = document.getElementById('vat_amount');
    let total_amount = document.getElementById('total_amount');
    let vat_rete_type = document.getElementById('vat_rete_type');
    let vat_rate = 0;
    get_vat_type_value()
    vat_rate_info.addEventListener("change", function(e){
        e.preventDefault();
        get_vat_type_value()
    });
    function get_vat_type_value(){
        $.ajax({
            type:"post",
            url: "{{URL::to('vat-type-value')}}",
            data:{
                "vat_type_id":vat_rate_info.value
            },
            success:function(data){
                vat_rate = data;
                total_amount_count()
            }
        });
    }
    vat_rate_info.addEventListener("change", function(){
        total_amount_count();
    });
    purchase_rate_val.addEventListener('change', function(){
        total_amount_count();
    });
    // total amount count
    function total_amount_count(){
        let total = purchase_rate_val.value;
        let vat_amount = (Number(total) * Number(vat_rate)) / 100;
        vat_amount_val.value = vat_amount.toFixed(3);
        let total_vat_amount = Number(vat_amount) + Number(total);
        total_amount.value = total_vat_amount.toFixed(3);
    }
</script>
@endpush