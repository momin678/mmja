@extends('layouts.backend.app')

@section('title', 'payment voucher')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <div class="table-responsive card">
                            <div class="card-header">
                                <h4 class="card-title">Receipt Voucher</h4>
                            </div>
                            <table class="table table-sm table-bordered">
                                <thead class="user-table-body">
                                    <tr>
                                        <th>Invoice NO</th>
                                        <th>Customer Name</th>
                                        <th>Project Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $item)
                                        <tr class="data-row">
                                            <td>{{$item->invoice_no}}</td>
                                            <td>{{$item->partyInfo($item->customer_name)->pi_name}}</td>
                                            <td>{{$item->project->proj_name}}</td>
                                            <td>
                                                <a href="{{route('invoice-details', $item->id)}}" class="btn btn-sm btn-warning">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="table-responsive col-md-2 col-sm-2 col-12 col-lg-2">
                        <div class="d-flex">
                            <div class="mr-auto">
                                <h5>RV No</h5>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#exampleModalCenter">
                                    <i class='bx bx-filter'></i>
                                </button>
                            </div>
                        </div>
                        <div class="purchase-items">
                            <ul id="pr_list_show">
                                @foreach ($rvs as $item)
                                    <li><a href="{{route("receipt-voucher.show", $item->id)}}">{{$item->rv_no}}</a></li>
                                @endforeach
                            </ul>
                        </div>
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
            <h5 class="modal-title" id="exampleModalCenterTitle">RV Filter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="0" id="create" name="create" onclick="rv_filter()">
                            <label class="form-check-label" for="create">
                            RV Create
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="authorize" name="authorize" onclick="rv_filter()">
                            <label class="form-check-label" for="authorize">
                            PV Process
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="2" id="approval" name="approval" onclick="rv_filter()">
                            <label class="form-check-label" for="approval">
                                RV Approval
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="3" id="update" name="update" onclick="rv_filter()">
                            <label class="form-check-label" for="update">
                            PV Partial
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="99" id="revise" name="revise" onclick="rv_filter()">
                            <label class="form-check-label" for="revise">
                                RV Revise
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="200" id="completed" name="completed" onclick="rv_filter()">
                            <label class="form-check-label" for="completed">
                            RV Completed
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
        rv_filter();
        });
    });
    function rv_filter(e){
        var filter_value = [];
        $.each($("input:checkbox[type='checkbox']:checked"), function () {
            filter_value.push($(this).val());
        });
        $.ajax({
            url: "{{URL::to('rv-filter')}}",
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