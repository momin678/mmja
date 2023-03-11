@extends('layouts.backend.app')

@section('title', 'Role Management')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            {{-- <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="breadcrumbs-top">
                        <h5 class="content-header-title float-left pr-1 mb-0">Role Management</h5>
                        <div class="breadcrumb-wrapper d-none d-sm-block">
                            <ol class="breadcrumb p-0 mb-0 pl-1">
                                <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active">Roles
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="content-body">
               
                <!-- Bordered table start -->
                <div class="row" id="table-bordered">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Roles</h4>
                                <a href="{{ route('role.create')}}" class="btn btn-primary">Add New</a>
                            </div>
                            <div class="card-body">
                                <!-- table bordered -->
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Permissions</th>
                                                <th>Updated at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $role)
                        
                                            <tr>
                                            <td>{{ $role->id }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @if ($role->permissions->count() > 0)
                                                    <span class="badge badge-info">{{ $role->permissions->count() }}</span>
                                                @else
                                                    <span class="badge badge-danger">No permission found :(</span>
                                                @endif
                                            </td>
                                            <td>{{ $role->updated_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{route('role.edit', $role->id)}}" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a>
                                                
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
                <!-- Bordered table end -->



            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        // $(document).ready(function() {
            // Page Script
            // alert("Alhamdulillah");
        // });
    </script>
@endpush