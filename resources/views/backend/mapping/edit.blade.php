@extends('layouts.backend.app')
@section('title', 'mapping edit')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Mapping</h4>
                                {{-- <a href="" class="btn btn-primary">Add New</a> --}}
                            </div>
                            <div class="card-body">
                                <!-- table bordered -->
                                <form action="{{route('mapping.update', $mapping_info->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-sm-2 col-12 mb-1">
                                            <label for="txn">TXN TYPE</label>
                                            <select name="fld_txn_type" id="txn" class="form-control" required>
                                                <option value=""></option>
                                                <option value="sale" {{$mapping_info->fld_txn_type == "sale" ? "selected":""}}>Sale</option>
                                                <option value="purchase" {{$mapping_info->fld_txn_type == "purchase" ? "selected":""}}>Purchase</option>
                                                <option value="vat" {{$mapping_info->fld_txn_type == "vat" ? "selected":""}}>VAT</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2 col-12 mb-1">
                                            <label for="mode">MODE</label>
                                            <select name="fld_txn_mode" id="mode" class="form-control">
                                                <option value=""></option>
                                                <option value="cash" {{$mapping_info->fld_txn_mode == "cash" ? "selected":""}}>Cash</option>
                                                <option value="credit" {{$mapping_info->fld_txn_mode == "credit" ? "selected":""}}>Credit</option>
                                                <option value="vat" {{$mapping_info->fld_txn_mode == "vat" ? "selected":""}}>VAT</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 col-12 mb-1">
                                            <label for="mode">A/C CODE</label>
                                            <input type="text" class="form-control" name="fld_ac_code" id="fld_ac_code" value="{{$mapping_info->fld_ac_code}}">
                                        </div>
                                        <div class="col-sm-3 col-12 mb-1">
                                            <label for="mode">Account Head</label>
                                            <select name="fld_ac_name" id="fld_ac_name" class="form-control">
                                                <option value=""></option>
                                                @foreach ($accoutHeads as $accoutHead)
                                                    <option value="{{$accoutHead->id}}" {{$mapping_info->fld_ac_name == $accoutHead->id ? "selected":""}}>{{$accoutHead->fld_ac_head}}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-1 col-12">
                                            <label for="mode"></label>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="user-table-body">
                                            <tr>
                                                <th>TXN Type</th>
                                                <th>MODE</th>
                                                <th>A/C CODE</th>
                                                <th>Account Head</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mapping as $item)
                                                <tr  class="data-row">
                                                    <td>{{$item->fld_txn_type}}</td>
                                                    <td>{{$item->fld_txn_mode}}</td>
                                                    <td>{{$item->fld_ac_code}}</td>
                                                    <td>{{$item->accountHead->fld_ac_head}}</td>
                                                    <td>
                                                        <a href="{{route('mapping.edit', $item->id)}}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>                                    
                                                        <a href="">
                                                            <form action="{{ route('mapping.destroy', $item->id) }}" method="POST" class="flot-right">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirm?')" ><i class="bx bx-trash"></i></button>
                                                            </form>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

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
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });
     // A/C CODE get
    $("#fld_ac_name").change(function (e) { 
        e.preventDefault();
        var account_head_id = $('#fld_ac_name option:selected').val();
        $.ajax({
            type:"post",
            url: "{{URL::to('account-head')}}",
            data:{
                "account_head_id":account_head_id
            },
            success:function(data){
                $('#fld_ac_code').empty();
                console.log(data);
                document.getElementById("fld_ac_code").value = data;              
            }
        });
    });
    // ACCOUNT HEAD get
    $("#fld_ac_code").change(function (e) { 
        e.preventDefault();
        var fld_ac_code = $('#fld_ac_code').val();
        $.ajax({
            type:"post",
            url: "{{URL::to('account-code')}}",
            data:{
                "fld_ac_code":fld_ac_code
            },
            success:function(data){
                $('#fld_ac_name').empty();
                var optionHtml = '<option value=""> Select Section </option>';
                data.forEach(function(element, index) {
                    var isSelected = '';
                    if(fld_ac_code == element.fld_ac_code){
                        isSelected = 'selected';
                    }
                    optionHtml += "<option value='"+element.id +"' "+isSelected+">"+ element.fld_ac_head+"</option>";
                });
                $('#fld_ac_name').html(optionHtml);
            }
        })
    });
</script>
@endpush