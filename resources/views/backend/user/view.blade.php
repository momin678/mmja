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
            <form class="form form-vertical" action="{{route('supllier.update', $supllier->id)}}" method="POST" enctype="multipart/form-data">
                @csrf 
                @method('PUT')
                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Supplier Information</h4>
                                </div>

                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Company Name</label>
                                                        <input type="text" id="first-name-vertical" class="form-control @error('company_name') error @enderror" name="company_name" value="{{ $supllier->company_name}}" placeholder="Company Name" required readonly>
                                                        @error('company_name')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Email Address</label>
                                                        <input type="email" id="contact-info-vertical" class="form-control @error('email') error @enderror" name="email" value="{{ $supllier->email}}" placeholder="Email ID" required readonly>
                                                        @error('email')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Phone</label>
                                                        <input type="text" id="contact-info-vertical" class="form-control @error('phone') error @enderror" name="phone" value="{{ $supllier->phone}}" placeholder="Phone Number" required readonly>
                                                        @error('phone')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="passport-number">Licence Number</label>
                                                        <input type="text" id="passport-number" class="form-control @error('licence_no') error @enderror" name="licence_no" value="{{ $supllier->licence_no}}"placeholder="Passport Number" required readonly>
                                                        @error('licence_no')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label for="visa-expire-date">Adress</label>
                                                        <textarea name="address"  class="form-control @error('address') error @enderror" cols="30" rows="2" required readonly>{{ $supllier->address}}</textarea>
                                                        @error('address')
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
                            <button type="submit" class="btn btn-primary mr-1">Update</button>
                        </div>
                        
                    </div>
                </section>
                
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