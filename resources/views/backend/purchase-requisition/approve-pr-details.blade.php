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
@section('title', 'approve pr details')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <h5>Purchase Requisition Approval</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4 col-12">
                                                <label for="mode">PR No</label>
                                                <input type="text" required value="{{$approve_requisition_info->purchase_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="">PR Date:</label>
                                                <input type="text" readonly value="{{date('d-m-Y', strtotime($approve_requisition_info->date))}}" class="form-control">
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <label for="project_id">Branch Name</label>
                                                <input type="text" readonly value="{{$approve_requisition_info->projectInfo->proj_name}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-sm table-bordered">
                                <thead class="user-table-body">
                                    <tr>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Barcode</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Qty</th>
                                    </tr>
                                </thead>
                                <tbody id="tempLists">
                                    @foreach ($purchase_items as $item)
                                    <tr class="data-row">
                                        <td>{{$item->itemName->item_name}}</td>
                                        <td>{{$item->itemName->barcode}}</td>
                                        <td>{{$item->unit}}</td>
                                        <td>{{$item->quantity}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                        <div class="mb-3">
                            <a class="btn btn-info" href="#" onclick="apr_reviece()">Revise</a>
                            <a class="btn btn-warning" href="{{route('approver-pr-rejected', $approve_requisition_info->id)}}">Reject</a>
                            <a class="btn btn-success" href="{{route('approve-pr-submit', $approve_requisition_info->id)}}">Approve</a>
                        </div>
                        <div id="approveRejectedForm" style="display: none;">
                            <form action="{{route("approve-pr-reviece")}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-10 col-12">
                                        <label for="mode">Comment</label>
                                        <input type="text" required placeholder="Comment" class="form-control" name="comment">
                                        <input type="hidden" required value="{{$approve_requisition_info->purchase_no}}" class="form-control" name="purchase_no">
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
            var x = document.getElementById("approveRejectedForm");
            if (x.style.display === "block") {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }
        }
    </script>
@endpush