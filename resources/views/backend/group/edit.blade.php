@extends('layouts.backend.app')

@section('content')
@section('title', 'size edit')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12">
                        <div class="card">
                            <div class="content-title">
                                <h4>Size Information</h4>
                                {{-- <a href="" class="btn btn-primary">Add New</a> --}}
                            </div>
                            <div class="card-body content-padding">
                                <!-- table bordered -->
                                <form action="{{route('group.update', $group_info->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-sm-3 col-12">
                                            <label>Size ID</label>
                                            <input type="text" class="form-control" readonly name="group_no" value="{{$group_info->group_no}}">
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label>Size</label>
                                            <input type="text" class="form-control" name="group_name" value="{{$group_info->group_name}}">
                                        </div>
                                        <div class="col-3 d-flex justify-content-end mt-1">
                                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                            <button type="reset" class="btn" id="reset">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="table-responsive card">
                            {{-- <div class="col-md-6 mb-1 mt-1">
                                <form>
                                    <input type="text" name="q" class="form-control input-xs pull-right ajax-search" placeholder="Search By Group No, Group Name" data-url="{{ route('admin.masterAccSearchAjax',$id="group") }}">
                                </form>
                            </div> --}}
                            <table class="table table-sm table-bordered">
                                <thead class="user-table-body">
                                    <tr>
                                        <th>Size ID</th>
                                        <th>Size</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($groups as $item)
                                        <tr class="data-row">
                                            <td>{{$item->group_no}}</td>
                                            <td>{{$item->group_name}}</td>
                                            <td>
                                                <a href="{{route('group.edit', $item->id)}}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>                                    
                                                <a href="">
                                                    <form action="{{ route('group.destroy', $item->id) }}" method="POST" class="flot-right">
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

@endpush