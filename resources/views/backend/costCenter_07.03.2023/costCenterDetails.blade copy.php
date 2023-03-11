@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

@endpush
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-12 mt-1 mb-2">
                            <h4>Cost Center Form</h4>
                            <hr>
                            {{-- @include('alerts.alerts') --}}
                        </div>
                    </div>
                  <div class="row">
                      <div class="col-12">
                          <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Cost Center Details</h4>
                            </div>
                              <div class="card-body">
                                @isset($costCenter)
                                <form action="{{ route('costCentersUpdate', $costCenter) }}" method="POST">

                                @else
                                <form action="{{ route('costCentersPost') }}" method="POST">

                                @endisset
                                    @csrf
                                <div class="row match-height">



                                    <div class="col-md-6">

                                                    <div class="form-body">
                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <label>Cost Center Name</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" id="cc_name" class="form-control" name="cc_name" value="{{ isset($costCenter)?$costCenter->cc_name:"" }}" placeholder="Cost Center Name" required>


                                                            @error('cc_name')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                            @enderror
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>CosT Type</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <select name="cc_type" class="form-control" id="" required>
                                                                    <option value="">Select...</option>
                                                                    @foreach ($costTypes as $item)
                                                                    <option value="{{ $item->title }}" {{ isset($costCenter)?($costCenter->cc_type==$item->title?"selected":""):"" }}>{{ $item->title }}</option>
                                                                    @endforeach
                                                                    </select>

                                                                @error('cc_type')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                            @enderror
                                                            </div>


                                                            <div class="col-md-4">
                                                                <label>TRN</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" id="trn_no" class="form-control" name="trn_no" value="{{ isset($costCenter)?$costCenter->trn_no:"" }}" placeholder="TRN Number" required >


                                                            @error('trn_no')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                            @enderror
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>Address</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" id="address" class="form-control" name="address" value="{{ isset($costCenter)?$costCenter->address:"" }}" placeholder="Address" >


                                                            @error('address')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                            @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Contact Person</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" id="con_person" class="form-control" name="con_person" value="{{ isset($costCenter)?$costCenter->con_person:"" }}" placeholder="Contact Person" >


                                                            @error('con_person')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                            @enderror
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>Mobile Phone No</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="number" id="con_no" class="form-control" name="con_no" value="{{ isset($costCenter)?$costCenter->con_no:"" }}" placeholder="Mobile No" >


                                                            @error('con_no')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                            @enderror
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>Phone No</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="number" id="phone_no" class="form-control" name="phone_no" value="{{ isset($costCenter)?$costCenter->phone_no:"" }}" placeholder="Phone No" >


                                                            @error('phone_no')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                            @enderror
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>Email</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" id="email" class="form-control" name="email" value="{{ isset($costCenter)?$costCenter->email:"" }}" placeholder="Email" >


                                                            @error('email')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                            @enderror
                                                            </div>

                                                            <div class="col-12 d-flex justify-content-end ">
                                                                <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                                                <button type="reset" class="btn btn-light-secondary">Reset</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                    </div>
                                </div>
                            </form>
                              </div>
                          </div>
                      </div>
                  </div>
                <div class="row">
                    <div class="col-md-6">
                        <form >
                                    <input type="text" name="q" class="form-control input-xs pull-right ajax-search"
                                        placeholder="Search By Code, Cost Center Name, TRN Number"
                                        data-url="{{ route('admin.masterAccSearchAjax',$id="costCenter") }}">

                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('pdf', $id = "costCenter" ) }}" class="btn btn-xs btn-info float-right" target="_blank">Print</a>
                        <button class="btn btn-xs btn-info float-right"
                    onclick="exportTableToCSV('Costcenterdetails.csv')">Export To CSV</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>Code</th>
                                <th>Cost Center Name</th>
                                <th>Type</th>
                                <th>TRN Number</th>
                                <th>Contact Person</th>
                                <th>Contact Number</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody class="user-table-body">
                                @foreach ($costCenters as $cCenter)
                                <tr>
                                    <td>{{ $cCenter->cc_code }}</td>
                                    <td>{{ $cCenter->cc_name }}</td>
                                    <td>{{ $cCenter->cc_type }}</td>
                                    <td>{{ $cCenter->trn_no }}</td>
                                    <td>{{ $cCenter->con_person }}</td>
                                    <td>{{ $cCenter->con_no }}</td>
                                    <td>{{ $cCenter->phone_no }}</td>
                                    <td>{{ $cCenter->address }}</td>
                                    <td>{{ $cCenter->email }}</td>

                                    <td style="white-space: nowrap">
                                        <a href="{{ route('costCenEdit',$cCenter) }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                        <a href="{{ route('costCenDelete',$cCenter) }}" onclick="return confirm('about to delete cost center. Please, Confirm?')" class="btn btn-sm btn-danger"><i class="bx bx-trash" aria-hidden="true"></i></a>

                                    </td>
                                </tr>

                                @endforeach
                            </tbody>


                        </table>

                    </div>

                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        {{$costCenters->links()}}
                    </div>
                </div>
                </section>
                <!-- Widgets Statistics End -->



            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        // $(document).ready(function() {
            // Page Script
            // alert("Alhamdulillah");
        // });
    </script>

@endpush
