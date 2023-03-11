@extends('layouts.backend.app')
<style>
    .bx-filter{
        font-size: 30px;
        line-height: 0px;
    }
</style>
@section('content')
@section('title', 'goods-received')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <div class="table-responsive card">
                            <div class="card-header">
                                <h4 class="card-title">Goods Receive</h4>
                            </div>
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>PO NO</th>
                                        <th>Branch NAME</th>
                                        <th>SUPPLIER NAME</th>
                                        <th>Qty Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchases as $item)
                                        <tr >
                                            <td>{{$item->purchase_no}}</td>
                                            <td>{{$item->projectInfo->proj_name}}</td>
                                            <td>{{$item->partInfo->pi_name}}</td>
                                            <td>
                                                {{$item->gr_details_check($item->purchase_no)}}/
                                                {{$item->purchase_details->sum("quantity")}}
                                            </td>
                                            <td>
                                                <a href="{{route('goods-received.show', $item->id)}}" class="btn btn-sm btn-warning">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>{{$purchases->links()}}</div>
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