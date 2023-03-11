@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
               
            <div class="tab-content bg-white">
                <div>
                    <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                        <div class="row">
                            <div class="col-md-6  mt-2 mb-2">
                                <h4>Profit Center Details</h4>
                            </div>
                                {{-- @include('alerts.alerts') --}}
                        </div>
                        <div class="row">
                            <div class="col-12">
                              
                                    @isset($profitCenter)
                                        <form action="{{ route('profitCentersUpdate', $profitCenter) }}" method="POST">
                                            @else
                                        <form action="{{ route('profitCenterPost') }}" method="POST">
                                            @endisset
                                            @csrf
                                    <div class="cardStyleChange">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Code</label>
                                                <input type="text" id="" class="form-control inputFieldHeight" name="" value="{{ isset($profitCenter) ? $profitCenter->pc_code : '' }}" placeholder="Profit Center Code" disabled readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Profit Center</label>
                                                <input type="text" id="pc_name" class="form-control inputFieldHeight" name="pc_name" value="{{ isset($profitCenter) ? $profitCenter->pc_name : '' }}" placeholder="Profit Center Name" required>
                                                    @error('pc_name')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>

                                            <div class="col-md-2">
                                                <label>Activities</label>
                                                <input type="text" id="activity" class="form-control inputFieldHeight" name="activity" value="{{ isset($profitCenter) ? $profitCenter->activity : '' }}" placeholder="Activity" required>
                                                    @error('activity')
                                                <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                                    @enderror 
                                            </div>

                                            <div class="col-md-4">
                                                <label>Person responsible</label>
                                                <input type="text" id="prsn_responsible" class="form-control inputFieldHeight" name="prsn_responsible" value="{{ isset($profitCenter) ? $profitCenter->prsn_responsible : '' }}" placeholder="Person responsible" required>
                                                    @error('prsn_responsible')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>
                                            
                                                <div class="col-12 d-flex justify-content-end mt-1">
                                                    {{-- <button class="btn btn-info profit-center-form-btn mr-1 formButton" data_target="{{ route('profitCenterForm') }}" disabled><img src="{{ asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="image-fluid" width="25">New</button> --}}
                                                    @isset($profitCenter)
                                                    <a href="{{ route('profitCenterDetails') }}" class="btn btn-info mr-1 formButton "><img src="{{ asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="image-fluid" width="25"> New</a>
                                                    @endisset
                                                    <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                            </div>
                                                            <div><span> Save</span></div>
                                                        </div>
                                                    </button>
                                                    <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset" disabled>
                                                        <div class="d-flex">
                                                            <div class="formRefreshIcon">
                                                                <img  src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                            </div>
                                                            <div><span> Reset</span></div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                    <hr>

                    <section class="mr-1 ml-1">
                        <div class="mt-2">
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <form>
                                    <input type="text" name="q" class="form-control inputFieldHeight pull-right ajax-search" placeholder="Search By Code, Name" data-url="{{ route('admin.masterAccSearchAjax', $id = 'profitCenter') }}">
                                    </form>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('pdf', $id = 'profitCenter') }}" class="btn btn-xs mPrint formButton" target="_blank" title="Print"><img  src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" alt="" srcset="" class="img-fluid" width="30"> Print</a>
                                    <a href="#" class="btn btn-xs mExcelButton formButton" onclick="exportTableToCSV('profitcenterdetails.csv')" title="Export to Excel"><img  src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" alt="" srcset="" class="img-fluid" width="30">Export To Excel</a href="#">
                                </div>
                            </div>
                            <div class="cardStyleChange">
                                <table class="table mb-0 table-sm table-hover">
                                    <thead  class="thead-light">
                                        <tr style="height: 50px;">
                                            <th>Profit Center Code</th>
                                            <th>Profit Center Name</th>
                                            <th>Activity</th>
                                            <th>Person Resposible</th>
                                            <th style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="user-table-body">
                                        @foreach ($profitDetails as $pCenter)
                                        <tr class="trFontSize">
                                            <td>{{ $pCenter->pc_code }}</td>
                                            <td>{{ $pCenter->pc_name }}</td>
                                            <td>{{ $pCenter->activity }}</td>
                                            <td>{{ $pCenter->prsn_responsible }}</td>
        
                                            <td style="padding-bottom: 11px; padding-top: 0px">
                                               <div class="d-flex justify-content-end">
                                                <a href="{{ route('profitCenEdit', $pCenter) }}" class="btn" style="height: 30px; width: 30px;" title="Eidt"><img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;"></a>
                                                <a href="{{ route('profitCenDelete', $pCenter) }}" onclick="return confirm('about to delete master account. Please, Confirm?')"  class="btn" style="height: 30px; width: 30px;" title="Delete"><img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;"></a>
                                               </div>
        
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                {{ $profitDetails->links() }}
                            </div>
                        </div>
                    </section>
                   
                </div>
               
            </div>

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
            $(document).on("click", ".profit-center-form-btn", function(e) {
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
                            $(".profit-center-form").empty().append(response.page);
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
