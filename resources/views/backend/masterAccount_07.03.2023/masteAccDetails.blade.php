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
                        <div class="col-md-6">
                            <h4>Master Account Form</h4>
                        </div>
                        <div class="col-md-6 text-right d-none">
                            <a href="{{ route('mstAccType') }}" class="btn btn-info">Manage Master Account Type</a>
                        </div>
                    </div>
                  <div class="row">
                      <div class="col-12">
                        @isset($masterAcc)
                        <form action="{{ route('masterDetailsUpdate', $masterAcc) }}" method="POST">

                        @else
                        <form action="{{ route('masterDetailsPost') }}" method="POST">

                        @endisset
                            @csrf
                          <div class="card">


                              <div class="card-body">
                                <div class="row pb-1 d-flex align-items-center">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <h4 class="card-title">Master Account Details</h4>

                                    </div>
                                    <div class="col-md-3">

                                            <select name="category" class="common-select2" style="width: 100% !important" id="category" {{ isset($masterAcc)?'disabled readonly':'' }} >
                                                <option value="">Select Category...</option>
                                                @foreach ($categories as $item)
                                                <option value="{{ $item->id }}" >{{ $item->title }}</option>

                                                @endforeach

                                            </select>
                                            @error('category')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                @isset($masterAcc)
                                <form action="{{ route('masterDetailsUpdate', $masterAcc) }}" method="POST">

                                @else
                                <form action="{{ route('masterDetailsPost') }}" method="POST">

                                @endisset
                                    @csrf
                                <div class="row match-height">



                                    <div class="col-md-6">

                                                    <div class="form-body">
                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <label>Master A/C Code</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" id="mst_ac_code" class="form-control" name="mst_ac_code" value="{{ isset($masterAcc)?$masterAcc->mst_ac_code:"" }}" placeholder="Master A/C Code" disabled>


                                                            @error('mst_ac_code')

                                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                            @enderror
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>Master A/C Head</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" id="mst_ac_head" class="form-control" name="mst_ac_head" value="{{ isset($masterAcc)?$masterAcc->mst_ac_head:"" }}" placeholder="Master A/C Head" required>


                                                            @error('mst_ac_head')

                                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                            @enderror
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>Definition</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <select name="mst_definition" class="common-select2" style="width: 100% !important" id="" required>
                                                                    <option value="">Select...</option>
                                                                    @foreach ($mst_definitions as $item)
                                                                    <option value="{{ $item->title }}" {{ isset($masterAcc)?($masterAcc->mst_definition==$item->title?"selected":""):"" }}>{{ $item->title }}</option>

                                                                    @endforeach
                                                                </select>

                                                                @error('mst_definition')
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
                                                                <label>Master A/C Type</label>
                                                            </div>
                                                            <div class="col-md-8 form-group ">
                                                                <select name="mst_ac_type" class="common-select2" style="width: 100% !important" id="mst_ac_type" {{ isset($masterAcc)? "disabled readonly":"required"}} >
                                                                    <option value="">Select...</option>
                                                                    @foreach ($mstAccType as $item)
                                                                    <option value="{{ $item->title }}" {{ isset($masterAcc)?($masterAcc->mst_ac_type==$item->title?"selected":""):"" }}>{{ $item->title }}</option>

                                                                    @endforeach

                                                                </select>
                                                                @error('mst_ac_type')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                            @enderror
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>VAT Type</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                    <select name="vat_type" id="vat_type" class="common-select2" style="width: 100% !important" required>
                                                                        <option value="">Select..</option>
                                                                        @foreach ($vat_types as $item)
                                                                        <option value="{{ $item->title }}" {{ isset($masterAcc)?($masterAcc->vat_type==$item->title?"selected":""):"" }}>{{ $item->title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('vat_type')
                                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                            @enderror
                                                            </div>



                                                            <div class="col-12 d-flex justify-content-end ">
                                                                @isset($masterAcc)
                                                                <a href="{{ route('masteAccDetails') }}" class="btn btn-info mr-1">New</a>
                                                                @endisset
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
                                        placeholder="Search By A/C Code, A/C Head, Definition, VAT Type, A/C Type"
                                        data-url="{{ route('admin.masterAccSearchAjax',$id="masterAcc") }}">

                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('pdf',$id="MasterAccDetails") }}" class="btn btn-xs btn-info float-right" target="_blank">Print</a>
                        <button class="btn btn-xs btn-info float-right mr-1"
                    onclick="exportTableToCSV('MasterAccountsdetails.csv')">Export To CSV</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th>Master A/C Code</th>
                                <th>Master A/C Head</th>
                                <th>Definition</th>
                                <th>Master A/C Type</th>
                                <th>VAT Type</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody class="user-table-body">
                                @foreach ($masterDetails as $masterAcc)
                                <tr>
                                    <td>{{ $masterAcc->mst_ac_code }}</td>
                                    <td>{{ $masterAcc->mst_ac_head }}</td>
                                    <td>{{ $masterAcc->mst_definition }}</td>
                                    <td>{{ $masterAcc->mst_ac_type }}</td>
                                    <td>{{ $masterAcc->vat_type }}</td>

                                    <td style="white-space: nowrap">
                                        <a href="{{ route('masterEdit',$masterAcc) }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                        <a href="{{ route('masterDelete',$masterAcc) }}" onclick="return confirm('about to delete master account. Please, Confirm?')" class="btn btn-sm btn-danger"><i class="bx bx-trash" aria-hidden="true"></i></a>

                                    </td>
                                </tr>

                                @endforeach
                            </tbody>


                        </table>

                    </div>

                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        {{$masterDetails->links()}}
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
        $(document).ready(function() {
            $('#category').change(function() {
                // alert(1);
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('findMastedCode') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },

                        success: function(response) {
                            console.log(response);
                            $("#mst_ac_code").val(response);

                        }

                    })
                }
            });
        });
    </script>

@endpush
