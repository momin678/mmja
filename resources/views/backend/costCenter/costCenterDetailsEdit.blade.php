@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">

            <div class="tab-content bg-white">
                <div>
                    <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                        <div class="row">
                            <div class="col-md-6  mt-2 mb-2">
                                <h4>Cost Center Details</h4>
                            </div>
                                {{-- @include('alerts.alerts') --}}
                        </div>
                        <div class="row" style="padding-left: 10px; padding-right:10px;">
                            <div class="col-12">
                                
                                    @isset($costCenter)
                                        <form action="{{ route('costCentersUpdate', $costCenter) }}" method="POST">
                                            @else
                                                <form action="{{ route('costCenterPost') }}" method="POST">
                                                @endisset
                                                @csrf
                                    <div class="cardStyleChange">
                                        <div class="row">
                                            <div class="col-md-2 changeColStyle">
                                                <label>Code</label>
                                                <input type="text" id="" class="form-control inputFieldHeight" name="" value="{{ isset($costCenter) ? $costCenter->cc_code : '' }}" placeholder="Cost Center Code" disabled readonly>
                                            </div>

                                            <div class="col-md-4 changeColStyle">
                                                <label>Cost Center Name</label>
                                                <input type="text" id="cc_name" class="form-control inputFieldHeight" name="cc_name" value="{{ isset($costCenter) ? $costCenter->cc_name : '' }}" placeholder="Cost Center Name" required>
                                                    @error('cc_name')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>

                                            <div class="col-md-2 changeColStyle">
                                                <label>Activities</label>
                                                <input type="text" id="activity" class="form-control inputFieldHeight" name="activity" value="{{ isset($costCenter) ? $costCenter->activity : '' }}" placeholder="Activity" required>
                                                    @error('activity')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>

                                            <div class="col-md-4 changeColStyle">
                                                <label>Stakeholder</label>
                                                <input type="text" id="prsn_responsible" class="form-control inputFieldHeight" name="prsn_responsible" value="{{ isset($costCenter) ? $costCenter->prsn_responsible : '' }}" placeholder="Stakeholder" required>
                                                    @error('prsn_responsible')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>

                                            <div @if (@isset($costCenter)) class="changeColStyle col-md-4"
                                                @else
                                                class="changeColStyle col-md-5"
                                                @endif>
                                                <label>Branch Name</label>
                                                <select name="project_id" class="common-select2" style="width: 100% !important" id="" required >
                                                    <option value="">Select...</option>
                                                        @foreach ($projects as $item)
                                                    <option value="{{ $item->id }}"  {{ $item->id==$costCenter->project_id? "selected":"" }}>{{ $item->proj_name }}</option>
                                                        @endforeach
                                                </select>
                                                    @error('project_id')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>

                                            <div class="changeColStyle col-md-8 @isset($costCenter)changeColStyle col-md-4 @endisset mt-1">
                                                <div class="d-flex justify-content-end">
                                                    @isset($costCenter)
                                                    <a href="{{ route('costCenterDetails') }}" class="btn btn-info mr-1 formButton"><img src="{{ asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="image-fluid" width="25"> New</a>
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
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                    <hr>

                    <section class="mr-1 ml-1 mt-3">
                        <div class="mt-2">
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <form>
                                    <input type="text" name="q" class="form-control input-xs pull-right ajax-search" placeholder="Search By Code, Name" data-url="{{ route('admin.masterAccSearchAjax', $id = 'costCenter') }}">
                                    </form>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('pdf', $id = 'costCenter') }}" class="btn btn-xs mPrint formButton" target="_blank" title="Print"><img  src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" alt="" srcset="" class="img-fluid" width="30"> Print</a>
                                    <a href="#" class="btn btn-xs mExcelButton formButton" onclick="exportTableToCSV('costcenterdetails.csv')" title="Export to Excel"><img  src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" alt="" srcset="" class="img-fluid" width="30">Export To Excel</a href="#">
                                </div>
                            </div>
                            <div class="cardStyleChange">
                                <table class="table mb-0 table-sm table-hover">
                                    <thead  class="thead-light">
                                        <tr style="height: 50px;">
                                            <th>Code</th>
                                            <th>Cost Center Name</th>
                                            <th>Activity</th>
                                            <th>Stakeholder</th>
                                            <th>Branch Name</th>
                                            <th style="text-align:center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody  class="user-table-body">
                                        @foreach ($costCenterDetails as $cCenter)
                                        <tr class="trFontSize">
                                            <td>{{ $cCenter->cc_code }}</td>
                                            <td>{{ $cCenter->cc_name }}</td>
                                            <td>{{ $cCenter->activity }}</td>
                                            <td>{{ $cCenter->prsn_responsible }}</td>
                                            <td>{{ isset($cCenter->project)? $cCenter->project->proj_name :"" }}</td>
        
                                            <td style="padding-bottom: 11px; padding-top: 0px">
                                               <div class="d-flex justify-content-end">
                                                <a href="{{ route('costCenEdit', $cCenter) }}" class="btn" style="height: 30px; width: 30px;" title="Eidt"><img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;"></a>
                                                <a href="{{ route('costCenDelete',$cCenter) }}" onclick="return confirm('about to delete master account. Please, Confirm?')"  class="btn" style="height: 30px; width: 30px;" title="Delete"><img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;"></a>
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
                            {{ $costCenterDetails->links() }}
                            </div>
                        </div>
                    </section>
                   
                </div>
               
            </div>
        </div>
    </div>
</div>

@endsection


@push('js')
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
