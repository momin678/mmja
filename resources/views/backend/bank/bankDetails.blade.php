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
                            <h4>Bank Details</h4>
                        </div>
                    </div>
                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                        <div class="col-12">
                            <form action="{{ route('bankDetailsPost') }}" method="POST">
                                @csrf
                                <div class="row match-height">
                                    <div class="col-md-4 changeColStyle">
                                        <label>BANK CODE</label>
                                        <input type="text" id="" class="form-control inputFieldHeight" name="" value="{{ isset($cc) ? $cc : '' }}" placeholder="Bank Name" disabled readonly>
                                    </div>
                                    <div class="col-md-4 changeColStyle">
                                        <label>Bank Name</label>
                                        <input type="text" id="bank_name" class="form-control inputFieldHeight" name="bank_name" value="{{ old('bank_name') }}" placeholder="Bank Name" required>
                                        @error('bank_name')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 changeColStyle">
                                        <label>Branch Name</label>
                                        <input type="text" id="branch" class="form-control inputFieldHeight" name="branch" placeholder="Branch Name" required value="{{old('branch')}}">
                                        @error('branch')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 changeColStyle">
                                        <label>Account Title</label>
                                        <input type="text" id="signatory" class="form-control inputFieldHeight" name="signatory" placeholder="Account Title" required value="{{old('signatory')}}">
                                        @error('signatory')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 changeColStyle">
                                        <label>Account Number</label>
                                        <input type="number" id="ac_no" class="form-control inputFieldHeight" name="ac_no" value="{{ old('ac_no') }}"placeholder="Account Number" required>
                                        @error('ac_no')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 changeColStyle">
                                        <label>IBAN</label>
                                        <input type="text" id="" class="form-control inputFieldHeight" name="bank_iban" value="" placeholder="IBAN">
                                        @error('bank_iban')
                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-12 d-flex justify-content-end changeColStyle mb-1 mt-1">
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
                <section id="widgets-Statistics" class="mr-1 ml-1">
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <form>
                                    <input type="text" name="q" class="form-control inputFieldHeight input-xs pull-right ajax-search" placeholder="Search By Code, Name, Account Numbe" data-url="{{ route('admin.masterAccSearchAjax',$id="bankDetails") }}">
                                </form>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="#" class="btn btn-xs mPrint formButton bank_list_print" title="Print">
                                    <img  src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" alt="" srcset="" class="img-fluid" width="30"> 
                                    Print</a>
                                <a href="#" class="btn btn-xs mExcelButton formButton" onclick="exportTableToCSV('bankdetails.csv')" title="Export to Excel"><img  src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}"  class="img-fluid" width="30">Export To Excel</a href="#">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="thead-light">
                                <tr style="height: 50px;">
                                    <th>Bank Code</th>
                                    <th>Bank Name</th>
                                    <th>Bank Branch</th>
                                    <th>Account Title</th>
                                    <th>Account Number</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="user-table-body">
                                @foreach ($bankDetails as $bank)
                                    <tr>
                                        <td>{{ $bank->bank_code }}</td>
                                        <td>{{ $bank->bank_name }}</td>
                                        <td>{{ $bank->branch }}</td>
                                        <td>{{ $bank->signatory }}</td>
                                        <td>{{ $bank->ac_no }}</td>
                                        <td style="padding-bottom: 11px; padding-top: 0px" class="pr-2">
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ route('bankEdit', $bank) }}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                                                    <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                                </a>
                                                <a href="{{ route('bankDelete', $bank) }}" onclick="return confirm('about to delete project. Please, Confirm?')"  class="btn" style="height: 30px; width: 30px;" title="Delete">
                                                    <img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;">
                                                </a>
                                            </div>
                                         </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-12 text-right">
                            {{ $bankDetails->links() }}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="bankListPrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="bankListPrint">

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
    $(document).on("click", ".bank_list_print", function(e) { 
        e.preventDefault();
        $.ajax({
            url: "{{URL('bank-list-print')}}",
            method: "get",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}',
                id:'projDetails',
            },
            success: function(response){				
                document.getElementById("bankListPrint").innerHTML = response;
                $('#bankListPrintModal').modal('show');
                setTimeout(printFunction, 500);
            }
        });
    });
    $(document).ready(function() {

                var delay = (function() {
                    var timer = 0;
                    return function(callback, ms) {
                        clearTimeout(timer);
                        timer = setTimeout(callback, ms);
                    };
                })();
                $(document).on("click", ".bank-form-btn", function(e) {
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
                                $(".bank-form").empty().append(response.page);
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
