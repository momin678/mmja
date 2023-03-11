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
                        <h4>Party Form</h4>
                        <hr>
                        {{-- @include('alerts.alerts') --}}
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Party Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="party-info-form">
                                        @isset($costCenter)
                                            <form action="{{ route('partyInfoUpdate', $costCenter) }}" method="POST">
                                            @else
                                                <form action="{{ route('partyInfoPost') }}" method="POST">
                                                @endisset
                                                @csrf
                                                <div class="row match-height">
                                                    <div class="col-md-6">
                                                        <div class="form-body">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label>Party Code</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="text" id=""
                                                                        class="form-control" name=""
                                                                        value="{{ $cc }}"
                                                                        placeholder="Party Code" disabled readonly>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>Party Name</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="text" id="pi_name"
                                                                        class="form-control" name="pi_name"
                                                                        value="{{ isset($costCenter) ? $costCenter->pi_name : '' }}"
                                                                        placeholder="Party Name" required>


                                                                    @error('pi_name')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Party Type</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <select name="pi_type" class="common-select2" style="width: 100% !important"
                                                                        id="" required>
                                                                        <option value="">Select...</option>
                                                                        @foreach ($costTypes as $item)
                                                                            <option value="{{ $item->title }}"
                                                                                {{ isset($costCenter) ? ($costCenter->pi_type == $item->title ? 'selected' : '') : '' }}>
                                                                                {{ $item->title }}</option>
                                                                        @endforeach
                                                                    </select>

                                                                    @error('pi_type')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>


                                                                <div class="col-md-4">
                                                                    <label>TRN No</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="text" id="trn_no"
                                                                        class="form-control" name="trn_no"
                                                                        value="{{ isset($costCenter) ? $costCenter->trn_no : '' }}"
                                                                        placeholder="TRN Number" >


                                                                    @error('trn_no')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Address</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="text" id="address"
                                                                        class="form-control" name="address"
                                                                        value="{{ isset($costCenter) ? $costCenter->address : '' }}"
                                                                        placeholder="Address">


                                                                    @error('address')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
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
                                                                    <input type="text" id="con_person"
                                                                        class="form-control" name="con_person"
                                                                        value="{{ isset($costCenter) ? $costCenter->con_person : '' }}"
                                                                        placeholder="Contact Person">


                                                                    @error('con_person')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Mobile Phone No</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="number" id="con_no"
                                                                        class="form-control" name="con_no"
                                                                        value="{{ isset($costCenter) ? $costCenter->con_no : '' }}"
                                                                        placeholder="Mobile No">


                                                                    @error('con_no')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Phone No</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="number" id="phone_no"
                                                                        class="form-control" name="phone_no"
                                                                        value="{{ isset($costCenter) ? $costCenter->phone_no : '' }}"
                                                                        placeholder="Phone No">


                                                                    @error('phone_no')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Email</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="text" id="email"
                                                                        class="form-control" name="email"
                                                                        value="{{ isset($costCenter) ? $costCenter->email : '' }}"
                                                                        placeholder="Email">


                                                                    @error('email')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-12 d-flex justify-content-end ">
                                                                    <button class="btn btn-info project-form-btn mr-1"
                                                                        data_target="{{ route('projectForm') }}"
                                                                        disabled>New</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary mr-1">Submit</button>
                                                                    <button type="reset"
                                                                        class="btn btn-light-secondary">Reset</button>

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
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form>
                                <input type="text" name="q" class="form-control input-xs pull-right ajax-search"
                                    placeholder="Search By Code, Party Name, TRN Number"
                                    data-url="{{ route('admin.masterAccSearchAjax', $id = 'partyCenter') }}">

                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('pdf', $id = 'partyCenter') }}" class="btn btn-xs btn-info float-right"
                                target="_blank">Print</a>
                            <button class="btn btn-xs btn-info float-right mr-1"
                                onclick="exportTableToCSV('PartyInfos.csv')">Export To CSV</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Party Code</th>
                                        <th>Party Name</th>
                                        <th>Type</th>
                                        <th>TRN Number</th>
                                        <th>Contact Person</th>
                                        {{-- <th>Contact Number</th> --}}
                                        {{-- <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Email</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody class="user-table-body">
                                    @foreach ($partyInfos as $pInfo)
                                        <tr>
                                            <td>{{ $pInfo->pi_code }}</td>
                                            <td>{{ $pInfo->pi_name }}</td>
                                            <td>{{ $pInfo->pi_type }}</td>
                                            <td>{{ $pInfo->trn_no }}</td>
                                            <td>{{ $pInfo->con_person }}</td>
                                            {{-- <td>{{ $pInfo->con_no }}</td> --}}
                                            {{-- <td>{{ $pInfo->phone_no }}</td>
                                            <td>{{ $pInfo->address }}</td>
                                            <td>{{ $pInfo->email }}</td> --}}

                                            <td style="white-space: nowrap">
                                                <a href="{{ route('partyView', $pInfo) }}"
                                                class="btn btn-sm btn-warning" ><i
                                                    class="bx bx-hide "></i></a>
                                                <a href="{{ route('partyInfoEdit', $pInfo) }}"
                                                    class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                                <a href="{{ route('partyInfoDelete', $pInfo) }}"
                                                    onclick="return confirm('about to delete Party. Please, Confirm?')"
                                                    class="btn btn-sm btn-danger"><i class="bx bx-trash"
                                                        aria-hidden="true"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>


                            </table>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 text-right">
                            {{ $partyInfos->links() }}
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


    <script>
        $(document).ready(function() {

            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();
            $(document).on("click", ".party-info-form-btn", function(e) {
                e.preventDefault();
                var that = $(this);
                var urls = that.attr("data_target");
                // alert(urls);
                delay(function() {
                    $.ajax({
                        url: urls,
                        type: 'GET',
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            //   alert('ok');
                            console.log(response);
                            $(".party-info-form").empty().append(response.page);
                        },
                        error: function() {
                            //   alert('no');
                        }
                    });
                }, 999);
            });
        });
    </script>
@endpush
