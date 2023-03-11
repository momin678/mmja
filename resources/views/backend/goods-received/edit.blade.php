@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'goods-received edit')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <form action="{{route("goods-received.store")}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <h5>Goods Receive</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Goods Receive No</label>
                                                <input type="text" value="" class="form-control" readonly>
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
                                                <label for="mode">GR Date</label>
                                                <input type="date" name="date" class="form-control" id="date">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Supplier Name</label>
                                                <input type="text" readonly value="{{$purchase_info->partInfo->pi_name}}" class="form-control">
                                                <input type="hidden" name="supplier_id" value="{{$purchase_info->partInfo->id}}">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Delivery Note No</label>
                                                <input type="text" name="challan_number" class="form-control" required>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="project_id">Project Name</label>
                                                <input type="text" readonly value="{{$purchase_info->projectInfo->proj_name}}" class="form-control">
                                                <input type="hidden" name="project_id" value="{{$purchase_info->projectInfo->id}}">
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
                                        <th scope="col">PO Qty</th>
                                        <th scope="col">Received Qty</th>
                                        <th scope="col">Pending Qty</th>
                                    </tr>
                                </thead>
                                <tbody id="tempLists"  class="user-table-body">
                                    @foreach ($purchase_items as $item)
                                    @php
                                        $item_count = App\GoodsReceivedDetails::whereIn('goods_received_no', $gr_info)->where("item_id", $item->itemName->id)->sum("received_qty");
                                    @endphp
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
                                        <td> {{$item->quantity}} </td>
                                        <td> {{$item_count}} </td>
                                        <td>
                                            <input style="width: 100%" type="number" value="{{$item->quantity - $item_count}}" max="{{$item->quantity - $item_count}}" required="true"  class="qty" name="qty[]">
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
                        <div class="d-flex">
                            <div class="mr-auto">
                                <h5>GR No</h5>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
                                    <i class='bx bx-filter'></i>
                                  </button>
                            </div>
                         </div>
                        <div class="purchase-items">
                            <ul id="gr_list_show">
                                @foreach ($goods_received as $received)
                                    <li><a href="{{route('gr-details', $received->id)}}">{{$received->goods_received_no}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div>{{$goods_received->links()}}</div>
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
        <h5 class="modal-title" id="exampleModalCenterTitle">GR Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="0" id="create" name="create" onclick="po_filter()">
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
                </div>
                <div class="col-md-6">
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
            <button type="submit" class="btn btn-secondary btn-sm float-right mt-1" data-dismiss="modal" id="filter_check">Check</button>
        </div>
    </div>
    </div>
</div>
@endsection
@push('js')
<script>
    document.getElementById("date").valueAsDate = new Date();
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
    }
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
        var po_filter_value = [];
        $.each($("input:checkbox[type='checkbox']:checked"), function () {
            po_filter_value.push($(this).val());
        });
        console.log(po_filter_value);
        $.ajax({
            url: "{{URL::to('gr-list-show')}}",
            type:"post",
            data:{
                po_filter_value:po_filter_value,
            },
            success:function(response){
                document.getElementById("gr_list_show").innerHTML = response;
            }
        });
    }
</script>
@endpush