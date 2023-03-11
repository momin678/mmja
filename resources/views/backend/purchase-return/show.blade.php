@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'purchase return view')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <h3 class="mb-2">Purchase Return</h3>
                        <form action="{{route('purchase-temp-trasfer')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-body content-padding">
                                    <div class="row">
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">PR No</label>
                                            <input type="text" required value="{{$purchase_info->prInfo->purchase_no}}" readonly class="form-control" name="pr_id" id="pr_id">
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">PO No</label>
                                            <input type="text" required value="{{$purchase_info->purchase_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="project_id">Branch Name</label>
                                            <input type="text" readonly value="{{$purchase_info->projectInfo->proj_name}}" class="form-control">
                                            <input type="hidden" name="project_id" value="{{$purchase_info->projectInfo->id}}">
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">Supplier Name</label>
                                            <input type="text" readonly value="{{$purchase_info->partInfo->pi_name}}" class="form-control">
                                            <input type="hidden" name="supplier_id" value="{{$purchase_info->partInfo->id}}">
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">PO Date</label>
                                            <input type="text" name="date" class="form-control" required value="{{date('d-m-Y', strtotime($purchase_info->date))}}" readonly>
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
                                    <tr class="data-row">
                                        <td> {{$item->itemName->barcode}} </td>
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
                                        <td> {{$item->receive_qrt($item->purchase_no, $item->item_id)}} </td>
                                        <td>{{$item->quantity - $item->receive_qrt($item->purchase_no, $item->item_id)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mb-3">
                                @if ($purchase_info->gr_details_check($purchase_info->purchase_no) > 0)
                                    <a class="btn btn-warning" href="{{route('pr-return', $purchase_info->id)}}">Return</a>
                                @else
                                <p class="text-warning">Can't Return Item In This PO No</p>
                                @endif
                            </div>
                            
                        </form>
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
                                @foreach ($return_lists as $received)
                                    <li><a href="{{route('pt-details', $received->id)}}">{{$received->purchase_return_no}}</a></li>
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