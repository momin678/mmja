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

            <div class="tab-content bg-white">
            <div>
                <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                    <div class="row">
                        <div class="col-md-6  mt-2 mb-2">
                            <h4>Party Details </h4>
                        </div>
                            {{-- @include('alerts.alerts') --}}
                    </div>
                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                        <div class="col-12">
                            @isset($costCenter)
                                <form action="{{ route('partyInfoUpdate', $costCenter) }}" method="POST">
                                @else
                                <form action="{{ route('partyInfoPost') }}" method="POST">
                                    @endisset
                                    @csrf
                                <div class="cardStyleChange">
                                    <div class="row">
                                        <div class="col-md-2 changeColStyle">
                                            <label>Party Code</label>
                                            <input type="text" id=""class="form-control inputFieldHeight" name="" value="{{ $cc }}" placeholder="Party Code" disabled readonly>
                                        </div>

                                        <div class="col-md-3 changeColStyle">
                                            <label>Party Name</label>
                                            <input type="text" id="pi_name" class="form-control inputFieldHeight" name="pi_name" value="{{ isset($costCenter) ? $costCenter->pi_name : '' }}" placeholder="Party Name" required>
                                                @error('pi_name')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                        </div>

                                        <div class="col-md-2 changeColStyle">
                                            <label>Party Type</label>
                                            <select name="pi_type" class="common-select2" style="width: 100% !important" id="" required>
                                                <option value="">Select...</option>
                                                    @foreach ($costTypes as $item)
                                                <option value="{{ $item->title }}" {{ isset($costCenter) ? ($costCenter->pi_type == $item->title ? 'selected' : '') : '' }}> {{ $item->title }}</option>
                                                    @endforeach
                                            </select>
                                                    @error('pi_type')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                    @enderror
                                        </div>

                                        <div class="col-md-2 changeColStyle">
                                            <label>TRN No</label>
                                            <input type="text" id="trn_no" class="form-control inputFieldHeight" name="trn_no" value="{{ isset($costCenter) ? $costCenter->trn_no : '' }}" placeholder="TRN Number" >
                                                @error('trn_no')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                        </div>

                                        <div class="col-md-3 changeColStyle">
                                            <label>Address</label>
                                            <input type="text" id="address" class="form-control inputFieldHeight" name="address" value="{{ isset($costCenter) ? $costCenter->address : '' }}" placeholder="Address">
                                                @error('address')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                        </div>
                                    
                                        <div class="col-md-2 changeColStyle">
                                            <label>Contact Person</label>
                                            <input type="text" id="con_person" class="form-control inputFieldHeight" name="con_person" value="{{ isset($costCenter) ? $costCenter->con_person : '' }}" placeholder="Contact Person">
                                                @error('con_person')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                        </div>

                                        <div class="col-md-3 changeColStyle">
                                            <label>Mobile Phone No</label>
                                            <input type="number" id="con_no" class="form-control inputFieldHeight" name="con_no" value="{{ isset($costCenter) ? $costCenter->con_no : '' }}" placeholder="Mobile No">
                                                @error('con_no')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                        </div>

                                        <div class="col-md-3 changeColStyle">
                                            <label>Phone No</label>
                                            <input type="number" id="phone_no" class="form-control inputFieldHeight" name="phone_no" value="{{ isset($costCenter) ? $costCenter->phone_no : '' }}" placeholder="Phone No">
                                                @error('phone_no')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                        </div>

                                        <div class="col-md-4 changeColStyle">
                                            <label>Email</label>
                                            <input type="text" id="email" class="form-control inputFieldHeight" name="email" value="{{ isset($costCenter) ? $costCenter->email : '' }}" placeholder="Email">
                                                @error('email')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                        </div>
                                    
                                            <div class="col-12 d-flex justify-content-end changeColStyle">
                                                {{-- <button type="button" class="btn mr-1 formButton mAddNewIcon" title="Add New">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/add-new-icon.png')}}" alt="" srcset="" width="25">
                                                        </div>
                                                        <div><span>Add</span></div>
                                                    </div>
                                                </button> --}}
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
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <hr>

                <section class="mr-1 ml-1">
                    <div class="mt-2">
                        <div class="row">
                            <div class="col-md-6">
                            <form>
                            <input type="text" name="q" class="form-control inputFieldHeight input-xs pull-right ajax-search" placeholder="Search By Code, Party Name, TRN Number"data-url="{{ route('admin.masterAccSearchAjax', $id = 'partyCenter') }}">
                            </form>
                        </div>
                            <div class="col-md-6 text-right">
                                <a href="#" onclick="partyListPrint()" class="btn btn-xs mPrint formButton" title="Print"><img  src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" alt="" srcset="" class="img-fluid" width="30"> Print</a>
                                <a href="#" class="btn btn-xs mExcelButton formButton" onclick="exportTableToCSV('PartyInfos.csv')" title="Export to Excel"><img  src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" alt="" srcset="" class="img-fluid" width="30">Export To Excel</a href="#">
                            </div>
                        </div>
                        <div class="cardStyleChange">
                            <table class="table mb-0 table-sm table-hover">
                                <thead  class="thead-light">
                                    <tr style="height: 50px;">
                                        <th>Party Code</th>
                                        <th>Party Name</th>
                                        <th>Type</th>
                                        <th>TRN Number</th>
                                        <th>Contact Person</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($partyInfos as $pInfo)
                                    <tr class="trFontSize">
                                        <td>{{ $pInfo->pi_code }}</td>
                                        <td>{{ $pInfo->pi_name }}</td>
                                        <td>{{ $pInfo->pi_type }}</td>
                                        <td>{{ $pInfo->trn_no }}</td>
                                        <td>{{ $pInfo->con_person }}</td>
                                        <td style="padding-bottom: 11px; padding-top: 0px">
                                            <div class="d-flex justify-content-end">
                                                <a href="#" class="btn partyCenterView" style="height: 30px; width: 30px;" title="Preview" id="{{$pInfo->id}}"><img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;"></a>
                                                <a href="{{ route('partyInfoEdit', $pInfo) }}}" class="btn" style="height: 30px; width: 30px;" title="Eidt"><img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;"></a>
                                                <a href="{{ route('partyInfoDelete', $pInfo) }}" onclick="return confirm('about to delete master account. Please, Confirm?')"  class="btn" style="height: 30px; width: 30px;" title="Delete"><img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;"></a>
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
                        {{ $partyInfos->links() }}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="partyCenterPreviewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="partyCenterView">
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>
        $(document).on("click", ".partyCenterView", function(e) { 
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{URL('party-center-preview')}}",
                type: "post",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){				
                    document.getElementById("partyCenterView").innerHTML = response;
                    $('#partyCenterPreviewModal').modal('show')
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
    <script>
        function pagePrint(){
            document.getElementById("mPrintHidden").style.display = "none";
            window.print();
        }
        function partyListPrint(){
            // document.getElementById("mPrintHidden").style.display = "block";
            window.print();
        }
    </script>
@endpush
<style>
     <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        #customers td, #customers th {
            border-bottom: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}
        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
            text-transform: uppercase;

        }
        .graph-7{background: url(../img/graphs/graph-7.jpg) no-repeat;}
        .graph-image img{display: none;}
        @media screen {
        div.divFooter {
            display: none;
        }
        }
        @media print {
            div.divFooter {
                position: fixed;
                bottom: 0;
            }
        }
        th{
            text-transform: uppercase;
        }
    </style>
