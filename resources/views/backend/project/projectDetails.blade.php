@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content print-hidden">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="card cardStyleChange">
                <section id="widgets-Statistics" class="mr-1 ml-1">
                    <div class="row">
                        <div class="col-md-6 mt-2 mb-2">
                            <h4>Branch Details</h4>
                        </div>
                    </div>
                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                        <div class="col-12">
                            <form action="{{ route('projectDetailsPost') }}" method="POST">
                                @csrf
                                <div class="row match-height">
                                    <div class="col-md-3 changeColStyle">
                                        <label>Branch No</label>
                                        <input type="text" id="" class="form-control inputFieldHeight" name="" placeholder="Project No" disabled readonly>
                                        @error('proj_no')
                                            <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 changeColStyle">
                                        <label>Branch Name</label>
                                        <input type="text" id="proj_name" class="form-control inputFieldHeight" name="proj_name" placeholder="Project Name" required>
                                        @error('proj_name')
                                            <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 changeColStyle">
                                        <label>Type</label>
                                        <select name="proj_type" class="common-select2" style="width: 100% !important" required>
                                            <option value="">Select...</option>
                                            @foreach ($projectTypes as $item)
                                                <option value="{{ $item->title }}"> {{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('proj_type')
                                            <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 changeColStyle">
                                        <label>Manager</label>
                                        <input type="text" id="owner_name" class="form-control inputFieldHeight" name="owner_name" placeholder="Manager" required>
                                            @error('owner_name')
                                                <div class="btn btn-sm btn-danger">{{ $message }}  </div>
                                            @enderror
                                    </div>
                                    <div class="col-md-3 changeColStyle">
                                        <label>Site Address</label>
                                        <input type="text" id="address" class="form-control inputFieldHeight" name="address" placeholder="Site Address" required>
                                        @error('address')
                                            <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 changeColStyle">
                                        <label>Office Phone No</label>
                                        <input type="text" id="cons_agent" class="form-control inputFieldHeight" name="cons_agent" placeholder="Office Phone No" required>
                                        @error('cons_agent')
                                            <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 changeColStyle">
                                        <label>Mobile Phone Number</label>
                                        <input type="number" id="cont_no" class="form-control inputFieldHeight" name="cont_no" placeholder="Mobile" required>
                                        @error('cont_no')
                                            <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 changeColStyle">
                                        <label>Trade License Issue Date</label>
                                        <input type="date" id="ord_date" class="form-control inputFieldHeight" name="ord_date" placeholder="Work Order Date" required>
                                        @error('ord_date')
                                            <div class="btn btn-sm btn-danger">{{ $message }}  </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 changeColStyle">
                                        <label>License Expiery</label>
                                        <input type="date" id="hnd_over_date" class="form-control inputFieldHeight" name="hnd_over_date" placeholder="Work Order Date" required>
                                        @error('hnd_over_date')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 changeColStyle">
                                        <label>Profit Center</label>
                                        <select name="profit_pc_code" class="common-select2" style="width: 100% !important" id="" required>
                                            <option value="">Select...</option>
                                            @foreach ($profit_centers as $item)
                                            <option value="{{ $item->pc_code }}">{{ $item->pc_name }} </option>
                                            @endforeach
                                        </select>
                                        @error('profit_pc_code')
                                            <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 d-flex justify-content-end changeColStyle mb-1 mt-2">
                                        <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                </div>
                                                <div><span> Save</span></div>
                                            </div>
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset">
                                            <div class="d-flex">
                                                <div class="formRefreshIcon">
                                                    <img  src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                </div>
                                                <div><span> Reset</span></div>
                                            </div>
                                        </button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <hr>
                <section class="mr-1 ml-1">
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <form>
                                    <input type="text" name="q" class="form-control inputFieldHeight input-xs pull-right ajax-search" placeholder="Search By Branch No, Branch Name, Mobile Number" data-url="{{ route('admin.masterAccSearchAjax', $id = 'projectDetails') }}">
                                </form>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="#" class="btn btn-xs mPrint formButton project_list_print" title="Print" target="_blank"><img  src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" alt="" srcset="" class="img-fluid" width="30"> Print</a>
                                <a href="#" class="btn btn-xs mExcelButton formButton" onclick="exportTableToCSV('PartyInfos.csv')" title="Export to Excel"><img  src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" alt="" srcset="" class="img-fluid" width="30">Export To Excel</a href="#">
                            </div>
                        </div>
                    </div>
                    <div class="cardStyleChange">
                        <table class="table table-sm table-hover">
                            <thead class="thead-light">
                                <tr style="height: 50px;">
                                    <th>Branch No</th>
                                    <th>Branch Name</th>
                                    <th>Branch Type</th>
                                    <th>Manager</th>
                                    <th>Site Address</th>
                                    <th>Office Phone No</th>
                                    <th>Mobile Number</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
    
                            <tbody class="user-table-body">
                                @foreach ($projDetails as $proj)
                                    <tr class="trFontSize">
                                        <td>{{ $proj->proj_no }}</td>
                                        <td>{{ $proj->proj_name }}</td>
                                        <td>{{ $proj->proj_type }}</td>
                                        <td>{{ $proj->owner_name }}</td>
                                        <td>{{ $proj->address }}</td>
                                        <td>{{ $proj->cons_agent }}</td>
                                        <td>{{ $proj->cont_no }}</td>
                                        <td style="padding-bottom: 11px; padding-top: 0px">
                                            <div class="d-flex justify-content-end">
                                                <a href="#" class="btn projectView" style="height: 30px; width: 30px;" title="Preview" id="{{$proj->id}}">
                                                    <img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                </a>
                                                <a href="{{ route('projectEdit', $proj) }}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                                                    <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                                </a>
                                                
                                                @if ($proj->journalEntryCount()==0 && $proj->tempJournal()==0 && $proj->costCenterCount()==0)
                                                <a href="{{ route('projectDelete', $proj) }}" onclick="return confirm('about to delete project. Please, Confirm?')" class="btn" style="height: 30px; width: 30px;" title="Delete">
                                                    <img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;">
                                                </a>
                                                @else
                                                <a href="#" onclick="return alert('Cann\'t delete! This branch has transaction!')"  class="btn" style="height: 30px; width: 30px;" title="Delete">
                                                    <img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;">
                                                </a>
                                                @endif
                                                
                                            </div>
                                         </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-12 text-right">
                        {{ $projDetails->links() }}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    
    <div class="modal fade" id="projectViewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="projectViewDetails">
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="projectListPrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="projectListPrint">

            </div>
          </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>
        function printFunction(){
            window.print();
        }
        $(document).on("click", ".projectView", function(e) { 
            e.preventDefault();
            
            var id= $(this).attr('id');
            //alert(id);
            $.ajax({
                url: "{{URL('projectView')}}",
                method: "POST",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){				
                    document.getElementById("projectViewDetails").innerHTML = response;
                    $('#projectViewModal').modal('show');
                }
            });
        });
        $(document).on("click", ".project_list_print", function(e) { 
            e.preventDefault();
            $.ajax({
                url: "{{URL('project-list-print')}}",
                method: "get",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:'projDetails',
                },
                success: function(response){				
                    document.getElementById("projectListPrint").innerHTML = response;
                    $('#projectListPrintModal').modal('show');
                    setTimeout(printFunction, 500);
                }
            });
        });
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
                    $(document).on("click", ".project-form-btn", function(e) {
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
                                    $(".project-form").empty().append(response.page);
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
