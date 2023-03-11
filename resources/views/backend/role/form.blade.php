@extends('layouts.backend.app')

@section('title', 'Role Management')

@push('css')
    
@endpush

@section('content')
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
                            <li class="breadcrumb-item"><a href="#">Roles</a>
                            </li>
                            <li class="breadcrumb-item active"><a href="#">Create Role</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div> --}}
        
        {{-- <div class="row">
            <div class="col-md-12">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              
            </div>
        </div> --}}

        <div class="content-body">
            <form class="form form-vertical" 
            action="{{ isset($role) ? route('role.update', $role->id) : route('role.store')}}" 
            method="POST" enctype="multipart/form-data">
                @csrf 
                @if (isset($role))
                    @method('PUT')
                @endif

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">MANAGE ROLES</h4>
                                </div>

                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">
                                            <div class="row">                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Role Name</label>
                                                        <input type="text" id="contact-info-vertical" class="form-control @error('role_name') error @enderror" name="role_name" value="{{ $role->name ?? old('role_name')}}" placeholder="Role Name">
                                                        @error('role_name')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label></label>
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="checkbox">
                                                                        <input type="checkbox" class="checkbox-input" id="select-all">
                                                                        <label for="select-all"> Select All  </label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                @error('permissions')
                                                <div class="col-md-12 col-12">
                                                <span class="error">{{ $message }}</span>
                                                </div>
                                                @enderror                                                
                                            </div>

                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->

                <section id="basic-checkbox">
                    <div class="row">
                        @forelse ($modules as $module)
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$module->name}}</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($module->permissions as $key=>$permission)
                                        <li class="d-inline-block mr-2 mb-1">
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" class="checkbox-input" id="permission-id-{{$permission->id}}"
                                                    value="{{ $permission->id}}" name="permissions[]"
                                                    
                                                    @if(isset($role))
                                                        @foreach($role->permissions as $rPermission)
                                                        {{ $permission->id == $rPermission->id ? 'checked' : '' }}
                                                        @endforeach
                                                    @endif
                                                    >
                                                    <label for="permission-id-{{$permission->id}}">{{ $permission->name}}</label>
                                                </div>
                                            </fieldset>
                                        </li>                                            
                                        @endforeach
                                    </ul>

                                    @if($loop->last)
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-1">
                                            @isset($role)                                                
                                                Update
                                            @else
                                                Create
                                            @endisset
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary">Reset</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- col-12 end -->  
                        @empty
                            
                        @endforelse

                    </div>
                </section>

            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script>
    <script>
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
            });

            
        });
    </script>
@endpush