<style>
    .print-layout{
        display: none;
    }
    @media print{
        .print-layout{
            display: block;
        }
    }
</style>
<section class="print-layout" id="mPrintHidden">

    @include('layouts.backend.partial.modal-header-info')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
            <section id="widgets-Statistics">
                <div class="row">
                    <div class="col-12 mt-1 mb-2">
                        <h4>Party Info Details</h4>
                        <hr>
                    </div>
                </div>

                    <div class="row ">
                            <table id="customers" class="table-sm">
                                <tr>
                                    <th>Party Code</th>
                                    <th>Party Name</th>
                                    <th>Type</th>
                                    <th>TRN Number</th>
                                    <th>Contact Person</th>
                                    <th>Contact Number</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                </tr>

                                @foreach ($partyInfosPDF as $pInfo)
                                <tr style="font-size: 12px;">
                                    <td>{{ $pInfo->pi_code }}</td>
                                    <td>{{ $pInfo->pi_name }}</td>
                                    <td>{{ $pInfo->pi_type }}</td>
                                    <td>{{ $pInfo->trn_no }}</td>
                                    <td>{{ $pInfo->con_person }}</td>
                                    <td>{{ $pInfo->con_no }}</td>
                                    <td>{{ $pInfo->phone_no }}</td>
                                    <td>{{ $pInfo->address }}</td>
                                    <td>{{ $pInfo->email }}</td>

                                </tr>
                            @endforeach



                            </table>
                    </div>
            </section>
            </div>
        </div>
    </div>



    @include('layouts.backend.partial.modal-footer-info')
</section>