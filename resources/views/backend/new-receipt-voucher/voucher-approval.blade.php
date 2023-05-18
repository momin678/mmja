
@extends('layouts.backend.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
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
					<a href="{{route("receipt-voucher-list")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
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
                    <a href="{{route("receipt-voucher-approval")}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
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
                <div id="journalAuthorization" class="tab-pane active">
                    <section id="widgets-Statistics">
                        <div class="col-md-12">
                            <div class="row">
                                <h4 class="mt-2 ml-2">Receipt Voucher to Approval</h4>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="#" class="btn btn-xs formButton mExcelButton mr-2" onclick="exportTableToCSV('journal.csv')"><img  src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" alt="" srcset="" class="img-fluid" width="30">Export To Excel</a href="#">
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="m-2">
                            <table class="table table-sm table-hover">
                                <thead class="thead-light">
                                    <tr class="mTheadTr">
                                        <th>Date</th>
                                        {{-- <th>Journal No</th> --}}
                                        {{-- <th>Voucher Type</th> --}}
                                        <th>Narration</th>
                                        <th>Amount</th>
                                        <th class="text-right pr-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($vouchers as $vouchers)
                                        <tr class="trFontSize">
                                            <td>{{ \Carbon\Carbon::parse($vouchers->created_at)->format('d.m.Y')}} </td>
                                            {{-- <td>{{ $vouchers->journal_no }}</td> --}}
                                            {{-- <td class="pl-2">{{ $vouchers->voucher_type->type == 'DR' ? 'DEBIT' : ($vouchers->voucher_type->type=='CR' ? 'CREDIT' : 'JOURNAL') }}</td> --}}
                                            <td>{{ $vouchers->narration }}</td>
                                            <td>{{ $vouchers->amount }}</td>
                                            <td style="padding-bottom: 11px; padding-top: 0px">
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" class="btn journalApprovalShowId" style="height: 30px; width: 30px;" title="Preview" id="{{$vouchers->id}}">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                    </a>
                                                    @if ($vouchers->created_by == Auth::id())
                                                        <a href="{{route('receipt-voucher-edit', $vouchers->id)}}" class="btn" style="height: 30px; width: 30px;" title="Edit">
                                                            <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                                        </a>
                                                    @endif
                                                    <a href="{{route('receipt-voucher-rejected', $vouchers->id)}}" class="btn" style="height: 30px; width: 30px;" title="Rejected">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/reject-icon.png')}}" style=" height: 30px; width: 30px;">
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal --}}
    <div class="modal fade bd-example-modal-lg" id="journalApprovalModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="journalApprovalShow">
              
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
{{-- js work by mominul start --}}
<script>
    $(document).on("click", ".journalApprovalShowId", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
        console.log(id);
		$.ajax({
			url: "{{URL('receipt-voucher-approval-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){				
                document.getElementById("journalApprovalShow").innerHTML = response;
                $('#journalApprovalModal').modal('show')
			}
		});
	});
</script>
{{-- js work by mominul end --}}

@endpush

