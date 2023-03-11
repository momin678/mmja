@extends('layouts.backend.app')

@section('title', 'style edit')
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
                                <h4>Style Information</h4>
                                {{-- <a href="" class="btn btn-primary">Add New</a> --}}
                            </div>
                            <div class="card-body content-padding">
                                <!-- table bordered -->
                                <form action="{{route('style.update', $style_info->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-sm-3 col-12">
                                            <label>Style ID</label>
                                            <input type="text" class="form-control" readonly name="style_no" value="{{$style_info->style_no}}">
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label>Style</label>
                                            <input type="text" class="form-control" name="style_name" value="{{$style_info->style_name}}">
                                            @error('style_name')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-3 d-flex justify-content-end mt-1">
                                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                            <button type="reset" class="btn" id="reset">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="table-responsive card">
                            {{-- <div class="col-md-6 mt-1">
                                <form>
                                    <input type="text" name="q" class="form-control input-xs pull-right ajax-search" placeholder="Search By style No, style Name" data-url="{{ route('admin.masterAccSearchAjax',$id="style") }}">
                                </form>
                            </div> --}}
                            <table class="table table-sm table-bordered">
                                <thead class="user-table-body">
                                    <tr>
                                        <th>Style ID</th>
                                        <th>Style</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($styles as $item)
                                        <tr class="data-row">
                                            <td>{{$item->style_no}}</td>
                                            <td>{{$item->style_name}}</td>
                                            <td>
                                                <a href="{{route('style.edit', $item->id)}}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>                                    
                                                <a href="">
                                                    <form action="{{ route('style.destroy', $item->id) }}" method="POST" class="flot-right">
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