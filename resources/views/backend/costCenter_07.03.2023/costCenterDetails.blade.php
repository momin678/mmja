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
                            <h4>Cost Center Form</h4>
                            <hr>
                            {{-- @include('alerts.alerts') --}}
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Cost Center Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="cost-center-form">
                                        @isset($costCenter)
                                        <form action="{{ route('costCentersUpdate', $costCenter) }}" method="POST">
                                            @else
                                                <form action="{{ route('costCenterPost') }}" method="POST">
                                                @endisset
                                                @csrf
                                                <div class="row match-height">



                                                    <div class="col-md-6">

                                                        <div class="form-body">
                                                            <div class="row">

                                                                <div class="col-md-4">
                                                                    <label>Code</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="text" id="" class="form-control" name="" value="{{ isset($cc) ? $cc : '' }}"
                                                                        placeholder="Cost Center Code" disabled readonly>

                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Cost Center Name</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="text" id="cc_name" class="form-control" name="cc_name"
                                                                        value="{{ isset($costCenter) ? $costCenter->cc_name : '' }}"
                                                                        placeholder="Cost Center Name" required>


                                                                    @error('cc_name')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Activities</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="text" id="activity" class="form-control" name="activity"
                                                                        value="{{ isset($costCenter) ? $costCenter->activity : '' }}" placeholder="Activity"
                                                                        required>


                                                                    @error('activity')
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
                                                                    <label>Person responsible</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="text" id="prsn_responsible" class="form-control" name="prsn_responsible"
                                                                        value="{{ isset($costCenter) ? $costCenter->prsn_responsible : '' }}"
                                                                        placeholder="Person responsible" required>


                                                                    @error('prsn_responsible')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Branch Name</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <select name="project_id" class="common-select2" style="width: 100% !important" id="" required >
                                                                        <option value="">Select...</option>
                                                                        @foreach ($projects as $item)
                                                                         <option value="{{ $item->id }}">{{ $item->proj_name }}</option>
                                                                        @endforeach
                                                                    </select>

                                                                    @error('project_id')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-12 d-flex justify-content-end ">
                                                                    <button class="btn btn-info profit-center-form-btn mr-1"
                                                                    data_target="{{ route('profitCenterForm') }}" disabled>New</button>
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
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form>
                                <input type="text" name="q" class="form-control input-xs pull-right ajax-search"
                                    placeholder="Search By Code, Name"
                                    data-url="{{ route('admin.masterAccSearchAjax', $id = 'costCenter') }}">

                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('pdf', $id = 'costCenter') }}" class="btn btn-xs btn-info float-right"
                                target="_blank">Print</a>
                            <button class="btn btn-xs btn-info float-right mr-1"
                                onclick="exportTableToCSV('costcenterdetails.csv')">Export To CSV</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Cost Center Code</th>
                                        <th>Cost Center Name</th>
                                        <th>Activity</th>
                                        <th>Person Resposible</th>
                                        <th>Branch Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody class="user-table-body">
                                    @foreach ($costCenterDetails as $cCenter)
                                        <tr>
                                            <td>{{ $cCenter->cc_code }}</td>
                                            <td>{{ $cCenter->cc_name }}</td>
                                            <td>{{ $cCenter->activity }}</td>
                                            <td>{{ $cCenter->prsn_responsible }}</td>
                                            <td>{{ isset($cCenter->project)? $cCenter->project->proj_name :"" }}</td>


                                            <td style="white-space: nowrap">
                                                <a href="{{ route('costCenEdit', $cCenter) }}"
                                                    class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
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
                            {{ $costCenterDetails->links() }}
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
            $(document).on("click", ".cost-center-form-btn", function(e) {
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
                            $(".cost-center-form").empty().append(response.page);
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
