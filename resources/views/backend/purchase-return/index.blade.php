@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'purchase return')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <h3 class="mb-2">Purchase Return</h3>
                        <div class="card">
                            <div class="content-title">
                                <h5>Goods Receive List</h5>
                            </div>
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>PR NO</th>
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
                                            <td>{{$item->prInfo->purchase_no}}</td>
                                            <td>{{$item->purchase_no}}</td>
                                            <td>{{$item->projectInfo->proj_name}}</td>
                                            <td>{{$item->partInfo->pi_name}}</td>
                                            <td>
                                                {{$item->gr_details_check($item->purchase_no)}}/
                                                {{$item->purchase_details->sum("quantity")}}
                                            </td>
                                            <td>
                                                <a href="{{route('purchase-return.show', $item->id)}}" class="btn btn-sm btn-warning">View</a>
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
                                <h5>PT No</h5>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
                                    <i class='bx bx-filter'></i>
                                  </button>
                            </div>
                         </div>
                        <div class="purchase-items">
                            <ul id="pr_list_show">
                                @foreach ($return_lists as $return)
                                    <li><a href="{{route('pt-details', $return->id)}}">{{$return->purchase_return_no}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div>{{$return_lists->links()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">PT Filter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="create" name="create" onclick="pt_filter()">
                            <label class="form-check-label" for="create">
                            PT Create
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="200" id="approval" name="approval" onclick="pt_filter()">
                            <label class="form-check-label" for="approval">
                                PT Approval
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="100" id="completed" name="completed" onclick="pt_filter()">
                            <label class="form-check-label" for="completed">
                            PT Rejected
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
        pt_filter();
        });
    });
    function pt_filter(e){
        var filter_value = [];
        $.each($("input:checkbox[type='checkbox']:checked"), function () {
            filter_value.push($(this).val());
        });
        $.ajax({
            url: "{{URL::to('pt-filter')}}",
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