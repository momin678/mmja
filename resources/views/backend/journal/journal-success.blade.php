
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
                        <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="40" height="20">
                    </div>
                    <div>Journal View</div>
                </a>
                @if (Auth::user()->hasPermission('app.journal_entry'))
                <a href="{{route('new-journal-creation')}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Journal Entry</div>
                </a>
                @endif
                @if (Auth::user()->hasPermission('app.journal_authorize'))
                <a  href="{{route("journal-authorization-section")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/authorization-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Authorization</div>
                </a>
                @endif
                @if (Auth::user()->hasPermission('app.journal_approval'))
                <a href="{{route("journal-approval-section")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/approval-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div class="pt-1"> &nbsp;&nbsp; Approval  &nbsp;&nbsp;</div>
                </a>
                @endif
            </div>
            <div class="tab-content bg-white">
                <div id="journalAuthorization" class="tab-pane active">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <p class="text-center">
                                <a href="{{ route('journal_edit', $journal->id)}}" class="btn btn-info">Edit</a>
                                <a href="{{ route('new-journal-creation')}}" class="btn btn-success">Continue Entry</a>
                            </p>
                        </div>
                    </div>
                    @include('layouts.backend.partial.modal-header-info')
                    <section id="widgets-Statistics">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="">
                                        <div class="ml-2 mb-3 mr-2">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <strong>Journal No </strong>
                                                        </div>
                                                        <div class="col-7">
                                                            <strong>:</strong>  {{ $journal->journal_no}}
                                                        </div>
                        
                                                        <div class="col-5">
                                                            <strong>Journal Date</strong> 
                                                        </div>
                                                        <div class="col-7">
                                                            <strong>:</strong> {{ $journal->date}}
                                                        </div>
                        
                                                        <div class="col-5">
                                                            <strong>Project</strong>
                                                        </div>
                                                        <div class="col-7">
                                                            <strong>:</strong> {{ $journal->project->proj_name}}
                                                        </div>
                        
                                                        @if (isset($journal->costCenter->cc_name))
                                                        <div class="col-5">
                                                            <strong>Cost Center</strong>
                                                        </div>
                                                        <div class="col-7">
                                                            <strong>:</strong> {{ $journal->costCenter->cc_name}}
                                                        </div> 
                                                        @endif
                        
                                                        <div class="col-5">
                                                            <strong>Party</strong>
                                                        </div>
                                                        <div class="col-7">
                                                            <strong>:</strong> {{ $journal->PartyInfo->pi_name}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                        
                                                        <div class="col-5">
                                                            <strong>Payment Mode</strong>
                                                        </div>
                                                        <div class="col-7">
                                                            <strong>:</strong> {{ $journal->pay_mode}}
                                                        </div>
                        
                                                        <div class="col-5">
                                                            <strong>Amount</strong>
                                                        </div>
                                                        <div class="col-7">
                                                            <strong>:</strong> {{ $journal->total_amount}}
                                                        </div>
                        
                                                        {{-- <div class="col-5">
                                                            <strong>Vate Rate</strong>
                                                        </div>
                                                        <div class="col-7">
                                                            <strong>:</strong> {{ $journal->tax_rate}}
                                                        </div> --}}
                        
                                                        <div class="col-5">
                                                            <strong>Total Amount</strong>
                                                        </div>
                                                        <div class="col-7">
                                                            <strong>:</strong> {{ $journal->amount}}
                                                        </div>
                                                        <div class="col-5">
                                                            <strong>Invoice No</strong>
                                                        </div>
                                                        <div class="col-7">
                                                            <strong>:</strong> {{ $journal->invoice_no}}
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="border-botton">
                                        <div class="m-2">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered border-botton">
                                                    <thead class="thead-light">
                                                        <tr class="mTheadTr trFontSize">
                                                            {{-- <th>Date</th> --}}
                                                            <th>Description</th>
                                                            <th>Debit</th>
                                                            <th>Credit</th>
                                                        </tr>
                                                    </thead>
                        
                                                    <tbody class="user-table-body">
                                                            @php
                                                                $rowcount=$journal->records->count(); 
                                                            @endphp
                                                            @foreach ($journal->records as $record)
                                                            <tr class="trFontSize">
                                                                {{-- @if ($loop->index==0)
                                                                    <td rowspan="{{$rowcount+1}}">{{ \Carbon\Carbon::parse($record->created_at)->format('d.m.Y')}}</td>
                                                                @endif --}}
                                                                
                                                                <td style="border-bottom: none;">{{ $record->account_head }}</td>
                                                                <td style="border-bottom: none;">{{ $retVal = ($record->transaction_type=='DR') ? $record->amount : ''  }}</td>
                                                                <td style="border-bottom: none;">{{ $retVal = ($record->transaction_type=='CR') ? $record->amount : ''  }}</td>
                                                                
                                                            </tr>
                                                            @endforeach
                                                            <tr class="border-bottom">
                                                                <td>( {{$journal->narration}} ) </td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <section>
                        <div class="row pt-4">
                            <div class="col-12 text-center">
                                <h3>Supporting Document</h3>
                                @if ($journal->voucher_scan != '')
                                    <img src="{{asset('storage/upload/documents')}}/{{$journal->voucher_scan}}" class="img-fluid" style="height: 490px" alt=""> 
                                @endif            
                            </div>
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

