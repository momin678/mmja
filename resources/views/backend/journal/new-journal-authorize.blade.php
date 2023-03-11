
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
                <a href="{{route("new-journal")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
                    </div>
                    <div>Journal View</div>
                </a>
                @if (Auth::user()->hasPermission('app.journal_entry'))
                <a href="{{route('new-journal-creation')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Journal Entry</div>
                </a>
                @endif
                @if (Auth::user()->hasPermission('app.journal_authorize'))
                <a  href="{{route("journal-authorization-section")}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/authorization-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Authorization</div>
                </a>
                @endif
                @if (Auth::user()->hasPermission('app.journal_approval'))
                <a href="{{route("journal-approval-section")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/approval-icon.png')}}" alt="" srcset="" class="img-fluid" width="60">
                    </div>
                    <div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Approval  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </a>
                @endif
            </div>
            <div class="tab-content bg-white">
                <div id="journalAuthorization" class="tab-pane active">
                    <section id="widgets-Statistics">
                        <div class="col-md-12">
                            <div class="row">
                                <h4 class="mt-2 ml-2">Journal to Authorised</h4>
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
                                        <th>Journal No</th>
                                        {{-- <th>Voucher Type</th> --}}
                                        <th>Narration</th>
                                        <th>Amount</th>
                                        <th class="text-right pr-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($journals as $journal)
                                        <tr class="trFontSize">
                                            <td>{{ \Carbon\Carbon::parse($journal->created_at)->format('d.m.Y')}} </td>
                                            <td>{{ $journal->journal_no }}</td>
                                            {{-- <td class="pl-2">{{ $journal->voucher_type->type == 'DR' ? 'DEBIT' : ($journal->voucher_type->type=='CR' ? 'CREDIT' : 'JOURNAL') }}</td> --}}
                                            <td>{{ $journal->narration }}</td>
                                            <td>{{ ($journal->amount+$journal->vat_amount) }}</td>
                                            <td style="padding-bottom: 11px; padding-top: 0px">
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" class="btn journalAuthorizeShowId" style="height: 30px; width: 30px;" title="Preview" id="{{$journal->id}}">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                    </a>
                                                    <a href="{{ route('journalDelete', $journal) }}"  onclick="return confirm('about to delete journal. Please, Confirm?')" class="btn" style="height: 30px; width: 30px;" title="Delete">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;">
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
    <div class="modal fade bd-example-modal-lg" id="journalAuthorizeModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="journalAuthorizeShow">
              
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
    $(document).on("click", ".journalAuthorizeShowId", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
        console.log(id);
		$.ajax({
			url: "{{URL('journal-authorize-show-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){				
                document.getElementById("journalAuthorizeShow").innerHTML = response;
                $('#journalAuthorizeModal').modal('show')
			}
		});
	});
</script>
{{-- js work by mominul end --}}

@endpush

