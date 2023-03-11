@extends('layouts.backend.app')
@push('css')
<style>
    .bx-filter{
        font-size: 30px;
        line-height: 0px;
    }
    .col-padding-customize{
        padding: 2px !important;
    }
</style>
@section('title', 'purchase requisition edit')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <form action="{{route('purchase-requisition.update', $prInfo->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div>
                                <h5>Purchase Requisition </h5>
                                <div class="card">
                                    <div class="card-body content-padding">
                                        <div class="row">
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Purchase No</label>
                                                <input type="text" required value="{{$prInfo->purchase_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                                                <span class="text-danger" id="purchaseNoErrorMsg"></span>
                                                <input type="hidden" value="{{$prInfo->temp_purchase_no}}" name="temp_purchase_no" id="temp_purchase_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="">PR Date:</label>
                                                <input type="date" value="{{$prInfo->date}}" name="date" class="form-control">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="project_id">Branch Name</label>
                                                <select name="project_id" id="project_id" class="form-control" required>
                                                    <option value=""></option>
                                                    @foreach ($projects as $project)
                                                        <option value="{{$project->id}}" {{$prInfo->project_id == $project->id ? "selected": ""}}>{{$project->proj_name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" id="projectIdErrorMsg"></span>
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
                                            <input type="number" class="form-control" name="barcode" id="barcode" >
                                            <span class="text-danger" id="barcodeErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-5 col-12 col-padding-customize">
                                            <label for="mode">Item Name</label>
                                            <select name="item_list_id" id="item_list_id" class="form-control common-select2">
                                                <option value=""></option>
                                                @foreach ($itemLists as $itemList)
                                                    <option value="{{$itemList->id}}" {{ old('item_list_id') == $itemList->item_name ? "selected" : "" }}>{{$itemList->item_name}}</option>                                                    
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="itemListErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-2 col-12 col-padding-customize">
                                            <label for="mode">Unit</label>
                                            <select name="unit" id="unit" class="form-control">
                                                <option value=""></option>
                                                @foreach ($units as $unit)
                                                    <option value="{{$unit->name}}" {{ "PCS" == $unit->name ? "selected" : "" }}>{{$unit->name}}</option>                                                    
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="unitErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-1 col-12 col-padding-customize">
                                            <label for="quantity">QTY</label>
                                            <input type="number" class="form-control" name="quantity" id="quantity" value="{{old('quantity')}}">
                                            <span class="text-danger" id="quantityErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-2 d-flex p-1">
                                            <button class="btn btn-success btn-sm p-1 m-0" id="add_product"><i class="bx bx-plus"></i></button>
                                            <button class="btn btn-warning btn-sm ml-1 p-1 m-0" id="refresh"><i class="bx bx-refresh"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Barcode</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tempLists" class="user-table-body">
                                    @foreach ($purchase_details_temps as $item)
                                    <tr>
                                        <td>{{$item->itemName->barcode}}</td>
                                        <td>{{$item->itemName->item_name}}</td>
                                        <td>{{$item->unit}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>
                                            <a href="{{ route('pr-item-list-delete', $item->id)}}" class="btn btn-danger sm-btn"> <i class="bx bx-trash"></i> </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @isset($desableid)
                                {{$desableid}}
                            @endisset
                            <div class="col-12 d-flex justify-content-end mb-1">
                                <button type="submit" class="btn btn-primary" id="form_submmit">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive col-md-2 col-sm-2 col-12 col-lg-2">                                         
                        <div class="d-flex">
                            <div class="mr-auto">
                                <h5>PR No</h5>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
                                    <i class='bx bx-filter'></i>
                                </button>
                            </div>
                        </div>
                        <div class="purchase-items ">
                            <ul  id="pr_list_show">
                                @foreach ($purchaseRequisitions as $product_purchase)
                                    <li><a href="{{route('purchase-requisition.show', $product_purchase->id)}}">{{$product_purchase->purchase_no}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="sm">
                            {{$purchaseRequisitions->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <!-- PR filter Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">PR Filter</h5>
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
                            PR Create
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="0" id="update" name="update" onclick="po_filter()">
                            <label class="form-check-label" for="update">
                            PR Update
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="authorize" name="authorize" onclick="po_filter()">
                            <label class="form-check-label" for="authorize">
                            PR Authorize
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="2" id="approval" name="approval" onclick="po_filter()">
                            <label class="form-check-label" for="approval">
                                PR Approval
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="99" id="revise" name="revise" onclick="po_filter()">
                            <label class="form-check-label" for="revise">
                                PR Revise
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="100" id="rejected" name="rejected" onclick="po_filter()">
                            <label class="form-check-label" for="rejected">
                            PR Rejected
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="101" id="completed" name="completed" onclick="po_filter()">
                            <label class="form-check-label" for="completed">
                            PR Completed
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
    // input information get    
    let serial_info = document.getElementById("purchase_no");
    let item_list_info = document.getElementById("item_list_id");
    let quantity_val = document.getElementById("quantity");
    let barcode = document.getElementById("barcode");
    let unit_info = document.getElementById("unit");
    let purchase_no = document.getElementById("purchase_no");
    let project_id = document.getElementById("project_id");
    let add_product = document.getElementById("add_product");
    let form_submmit = document.getElementById("form_submmit");
    project_id.addEventListener("change", function(e){
        e.preventDefault();
        form_submmit.removeAttribute('disabled');

    });
    // temporary item store in table
    $('#add_product').on('click',function(e){
        e.preventDefault();
        $.ajax({
          url: "{{URL::to('purchase-requisition-item-store')}}",
          type:"post",
          data:{
            purchase_no:serial_info.value,
            item_list_id:item_list_info.value,
            quantity:quantity_val.value,
            unit:unit_info.value,
          },
          success:function(response){
            document.getElementById("tempLists").innerHTML = response;
            barcode.value = '';
            quantity_val.value = '';
            document.getElementById('itemListErrorMsg').innerHTML = '';
            document.getElementById('unitErrorMsg').innerHTML = '';
            document.getElementById('quantityErrorMsg').innerHTML = '';
            form_submmit.removeAttribute('disabled');
          },
            error: function(response) {
                if(response.responseJSON.errors.item_list_id){
                    document.getElementById('itemListErrorMsg').innerHTML = response.responseJSON.errors.item_list_id;
                }else{
                    document.getElementById('itemListErrorMsg').innerHTML = '';
                }
                if(response.responseJSON.errors.quantity){
                    document.getElementById('quantityErrorMsg').innerHTML = response.responseJSON.errors.quantity;
                }else{
                    document.getElementById('quantityErrorMsg').innerHTML = '';
                }
                if(response.responseJSON.errors.unit){
                    document.getElementById('unitErrorMsg').innerHTML = response.responseJSON.errors.unit;
                }else{
                    document.getElementById('unitErrorMsg').innerHTML = '';
                }
            },
        });
    });
    // product form reset 
    let productReset = document.getElementById('refresh');
    productReset.addEventListener("click", function(e){
        e.preventDefault();
        item_list_info.selectedIndex = 0;
        unit_info.selectedIndex = 0;
        quantity_val.value = "";

    });
    // barcode fetche
    $("#item_list_id").change(function(e){
        e.preventDefault();
        $.ajax({
            url:"{{URL::to('item-barcode')}}",
            type:"POST",
            data:{
                "item_id":this.value
            },
            success:function(data){
                document.getElementById("barcode").value = data.barcode;
            }
        })
    });
    // item name auto selectet depend on barcode
    $("#barcode").change(function(e){
        e.preventDefault();
          var barcode = this.value;
        $.ajax({
            type:"post",
            url: "{{URL::to('item-name-auto-select')}}",
            data:{
                "barcode":barcode
            },
            success:function(data){
                $('#item_list_id').empty();
                    var optionHtml = '<option value=""> Select Section </option>';
                data.forEach(function(element, index) {
                    var isSelected = '';
                    if(barcode == element.barcode){
                        isSelected = 'selected';
                    }
                    optionHtml += "<option id='"+element.barcode+"' value='"+element.id +"' "+isSelected+">"+ element.item_name+"</option>";
                });
                $('#item_list_id').html(optionHtml);
            }
        })
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
        po_filter();
        });
    });
    function po_filter(e){
        var filter_value = [];
        $.each($("input:checkbox[type='checkbox']:checked"), function () {
            filter_value.push($(this).val());
        });
        $.ajax({
            url: "{{URL::to('pr-filter')}}",
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