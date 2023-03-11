@extends('layouts.backend.app')
@push('css')
<style>
    .bx-filter{
        font-size: 30px;
        line-height: 0px;
    }
</style>
@endpush
@section('title', 'purchase requisition view')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <h5>Purchase Requisition</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PR No</label>
                                                <input type="text" required value="{{$purchase_info->purchase_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="">PR Date:</label>
                                                <input type="text" readonly value="{{date('d-m-Y', strtotime($purchase_info->date))}}" class="form-control">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="project_id">Branch Name</label>
                                                <input type="text" readonly value="{{$purchase_info->projectInfo->proj_name}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-sm table-bordered">
                                <thead class="user-table-body">
                                    <tr>
                                        <th scope="col">Barcode</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Qty</th>
                                    </tr>
                                </thead>
                                <tbody id="tempLists">
                                    @foreach ($purchase_items as $item)
                                    <tr class="data-row">
                                        <td>{{$item->itemName->barcode}}</td>
                                        <td>{{$item->itemName->item_name}}</td>
                                        <td>{{$item->unit}}</td>
                                        <td>{{$item->quantity}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                        <div class="mb-3">
                            @if ($purchase_info->status == 10)
                                <a class="btn btn-warning" href="{{route('purchase-requisition.edit', $purchase_info->id)}}">Edit</a>
                                <a class="btn btn-info" href="{{route('editor-pr-process', $purchase_info->id)}}">Process</a>
                            @endif
                            <a class="btn btn-light" target="_blank" href="{{route('pr-print', $purchase_info->id)}}">Print</a>
                        </div>
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
                                @foreach ($product_purchases as $product_purchase)
                                    <li><a href="{{route('purchase-requisition.show', $product_purchase->id)}}">{{$product_purchase->purchase_no}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="sm">
                            {{$product_purchases->links()}}
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