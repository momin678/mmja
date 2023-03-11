@extends('layouts.backend.app')

@push('css')
    
@endpush

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            {{-- <div class="content-header-left col-12 mb-2 mt-1">
                <div class="breadcrumbs-top">
                    <h5 class="content-header-title float-left pr-1 mb-0">Leave</h5>
                    <div class="breadcrumb-wrapper d-none d-sm-block">
                        <ol class="breadcrumb p-0 mb-0 pl-1">
                            <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Leave</a>
                            </li>
                            <li class="breadcrumb-item active"><a href="#">Student Leave</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row">
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

            @if(session('msg'))
                    <div class="alert alert-warning ">
                        {!! session('msg') !!}
                    </div>
            @endif
            </div>
          </div>
        <div class="content-body">
            <form class="form form-vertical" 
            action="{{ isset($edit_setting) ? route('settings.update', $edit_setting->id) : route('settings.store')}}" 
            method="POST" 
            enctype="multipart/form-data">
                @csrf 
                @isset($edit_setting)
                    @method('PUT')
                @endisset


                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ isset($edit_setting) ? 'Update' : 'Create' }} Settings</h4>
                                </div>
                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">

                                            <div class="row">
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="config-name">Config Name</label>
                                                        <input type="text" id="config-name" class="form-control @error('config_name') error @enderror" name="config_name" value="{{ isset($edit_setting) ? $edit_setting->config_name : old('config_name')}}" placeholder="Config Name" required>
                                                        @error('config_name')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="config-value">Value Type</label>
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="config_type" class="config_type" id="radio1" value="text" 
                                                                        {{ isset($edit_setting) ? ($edit_setting->config_type=='text' ? 'checked': '' ) : 'checked' }}
                                                                        >
                                                                        <label for="radio1">Text/Number</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="config_type" class="config_type" id="radio2" value="img"
                                                                        {{ (isset($edit_setting) && $edit_setting->config_type=='img' )? 'checked': '' }}
                                                                        >
                                                                        <label for="radio2">Image</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="col-md-5 col-12">
                                                    <div class="form-group conf-val-text">
                                                        <label for="config-value">Config Value</label>
                                                        <input type="text" id="config-value-text"  class="form-control @error('config_value') error @enderror" name="config_value" value="{{ isset($edit_setting) ? $edit_setting->config_value : old('config_value')}}" placeholder="Config Value" style="display: {{ (isset($edit_setting) && $edit_setting->config_type =='img') ? 'none': 'block' }}">
                                                        
                                                        <input type="file" id="config-value-img" class="form-control @error('config_value') error @enderror" name="config_value" style="display:{{ isset($edit_setting) ? ($edit_setting->config_type =='img' ? 'block' : 'none') : 'none' }};">
                                                        @error('config_value')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    
                                                </div>

                                            </div>
                                            

                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    
                                                    <button type="submit" class="btn btn-primary mr-1">
                                                        @isset($edit_setting)
                                                            Update
                                                        @else
                                                            Save
                                                        @endisset
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->

            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            
            $('.config_type').click(function(){
                var conf_type= $(this).val();
                if(conf_type == 'img'){
                    $('#config-value-img').show();
                    $('#config-value-text').val('').hide();
                }else{
                    $('#config-value-text').show();
                    $('#config-value-img').val('').hide();
                }
            });
           

        });
    </script>
@endpush