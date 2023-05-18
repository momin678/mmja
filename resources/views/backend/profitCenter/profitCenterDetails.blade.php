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
            <div class="content-body">
                
            <div class="tab-content bg-white">
                <div>
                    <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                        <div class="row">
                            <div class="col-md-6  mt-2 mb-2">
                                <h4>Profit Center Details</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 profit-center-form">
                              
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
                                                <input type="text" id="" class="form-control inputFieldHeight" name="" value="{{ isset($pc) ? $pc : '' }}" placeholder="Profit Center Code" disabled readonly>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Profit Center Name</label>
                                                <input type="text" id="pc_name" class="form-control inputFieldHeight" name="pc_name" value="{{ isset($profitCenter) ? $profitCenter->pc_name : '' }}" placeholder="Profit Center Name" disabled readonly>
                                                    @error('pc_name')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                                     @enderror
                                            </div>

                                            <div class="col-md-2">
                                                <label>Activities</label>
                                                <input type="text" id="activity" class="form-control inputFieldHeight" name="activity" value="{{ isset($profitCenter) ? $profitCenter->activity : '' }}" placeholder="Activity" disabled readonly>
                                                    @error('activity')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label>Person responsible</label>
                                                <input type="text" id="prsn_responsible" class="form-control inputFieldHeight" name="prsn_responsible" value="{{ isset($profitCenter) ? $profitCenter->prsn_responsible : '' }}" placeholder="Person responsible" disabled readonly>
                                                    @error('prsn_responsible')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>
                                            
                                                <div class="col-12 d-flex justify-content-end mt-1">
                                                    <button class="btn btn-info profit-center-form-btn mr-1 formButton" data_target="{{ route('profitCenterForm') }}" id="profitCenterButton"><img src="{{ asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="image-fluid" width="25">New</button>
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
                                    <input type="text" name="q" class="form-control inputFieldHeight pull-right ajax-search"
                                    placeholder="Search By Code, Name"
                                    data-url="{{ route('admin.masterAccSearchAjax', $id = 'profitCenter') }}">
                                    </form>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="#" class="btn btn-xs mPrint formButton" onclick="window.print()" title="Print"><img  src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" alt="" srcset="" class="img-fluid" width="30"> Print</a>
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
                                                @if ($pCenter->projectCount()==0)
                                                <a href="{{ route('profitCenDelete', $pCenter) }}" onclick="return confirm('about to delete master account. Please, Confirm?')"  class="btn" style="height: 30px; width: 30px;" title="Delete"><img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;"></a>
                                                @else
                                                <a href="#" onclick="return alert('Cannot Delete! This belongs to some Project/Branch')"  class="btn" style="height: 30px; width: 30px;" title="Delete"><img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;"></a> 
                                                @endif
                                                
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
<style>
    <style>
       #customers {
           font-family: Arial, Helvetica, sans-serif;
           border-collapse: collapse;
           width: 100%;
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
<section class="print-layout">

   @include('layouts.backend.partial.modal-header-info')
   <div class="container">
        <div class="row">
            <div class="col-md-12">
            <section id="widgets-Statistics">
                <div class="row">
                    <h4>Profit Center</h4>
                </div>
                <div class="row mt-2">
                    <table id="customers" class="table mb-0 table-sm table-hover" style="width: 100%; border: none;">
                        <tr style="height: 50px;">
                            <th>Profit Center Code</th>
                            <th>Profit Center Name</th>
                            <th>Activity</th>
                            <th>Person Resposible</th>
                        </tr>
                        @foreach ($profitDetailsPrint as $pCenter)
                        <tr style="font-size: 12px;">
                            <td>{{ $pCenter->pc_code }}</td>
                            <td>{{ $pCenter->pc_name }}</td>
                            <td>{{ $pCenter->activity }}</td>
                            <td>{{ $pCenter->prsn_responsible }}</td>

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