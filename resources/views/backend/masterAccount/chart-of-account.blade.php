@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

@endpush
@section('content')
@include('layouts.backend.partial.style')
<style>
    .accordion .pluseMinuseIcon.collapsed::before{
        content: "\f067";;
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .accordion .pluseMinuseIcon::before {
        font-family: 'FontAwesome';  
        content: "\f068";
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .rowStyle{
        cursor: pointer;
        border-left: dotted;
        padding: 3px;
        margin-bottom: 2px;
    }
    .findMasterAcc{
        cursor: pointer;
    }
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route('new-chart-of-account')}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/master-account.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Master Account</div>
                </a>
                <a href="{{route('new-account-head')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/account-heads.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Account Head</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div id="masterAccount" class="tab-pane active">
                    <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                        <div class="row">
                            <div class="col-md-6  mt-2">
                                <h4>Master Account Details</h4>
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
                                    <div class="cardStyleChange">
                                        <div class="row">
                                            <div class="col-md-3 mt-1">
                                                <label for="">Master Account Details</label>
                                                    <select name="category" class="common-select2 inputFieldHeight" style="width: 100% !important" id="category" {{ isset($masterAcc)?'disabled readonly':'' }} >
                                                        <option value="">Select Category...</option>
                                                        @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}" >{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <label>Master A/C Code</label>
                                                <input type="text" id="mst_ac_code" class="form-control inputFieldHeight" name="mst_ac_code" value="{{ isset($masterAcc)?$masterAcc->mst_ac_code:"" }}" placeholder="Master A/C Code" disabled>
                                                @error('mst_ac_code')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <label>Definition</label>
                                                <select name="mst_definition" class="common-select2 inputFieldHeight" style="width: 100% !important" id="" required>
                                                    <option value="">Select...</option>
                                                    @foreach ($mst_definitions as $item)
                                                    <option value="{{ $item->title }}" {{ isset($masterAcc)?($masterAcc->mst_definition==$item->title?"selected":""):"" }}>{{ $item->title }}</option>

                                                    @endforeach
                                                </select>
                                                @error('mst_definition')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <label>Master A/C Type</label>
                                                <select name="mst_ac_type" class="common-select2 inputFieldHeight" style="width: 100% !important" id="mst_ac_type" {{ isset($masterAcc)? "disabled readonly":"required"}} >
                                                    <option value="">Select...</option>
                                                    @foreach ($mstAccType as $item)
                                                    <option value="{{ $item->title }}" {{ isset($masterAcc)?($masterAcc->mst_ac_type==$item->title?"selected":""):"" }}>{{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('mst_ac_type')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div @if (@isset($masterAcc))
                                            class="col-md-4 mt-1"
                                            @else
                                            class="col-md-5 mt-1"
                                            @endif>
                                                <label>Master A/C Head</label>
                                                <input type="text" id="mst_ac_head" class="form-control inputFieldHeight" name="mst_ac_head" value="{{ isset($masterAcc)?$masterAcc->mst_ac_head:"" }}" placeholder="Master A/C Head" required>
                                                @error('mst_ac_head')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mt-1">
                                                <label>VAT Type</label>
                                                <select name="vat_type" id="vat_type" class="common-select2 inputFieldHeight" style="width: 100% !important" required>
                                                    <option value="">Select..</option>
                                                    @foreach ($vat_types as $item)
                                                    <option value="{{ $item->title }}" {{ isset($masterAcc)?($masterAcc->vat_type==$item->title?"selected":""):"" }}>{{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('vat_type')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 @isset($masterAcc)col-md-4 pl-0 @endisset" style="margin-top: 36px;">
                                                <div class="d-flex justify-content-end">
                                                    @isset($masterAcc)
                                                    <a href="{{ route('new-chart-of-account') }}" class="btn btn-info mr-1 formButton"><img src="{{ asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="image-fluid" width="25"> New</a>
                                                    @endisset

                                                    <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                            </div>
                                                            @isset($masterAcc)
                                                            <div><span>Update</span></div>
                                                            @else
                                                            <div><span> Save</span></div>
                                                            @endisset
                                                        </div>
                                                    </button>
                                                    <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset" @isset($masterAcc)disabled @endisset>
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
                    <section class="mr-1 ml-1 mt-2">
                        <div class="mt-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <form>
                                        <input type="text" name="q" class="form-control input-xs inputFieldHeight ajax-search" placeholder="Search By A/C Code, A/C Head, Definition, VAT Type, A/C Type" data-url="{{ route('admin.masterAccSearchAjax',$id="masterAcc") }}">
                                    </form>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="#" class="btn btn-xs mPrint formButton" onclick="window.print()" title="Print"><img  src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" class="img-fluid" width="30"> Print</a>
                                    <a href="{{ route("chart-ofaccount-pdf") }}" class="btn btn-xs mPdfPrint formButton" title="PDF Download"><img  src="{{asset('assets/backend/app-assets/icon/pdf-download-icon.png')}}" class="img-fluid" width="30"> PDF Download</a>
                                    <a href="#" class="btn btn-xs mExcelButton formButton" onclick="exportTableToCSV('MasterAccountsdetails.csv')" title="Export to Excel"><img  src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" class="img-fluid" width="30">Export To Excel</a>
                                </div>
                            </div>
                            <div class="cardStyleChange">
                                <table class="table mb-0 table-sm table-hover">
                                    <thead  class="thead-light">
                                        <tr class="mTheadTr">
                                        <th>Code</th>
                                        <th>Master A/C Head</th>
                                        <th>Definition</th>
                                        <th>A/C Type</th>
                                        <th>VAT Type</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="user-table-body">
                                        @foreach ($masterDetails as $masterAcc)
                                        <tr class="trFontSize">
                                            <td>{{ $masterAcc->mst_ac_code }}</td>
                                            <td>{{ $masterAcc->mst_ac_head }}</td>
                                            <td>{{ $masterAcc->mst_definition }}</td>
                                            <td>{{ $masterAcc->mst_ac_type }}</td>
                                            <td>{{ $masterAcc->vat_type }}</td>
        
                                            <td style="padding-bottom: 11px; padding-top: 0px">
                                               <div class="d-flex justify-content-center">
                                                <a href="{{ route('masterEdit',$masterAcc) }}" class="btn" style="height: 30px; width: 30px;" title="Eidt"><img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;"></a>
                                                <a href="{{ route('masterDelete',$masterAcc) }}" onclick="return confirm('about to delete master account. Please, Confirm?')"  class="btn" style="height: 30px; width: 30px;" title="Delete"><img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;"></a>
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
                                {{$masterDetails->links()}}
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
                            $("#mst_ac_code").val(response);
                        }

                    })
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

        $(document).on("click", ".findMasterAcc", function(e) {
            e.preventDefault();
            var that = $(this);

            var urls = that.attr("data-target");
            delay(function() {
                $.ajax({
                    url: urls,
                    type: 'GET',
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        //   alert('ok');
                        // console.log(response);
                        $(".pagination").remove();
                        $(".user-table-body").empty().append(response.page);
                    },
                    error: function() {
                        //   alert('no');
                    }
                });
            }, 999);
        });
        $(document).on("click", ".editAccHead", function(e) {
            e.preventDefault();
            var that = $(this);

            var urls = that.attr("data-target");
            delay(function() {
                $.ajax({
                    url: urls,
                    type: 'GET',
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        //   alert('ok');
                        // console.log(response);
                        $(".pagination").remove();
                        $(".user-table-body").empty().append(response.page);
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
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    #customers td, #customers th {
        border: 1px solid #ddd;
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
           /* overflow: hidden; */
       }
       html, body{
        overflow: hidden;
       }
   }
</style>
<section class="print-layout">
@include('layouts.backend.partial.modal-header-info')

<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
         <section id="widgets-Statistics">
             <div class="row">
                 <div class="col-12 mt-1 mb-2">
                     <h4>Master Account Details</h4>
                     <hr>
                 </div>
             </div>

                 <div class="row">
                        <table id="customers" class="table-sm">
                            <tr>
                                <th>Master A/C Code</th>
                                <th>Master A/C Head</th>
                                <th>Desfinition</th>
                                <th>Master A/C Type</th>
                                <th>VAT Type</th>
                            </tr>

                            @foreach ($masterDetailsPDF as $masterAcc)
                            <tr>
                                <td>{{ $masterAcc->mst_ac_code }}</td>
                                <td>{{ $masterAcc->mst_ac_head }}</td>
                                <td>{{ $masterAcc->mst_definition }}</td>
                                <td>{{ $masterAcc->mst_ac_type }}</td>
                                <td>{{ $masterAcc->vat_type }}</td>


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