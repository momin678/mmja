@extends('layouts.backend.app')
@section('title', 'mapping')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12">
                        <div class="card">
                            <div class="content-title">
                                <h4 >Mapping</h4>
                                {{-- <a href="" class="btn btn-primary">Add New</a> --}}
                            </div>
                            <div class="card-body content-padding">
                                <!-- table bordered -->
                                <form action="{{route('mapping.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <label for="txn">TXN TYPE</label>
                                            <select name="fld_txn_type" id="txn" class="form-control" required>
                                                <option value=""></option>
                                                <option value="sale">Sale</option>
                                                <option value="purchase">Purchase</option>
                                                <option value="vat">VAT</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label for="mode">MODE</label>
                                            <select name="fld_txn_mode" id="mode" class="form-control">
                                                <option value=""></option>
                                                <option value="cash" required>Cash</option>
                                                <option value="credit">Credit</option>
                                                <option value="vat">VAT</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label for="mode">A/C CODE</label>
                                            <input type="text" class="form-control" name="fld_ac_code" id="fld_ac_code">
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label for="mode">Account Head</label>
                                            <select name="fld_ac_name" id="fld_ac_name" class="form-control">
                                                <option value=""></option>
                                                @foreach ($accoutHeads as $accoutHead)
                                                    <option value="{{$accoutHead->id}}">{{$accoutHead->fld_ac_head}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end mt-1">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn" id="reset">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive card">
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