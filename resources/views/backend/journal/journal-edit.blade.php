@extends('layouts.backend.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@section('content')
@include('layouts.backend.partial.style')
<style>
    .changeColStyle span{
        min-width: 16%;
    }
    .changeColStyle .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .journaCreation{
        background: #1214161c;
    }
    .transaction_type{
        padding-right:5px;
        padding-left:5px;
        padding-bottom:5px;
    }
    @media only screen and (max-width: 1500px) {
        .custome-project span{
            max-width: 140px;
        }
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
            <div class="tab-content journaCreation">
                <div id="journaCreation" class="tab-pane active">
                    <section id="widgets-Statistics">
                        @isset($journal)
                        <form action="{{ route('journalEntryEditPost', $journal) }}" method="POST" enctype="multipart/form-data">
                        @else
                            <form action="{{ route('journalEntryPost') }}" method="POST" enctype="multipart/form-data" >
                            @endisset

                            @csrf
                            <div class="cardStyleChange bg-white">
                                <div class="card-body pb-1">
                                    <div class="row m-1">
                                        <div class="col-md-2 form-group d-none">
                                            <label for="">Journal Entry No</label>
                                            <input type="text" class="form-control" id="journal_no"
                                                value="{{ isset($journal) ? $journal->journal_no : "$journal_no" }}"
                                                name="journal_no" placeholder="Journal Entry No" readonly>
                                            @error('journal_no')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 changeColStyle">
                                            <label for="project">Project</label>
                                            <select name="project" class="form-control common-select2" id="project" required>
                                                @foreach ($projects as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ isset($journal) ? ($journal->project_id == $item->id ? 'selected' : '') : '' }}>
                                                        {{ $item->proj_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('project')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-1 changeColStyle">
                                            <label for="">CC Code</label>
                                            <input type="text" name="cc_code" id="cc_code"
                                                value="{{ isset($journal) ? $journal->costCenter->cc_code : '' }}"
                                                class="form-control inputFieldHeight" placeholder="CC Code"
                                                required>
                                            @error('cc_code')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 changeColStyle search-item">
                                            <label for="">Cost Center Name</label>
                                            <select name="cost_center_name" id="cost_center_name"
                                            class="common-select2 party-info " style="width: 100% !important" data-target="" required>
                                                <option value="">Select...</option>
                                                @foreach ($cCenters as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ isset($journal) ? ($journal->cost_center_id == $item->id ? 'selected' : '') : '' }}>
                                                        {{ $item->cc_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('cost_center_name')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-1 changeColStyle">
                                            <label for="">P Code</label>
                                            <input type="text" name="pi_code" id="pi_code" class="form-control inputFieldHeight" required value="{{ isset($journal) ? $journal->partyInfo->pi_code : '' }}">
                                            @error('party_info')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 changeColStyle search-item-pi">
                                            <label for="">Party Name</label>
                                            <select name="party_info" id="party_info"
                                            class="common-select2 party-info" style="width: 100% !important" data-target="" required>
                                                <option value="">Select...</option>
                                                @foreach ($pInfos as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ isset($journal) ? ($journal->party_info_id == $item->id ? 'selected' : '') : '' }}>
                                                        {{ $item->pi_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('party_info')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 changeColStyle">
                                            <label for="">TRN</label>
                                            <input type="text" class="form-control inputFieldHeight"
                                                value="{{ isset($journal) ? $journal->partyInfo->trn_no : '' }}"
                                                name="trn_no" id="trn_no" class="form-control" readonly>
                                            @error('trn_no')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 transaction_type"> 
                                            <label for="">Transaction Type</label>
                                            <select name="transaction_type" id="transaction_type" class="common-select2 inputFieldHeight" style="width: 100% !important"
                                                required>
                                                <option value="Increase" selected>General</option>
                                                <option value="Decrease">Adjustment</option>
                                            </select>
                                            @error('transaction_type')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 changeColStyle">
                                            <label for="">Payment Mode</label>
                                            <select name="pay_mode" id="pay_mode" class="form-control inputFieldHeight" required>
                                                <option value="">Select...</option>
                                                
                                                @foreach ($modes as $item)
                                                    <option value="{{ $item->title }}"
                                                        {{ isset($journal) ? ($journal->pay_mode == $item->title ? 'selected' : '') : '' }}>
                                                        {{ $item->title }}</option>
                                                @endforeach
                                                <option value="NonCash">Special Transaction</option>
                                                
                                            </select>
                                            @error('pay_mode')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 changeColStyle">
                                            <label for="">Invoice No</label>
                                            <input type="text" class="form-control inputFieldHeight" name="invoice_no"
                                                value="{{ isset($journal) ? $journal->invoice_no : '' }}"
                                                id="invoice_no" placeholder="Invoice No" required>
                                            @error('invoice_no')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 changeColStyle" id="printarea">
                                            <label for="">Journal Date</label>
                                            <input type="date" value="{{ isset($journal) ? $journal->date : Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control inputFieldHeight" name="date" id="date" placeholder="dd-mm-yyyy" >
                                            @error('date')
                                                <div class="btn btn-sm btn-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 form-group non-cash-account-head" style="display: {{ isset($journal) ? ($journal->txn_mode == "Credit" ? '' : 'none') : 'none' }}">
                                            <label for="">Account Head</label>
                                            <select name="acc_head_2" id="acc_head_2" class="common-select2" style="width: 100% !important"
                                                >
                                                <option value="">Select...</option>
                                                @foreach ($acHeads as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ isset($journal) ? ($journal->ac_head_id == $item->id ? 'selected' : '') : '' }}>
                                                        {{ $item->fld_ac_code }} - {{ $item->fld_ac_head }}</option>
                                                @endforeach
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row p-1">
                                    <div class="cardStyleChange">
                                        <div class="card-body">
                                            <div class="repeater-default" id="form-repeat-container">

                                                @php
                                                    $nums_record= $journal->records->where('is_main_head',1)->count();
                                                @endphp

                                                @foreach ($journal->records->where('is_main_head',1) as $record)

                                                    @if ($loop->first && $nums_record>1)
                                                        <div class="pre_input_row">
                                                            <div class="row every-form-row">
                                                                <div class="col-md-3 col-sm-12 changeColStyle">
                                                                    <label for="invoice_no">A/C Head </label>
                                                                    <select name="multi_acc_head[]" class="form-control common-select2 multi-acc-head input-due-payment">
                                                                        <option value="">Select A/C Head</option>
                                                                        @foreach ($acHeads as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ isset($journal) ? ($record->account_head_id == $item->id ? 'selected' : '') : '' }}>
                                                                                {{ $item->fld_ac_head }}</option>
                                                                        @endforeach
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2 col-sm-12 changeColStyle">
                                                                    <label for="password">Total Amount</label>
                                                                    <input type="number" name="multi_total_amount[]" class="form-control inputFieldHeight amount_withvat" step=".01" value="{{$record->total_amount}}">
                                                                </div>
                                                                <div class="col-md-3 col-sm-12 changeColStyle">
                                                                    <label for="password">Vat Rate</label>
                                                                    <select name="multi_tax_rate[]"  class="common-select2 form-control multi-tax-rate" style="width: 100% !important"
                                                                    required>
                                                                    {{-- <option value="">Select Vat</option> --}}
                                                                    @foreach ($vats as $item)
                                                                        <option value="{{ $item->id }}" 
                                                                            {{ isset($journal) ? ($record->vat_rate_id == $item->id ? 'selected' : '') : '' }}>
                                                                            {{ $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                </div>
            
                                                                <div class="col-md-2 col-sm-12 changeColStyle">
                                                                    <label for="password">Amount</label>
                                                                    <input type="number" name="multi_amount[]" class="form-control amount_without_vat inputFieldHeight" value="{{$record->amount}}"  step="any" placeholder="Amount">
                                                                </div>
                                                                
                                                                <div class="col-md-2 col-sm-12 d-flex pt-2 changeColStyle justify-content-end">
                                                                    <button type="button" class="btn btn-danger formButton mDeleteIcon" data-repeater-delete title="Delete">
                                                                        <div class="d-flex align-items-right">
                                                                            <div class="formSaveIcon">
                                                                                <img  src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" alt="" srcset=""  width="25">
                                                                            </div>
                                                                            <div><span> Delete</span></div>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                    @elseif ($loop->last)
                                                    @else
                                                        <div class="row every-form-row">
                                                            <div class="col-md-3 col-sm-12 changeColStyle">
                                                                <label for="invoice_no">A/C Head</label>
                                                                <select name="multi_acc_head[]" class="form-control common-select2 multi-acc-head input-due-payment">
                                                                    <option value="">Select A/C Head</option>
                                                                    @foreach ($acHeads as $item)
                                                                        <option value="{{ $item->id }}"
                                                                            {{ isset($journal) ? ($record->account_head_id == $item->id ? 'selected' : '') : '' }}>
                                                                            {{ $item->fld_ac_head }}</option>
                                                                    @endforeach
                                                                    
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2 col-sm-12 changeColStyle">
                                                                <label for="password">Total Amount</label>
                                                                <input type="number" name="multi_total_amount[]" class="form-control inputFieldHeight amount_withvat" step=".01" value="{{$record->total_amount}}">
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 changeColStyle">
                                                                <label for="password">Vat Rate</label>
                                                                <select name="multi_tax_rate[]"  class="common-select2 form-control multi-tax-rate" style="width: 100% !important"
                                                                required>
                                                                {{-- <option value="">Select Vat</option> --}}
                                                                @foreach ($vats as $item)
                                                                    <option value="{{ $item->id }}" 
                                                                        {{ isset($journal) ? ($record->vat_rate_id == $item->id ? 'selected' : '') : '' }}>
                                                                        {{ $item->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            </div>
        
                                                            <div class="col-md-2 col-sm-12 changeColStyle">
                                                                <label for="password">Amount</label>
                                                                <input type="number" name="multi_amount[]" class="form-control amount_without_vat inputFieldHeight" value="{{$record->amount}}"  step="any" placeholder="Amount">
                                                            </div>
                                                            
                                                            <div class="col-md-2 col-sm-12 d-flex pt-2 changeColStyle justify-content-end">
                                                                <button type="button" class="btn btn-danger formButton mDeleteIcon" data-repeater-delete title="Delete">
                                                                    <div class="d-flex align-items-right">
                                                                        <div class="formSaveIcon">
                                                                            <img  src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" alt="" srcset=""  width="25">
                                                                        </div>
                                                                        <div><span> Delete</span></div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                        

                                                    @if($loop->last)
                                                        @if ($nums_record>1)
                                                        </div> <!-- pre_input_row -->  
                                                        @endif
                                                        
                                                        <div data-repeater-list="group-a">                                                    
                                                            <div data-repeater-item>
                                                                <div class="row every-form-row">
                                                                    <div class="col-md-3 col-sm-12 changeColStyle">
                                                                        <label for="invoice_no">A/C Head</label>
                                                                        <select name="multi_acc_head" class="form-control common-select2 multi-acc-head input-due-payment">
                                                                            <option value="">Select A/C Head</option>
                                                                            @foreach ($acHeads as $item)
                                                                                <option value="{{ $item->id }}"
                                                                                    {{ isset($journal) ? ($record->account_head_id == $item->id ? 'selected' : '') : '' }}>
                                                                                    {{ $item->fld_ac_head }}</option>
                                                                            @endforeach
                                                                            
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-12 changeColStyle">
                                                                        <label for="password">Total Amount</label>
                                                                        <input type="number" name="multi_total_amount" class="form-control inputFieldHeight amount_withvat" step=".01" value="{{$record->total_amount}}">
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12 changeColStyle">
                                                                        <label for="password">Vat Rate</label>
                                                                        <select name="multi_tax_rate"  class="common-select2 form-control multi-tax-rate" style="width: 100% !important"
                                                                        required>
                                                                        {{-- <option value="">Select Vat</option> --}}
                                                                        @foreach ($vats as $item)
                                                                            <option value="{{ $item->id }}" 
                                                                                {{ isset($journal) ? ($record->vat_rate_id == $item->id ? 'selected' : '') : '' }}>
                                                                                {{ $item->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    </div>
                
                                                                    <div class="col-md-2 col-sm-12 changeColStyle">
                                                                        <label for="password">Amount</label>
                                                                        <input type="number" name="multi_amount" class="form-control amount_without_vat inputFieldHeight" value="{{$record->amount}}" step="any" placeholder="Amount">
                                                                    </div>
                                                                    
                                                                    <div class="col-md-2 col-sm-12 d-flex pt-2 changeColStyle justify-content-end">
                                                                        <button type="button" class="btn btn-danger formButton mDeleteIcon" data-repeater-delete title="Delete">
                                                                            <div class="d-flex align-items-right">
                                                                                <div class="formSaveIcon">
                                                                                    <img  src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" alt="" srcset=""  width="25">
                                                                                </div>
                                                                                <div><span> Delete</span></div>
                                                                            </div>
                                                                        </button>
                                                                    </div>
                                                                </div>                                                        
                                                            </div> <!-- data-repeater-item -->
                                                        </div>                                               
                                                    @endif

                                                @endforeach

                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <div class="col p-0">
                                                                <button type="button" class="btn btn-primary btn_create formButton" data-repeater-delete title="Add" data-repeater-create>
                                                                    <div class="d-flex">
                                                                        <div class="formSaveIcon">
                                                                            <img  src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset=""  width="25">
                                                                        </div>
                                                                        <div><span>Add</span></div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div>
                                                            <input type="text" id="total_amount" class="form-control @error('total_amount') error @enderror inputFieldHeight" name="total_amount" value="{{$journal->total_amount}}" required>
                                                            @error('total_amount')
                                                            <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="cardStyleChange">
                                <div class="card-body">
                                    <div class="row p-1">
                                        <div class="col-sm-7 form-group">
                                            <label for="">Narration</label>
                                            <input type="text" class="form-control inputFieldHeight" name="narration"
                                                id="narration" placeholder="Narration"
                                                value="{{ isset($journal) ? $journal->narration : '' }}"
                                                required>
                                        </div>

                                        <div class="col-sm-3 form-group">
                                            <label for="">Voucher Scan/File</label>
                                            <input type="file" class="form-control inputFieldHeight" name="voucher_scan" >
                                        </div>
                                        <div class="col-sm-2 text-right d-flex justify-content-end mt-2 mb-1">
                                            <button type="submit" class="btn btn-primary formButton" data-repeater-delete title="Add" data-repeater-create>
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset=""  width="25">
                                                    </div>
                                                    <div><span>Save</span></div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal --}}
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="voucherPreviewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="voucherPreviewShow">
              
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="voucherDetailsPrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="voucherDetailsPrint">
              
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
    $(document).on("click", ".voucherDetails", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('voucher-details-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){				
                document.getElementById("voucherDetailsPrint").innerHTML = response;
                $('#voucherDetailsPrintModal').modal('show')
			}
		});
	});
    $(document).on("click", ".mVoucherPreview", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('voucher-preview-modal')}}",
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
    $(document).on("change", "#voucherType", function(e){
        let type = $(this).val();
        document.getElementById("mVoucherType").value = type;
    })
</script>
{{-- js work by mominul end --}}

<script>
    $(document).ready(function() {

        // $('.btn_create').click(function(){
        $(document).on("click", ".btn_create", function(e){
            e.preventDefault();
            // alert('Alhamdulillah');
            setTimeout(function() {
                $('.multi-acc-head').select2();
                $('.multi-tax-rate').select2();
            }, 1000);
        });
        // on change amount
        $('.repeater-default').on("keyup", ".amount_withvat", function(e) {
            var amount = $(this).val();
            var tax_rate= $(this).closest('.every-form-row').find('.multi-tax-rate').val();
            var amount_obj= $(this).closest('.every-form-row').find('.amount_without_vat');
            if(tax_rate==null){
                tax_rate=1;
            }
            
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('findamount') }}",
                method: "POST",
                data: {
                    amount: amount,
                    tax_rate:tax_rate,
                    _token: _token,
                },
                success: function(response) {
                    console.log(response);
                        $(amount_obj).val(response.total_amount);
                        sum_all_amount();
                }
            })
        });
        // on change tax rate
        $('.repeater-default').on('change', '.multi-tax-rate', function(){
            var value = $(this).val();
            var amount_withvat= $(this).closest('.every-form-row').find('.amount_withvat').val();
            var amount_obj= $(this).closest('.every-form-row').find('.amount_without_vat');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('findTaxRate') }}",
                method: "POST",
                data: {
                    value: value,
                    amount: amount_withvat,
                    _token: _token,
                },
                success: function(response) {
                    console.log(response);
                    $(amount_obj).val(response.total_amount);
                    
                }
            })
        });

        function sum_all_amount(){
            var sum=0;
            $('.amount_withvat').each(function() {                    
                var this_amount= $(this).val();
                this_amount = (this_amount === '') ? 0 : this_amount;
                this_amount= parseInt(this_amount);
                // 
                sum = sum+this_amount;
            });
            console.log(sum);
            $('#total_amount').val(sum);
        }
        
        $("#date").focus();
        
        $(document).on("change", "#date", function(e) {
            $("#txn_type").focus();
        })

        $(document).on("keypress", "#date", function(e) {
            var key = e.which;
            var value = $(this).val();
            if (e.which == 13) {
                $("#txn_type").focus();
                e.preventDefault();
                return false;
            }

        });

        $('#txn_type').change(function() {
            $("#cc_code").focus();

        });
        var value = $('#project').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('findProject') }}",
            method: "POST",
            data: {
                value: value,
                _token: _token,
            },
            success: function(response) {
                console.log(response);
                $("#owner").val(response.owner_name);
                $("#location").val(response.address);
                $("#address").val(response.address);
                $("#mobile").val(response.cont_no);
            }
        });

        $('#project').change(function() {
            console.log($(this).val());
            if ($(this).val() != '') {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findProject') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                        $("#owner").val(response.owner_name);
                        $("#location").val(response.address);
                        $("#address").val(response.address);
                        $("#mobile").val(response.cont_no);

                    }
                })
            }
        });

        $('#pay_mode').change(function() {
            var value = $(this).val();
            if (value=="NonCash") {
                $('.non-cash-account-head').show();
                // $("#acc_head_2").focus();
                $('.common-select2').select2();

            } else {
                $('.non-cash-account-head').hide();
                $("#ac_code").focus();
            }
        });

        $(document).on("change", "#credit_party_info", function(e) {
            $("#ac_code").focus();
        });

        $(document).on("keyup", "#cc_code", function(e) {
            var value = $(this).val();

            var _token = $('input[name="_token"]').val();
            if ($(this).val() != '') {
            $.ajax({
                url: "{{ route('findCostCenter') }}",
                method: "POST",
                data: {
                    value: value,
                    _token: _token,
                },
                success: function(response) {
                    var qty = 1;
                    if(response != '')
                    {
                        $("div.search-item select").val(response.id);
                    $('.common-select2').select2();
                    $("#pi_code").focus();
                    }
                }
            })
        }
        });

        $(document).on("keypress", "#cc_code", function(e) {
            var key = e.which;
            var value = $(this).val();
            if (e.which == 13) {
                $("#cost_center_name").focus();
                e.preventDefault();
                return false;
            }

        });

        $(document).on("change", "#cost_center_name", function(e) {
            if ($(this).val() != '') {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findCostCenterId') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        $("#cc_code").val(response.cc_code);
                        $("#pi_code").focus();
                    }
                })
            }
        });

        $('#party_info').change(function() {
            if ($(this).val() != '') {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('partyInfoInvoice2') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                        $("#trn_no").val(response.trn_no);
                        $("#pi_code").val(response.pi_code);
                        $("#invoice_no").focus();

                    }
                })
            }
        });

        $(document).on("change", "#cost_center_name", function(e) {
            if ($(this).val() != '') {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('partyInfoInvoice2') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                        $("#trn_no").val(response.trn_no);
                        $("#pi_code").val(response.pi_code);
                        $("#invoice_no").focus();

                    }
                })
            }
        });

        $(document).on("keyup", "#pi_code", function(e) {
            // alert(1);
            var value = $(this).val();
            var _token = $('input[name="_token"]').val();
            if ($(this).val() != '') {
            $.ajax({
                url: "{{ route('partyInfoInvoice3') }}",
                method: "POST",
                data: {
                    value: value,
                    _token: _token,
                },
                success: function(response) {
                    console.log(response);
                    var qty = 1;
                    if (response != '') {
                        $("div.search-item-pi select").val(response.id);
                        $('.common-select2').select2();
                        $("#trn_no").val(response.trn_no);
                        $("#invoice_no").focus();
                    }
                }
            })
        }
        });

        $(document).on("keypress", "#pi_code", function(e) {
            var key = e.which;
            var value = $(this).val();
            if (e.which == 13) {


                $("#party_info").focus();
                e.preventDefault();
                return false;
            }

        });

        $(document).on("keypress", "#invoice_no", function(e) {
            var key = e.which;
            var value = $(this).val();
            if (e.which == 13) {


                $("#pay_mode").focus();
                e.preventDefault();
                return false;
            }

        });

        $(document).on("keyup", "#ac_code", function(e) {
            // alert(1);
            var value = $(this).val();
            var _token = $('input[name="_token"]').val();
            if ($(this).val() != '') {
            $.ajax({
                url: "{{ route('findAccHead') }}",
                method: "POST",
                data: {
                    value: value,
                    _token: _token,
                },
                success: function(response) {
                    var qty = 1;
                    if (response != '') {

                    $("div.search-item-head select").val(response.id);
                    $("#amount").focus();
                    $('.common-select2').select2();
                    }


                }
            })
        }
        });

        $(document).on("keypress", "#ac_code", function(e) {
            var key = e.which;
            var value = $(this).val();
                if (e.which == 13) {
                $("#acc_head").focus();
                e.preventDefault();
                return false;
            }


        });

        $('#acc_head').change(function() {
            if ($(this).val() != '') {
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findAccHeadId') }}",
                    method: "POST",
                    data: {
                        value: value,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                        $("#ac_code").val(response.fld_ac_code);
                        $("#amount").focus();
                    }
                })
            }
        });

        $(document).on("keypress", "#amount", function(e) {
            var key = e.which;
            var value = $(this).val();
                if (e.which == 13) {
                $("#tax_rate").focus();
                e.preventDefault();
                return false;
            }
        });

    });
</script>

@endpush
