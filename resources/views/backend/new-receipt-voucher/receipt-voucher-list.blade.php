@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@php

@endphp
@section('content')
@include('layouts.backend.partial.style')
<style>
    .changeColStyle span{
        width: 213px !important;
    }
    .changeColStyle .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
</style>
    <div class="app-content content print-hideen">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                    {{-- @if (Auth::user()->hasPermission('receipt_voucher_view')) --}}
					<a href="{{route("receipt-voucher-list")}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
                        </div>
                        <div>Receipt Voucher View</div>
                    </a>
					{{-- @endif
					@if (Auth::user()->hasPermission('receipt_voucher_create')) --}}
                    <a href="{{route("form-receipt-voucher")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div>Receipt Voucher Entry</div>
                    </a>
					{{-- @endif
					@if (Auth::user()->hasPermission('receipt_voucher_authorize')) --}}
                    <a  href="{{route("receipt-voucher-authorize")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/authorization-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div>Authorization</div>
                    </a>
					{{-- @endif
					@if (Auth::user()->hasPermission('receipt_voucher_approval')) --}}
                    <a href="{{route("receipt-voucher-approval")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/approval-icon.png')}}" alt="" srcset="" class="img-fluid" width="60">
                        </div>
                        <div> &nbsp;&nbsp; Approval  &nbsp;&nbsp;</div>
                    </a>
					{{-- @endif --}}
					<a href="{{route("receipt-voucher-reject-list")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/invoice-declined-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div> &nbsp;&nbsp; Rejected  &nbsp;&nbsp;</div>
                    </a>
                </div>
                <div class="tab-content bg-white">
                    <div class="tab-pane active">
                        <section id="widgets-Statistics">
                            <div class="cardStyleChange">
                                <div class="p-1 d-flex">
                                    <h4 class="card-title flex-grow-1">Receipt Voucher</h4>
                                    <div>
                                        <button type="button" class="btn mExcelButton formButton" title="Export" onclick="exportTableToCSV('voucher-list-{{ date('d M Y') }}.csv')">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" width="25">
                                                </div>
                                                <div><span>Export To CSV</span></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead class="thead-light">
                                                <tr style="height: 50px;">
                                                    <th>Date</th>
                                                    <th>Paid By</th>
                                                    <th>Payment Mode</th>
                                                    <th>Amount</th>
                                                    <th class="text-right pr-1">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="user-table-body">
                                                @foreach ($receipt_vouchers as $voucher)
                                                    <tr class="trFontSize">
                                                        <td>{{ $voucher->payment_date }}</td>
                                                        <td>{{ $voucher->party->pi_name }}</td>
                                                        <td>{{ $voucher->pay_mode }}</td>
                                                        <td>{{ $voucher->amount }}</td>
                                                        <td  class="text-right pt-0 pb-1">
                                                            <a href="#" class="btn mVoucherPreview" style="height: 30px; width: 30px;" title="Preview" id="{{$voucher->id}}">
                                                                <img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> 
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="voucherPreviewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="voucherPreviewShow">
              
            </div>
          </div>
        </div>
    </div>
@endsection

@push('js')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>

    <script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/select/form-select2.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/form-repeater.js"></script>
    <script>
        $(document).on("click", ".mVoucherPreview", function(e){
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{URL('receipt-voucher-details-modal')}}",
                type: "post",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){				
                    document.getElementById("voucherPreviewShow").innerHTML = response;
                    $('#voucherPreviewModal').modal('show')
                }
            });
        });
    </script>
@endpush
