@extends('layouts.backend.app')

@push('css')
    
@endpush

@section('content')
@php
    $emirates=array('Abu Dhabi','Ajman','Dubai','Fujairah','Ras Al Khaimah','Sharjah','Umm Al Quwain');
@endphp
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
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
            </div>
          </div>
        <div class="content-body">
            <form class="form form-vertical" action="{{route('sales-person.store')}}" method="POST" enctype="multipart/form-data">
                @csrf 

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Sales Person</h4>
                                </div>

                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" id="first-name-vertical" class="form-control @error('name') error @enderror" name="name" value="{{ old('name')}}" placeholder="Sales Person Name" required>
                                                        @error('name')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" id="contact-info-vertical" class="form-control @error('email') error @enderror" name="email" value="{{ old('email')}}" placeholder="Email" required>
                                                        @error('email')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mr-1">Submit</button>
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
    <script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/select/form-select2.js"></script>
    <script>
        $(document).ready(function() {
            $('.common-select2').select2();
        });
    </script>
@endpush