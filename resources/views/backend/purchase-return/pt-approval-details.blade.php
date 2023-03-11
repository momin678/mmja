@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'purchase return approval details')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <form action="{{route('purchase-temp-trasfer')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <h5>Purchase Return</h5>
                                <div class="card">
                                    <div class="card-body content-padding">
                                        <div class="row">
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Purchase Return No</label>
                                                <input type="text" value="{{$pt_info->purchase_return_no}}" class="form-control" name="goods_received_no" readonly>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Goods Receive No</label>
                                                <input type="text" value="{{$pt_info->gr_no}}" class="form-control" name="goods_received_no" readonly>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PO No</label>
                                                <input type="text" required value="{{$pt_info->po_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="project_id">Branch Name</label>
                                                <input type="text" readonly value="{{$pt_info->projectInfo->proj_name}}" class="form-control">
                                                <input type="hidden" name="project_id" value="{{$pt_info->projectInfo->id}}">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Supplier Name</label>
                                                <input type="text" readonly value="{{$pt_info->partInfo->pi_name}}" class="form-control">
                                                <input type="hidden" name="supplier_id" value="{{$pt_info->partInfo->id}}">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">Delivery Note No</label>
                                                <input type="text" name="challan_number" class="form-control" required readonly value="{{$pt_info->challan_number}}">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PT Date</label>
                                                <input type="text" name="date" class="form-control" required value="{{date('d-m-Y', strtotime($pt_info->date))}}" readonly>
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
                                        <th scope="col">Return Qty</th>
                                        <th scope="col">Comment</th>
                                    </tr>
                                </thead>
                                <tbody id="tempLists"  class="user-table-body">
                                    @foreach ($pt_items as $item)
                                    <tr class="data-row">
                                        <td> {{$item->itemName->barcode}} </td>
                                        <td>
                                            {{$item->itemName->item_name}}
                                            <input type="hidden" name="item_id[]" value="{{$item->itemName->id}}">
                                        </td>
                                        <td>{{$item->itemName->brandName->name}}</td>
                                        <td>
                                            {{$item->itemName->group_name}}
                                            <input type="hidden" name="group_name[]" value="{{$item->itemName->group_name}}">
                                        </td>
                                        <td> {{$item->return_qty}} </td>
                                        <td> {{$item->comment}} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mb-3">
                                <a class="btn btn-warning" href="{{route('approval-pt-rejected', $pt_info->id)}}">Rejected</a>
                                <a class="btn btn-success" href="{{route('pt-approval-process', $pt_info->id)}}">Approve</a>
                            </div>
                        </form>
                        <div id="authorizeRejectedForm" style="display: none;">
                            <form action="{{route("approval-pt-reviece")}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-10 col-12">
                                        <label for="mode">Comment</label>
                                        <input type="text" required placeholder="Comment" class="form-control" name="comment">
                                        <input type="hidden" required value="{{$pt_info->purchase_return_no}}" class="form-control" name="purchase_return_no">
                                    </div>
                                    <div class="col-sm-2 col-12 mt-2">
                                        <button class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('js')
    <script>
        function apr_reviece() {
            var x = document.getElementById("authorizeRejectedForm");
            if (x.style.display === "block") {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }
        }
    </script>
@endpush