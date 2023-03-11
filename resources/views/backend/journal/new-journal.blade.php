@extends('layouts.backend.app')
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
                <a href="{{route("new-journal")}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
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
                        <img src="{{asset('assets/backend/app-assets/icon/approval-icon.png')}}" alt="" srcset="" class="img-fluid" width="60">
                    </div>
                    <div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Approval  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </a>
                @endif
            </div>
            <div class="tab-content bg-white">
                <div id="journalList" class="tab-pane active">
                    <section id="widgets-Statistics">
                        {{-- <label for="" class="mt-2">, , Between Date, Voucher Type.</label> --}}
                        <div class="row  p-1">
                            <div class="col-md-3">
                                <form action="{{ route('new-journal') }}" method="GET">
                                   <div class="row">
                                        <div class="col-md-7 changeColStyle">
                                            <label for="">Search Journal</label>
                                            <input type="text" class="form-control inputFieldHeight" name="text"  placeholder="Search by Journal No" id="date" required>
                                        </div>
                                        <div class="col-md-5 changeColStyle mt-2">
                                            <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon" style="margin-left: -10px;">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset=""  width="25">
                                                    </div>
                                                    <div><span> Search</span></div>
                                                </div>
                                            </button>
                                        </div>
                                   </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form action="{{ route('new-journal') }}" method="GET">
                                   <div class="row">
                                    <div class="col-md-7 changeColStyle">
                                        <label for="">Single Date</label>
                                        <input type="text" class="form-control inputFieldHeight" name="date"  placeholder="Search by Date" onfocus="(this.type='date')" id="date" required>
                                        <input type="hidden" class="form-control inputFieldHeight" name="mVoucherType" id="mVoucherType" value="">
                                    </div>
                                    <div class="col-md-5 changeColStyle mt-2">
                                        <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching">
                                            <div class="d-flex">
                                                <div class="formSaveIcon" style="margin-left: -10px;">
                                                    <img  src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset=""  width="25">
                                                </div>
                                                <div><span> Search</span></div>
                                            </div>
                                        </button>
                                    </div>
                                   </div>
                                </form>
                            </div>
                            <div class="col-md-6 pl-1">
                                <form action="{{ route('new-journal') }}" method="GET">
                                    {{-- @csrf --}}
                                    <div class="row ">
                                        <div class="col-md-3 changeColStyle">
                                            <label for="">From Date</label>
                                            <input type="text" class="form-control inputFieldHeight" name="from"
                                            placeholder="From"  value="{{ isset($searchDatefrom)? $searchDatefrom:"" }}"  onfocus="(this.type='date')"  id="from">
    
                                        </div>
                                        <div class="col-md-3 changeColStyle">
                                            <label for="">To Date</label>
                                            <input type="text" class="form-control inputFieldHeight" name="to"
                                            placeholder="To" value="{{ isset($searchDateto)? $searchDateto:"" }}" onfocus="(this.type='date')" id="to">
                                        </div>
                                        <div class="col-md-3 changeColStyle">
                                            <label for="">Type</label>
                                            <select name="voucherType" id="voucherType" class="form-control inputFieldHeight">
                                                <option value="">Type</option>
                                                <option value="DR">DEBIT</option>
                                                <option value="CR">CREDIT</option>
                                                <option value="JOURNAL">JOURNAL</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 changeColStyle text-right pr-1 mt-2">
                                            <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon" style="margin-left: -10px;">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset=""  width="25">
                                                    </div>
                                                    <div><span> Search</span></div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <input type="hidden" name="hidden_date_from" value="{{ isset($from)? $from:"" }}" id="hidden_date_from">
                                <input type="hidden" name="hidden_date_to" value="{{ isset($to)? $to:"" }}" id="hidden_date_to">
                            </div>
                        </div>
                    </section>
                    <hr>
                    <section class="mr-1 ml-1 mt-3">
                        <div class="row mt-2 mb-1">
                            <div class="col-md-6">
                                <h4>{{ date('d M Y') }}  Journal</h4>
                            </div>
                            <div class="col-md-6 text-right ">
                                <a href="#" class="btn btn-xs formButton mExcelButton" onclick="exportTableToCSV('journal.csv')"><img  src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" alt="" srcset="" class="img-fluid" width="30">Export To Excel</a href="#">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead  class="thead-light">
                                    <tr class="mTheadTr">
                                        <th>Journal No</th>
                                        <th>Date</th>
                                        <th>Voucher Type</th>
                                        <th>Narration</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th class="text-right pr-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($journals as $journal)
                                        @php $rowcount=$journal->count(); @endphp
                                        <tr class="trFontSize">
                                            <td><a href="#" style="color: #727E8C;" id="{{$journal->id}}" class="voucherDetails">{{$journal->journal_no}}</a> </td>
                                            <td>{{ \Carbon\Carbon::parse($journal->date)->format('d.m.Y')}}</td>
                                            <td class="pl-2">
                                                @if ($journal->voucher_type == 'DR')
                                                    DEBIT
                                                @elseif($journal->voucher_type == 'CR')
                                                    CREDIT
                                                @elseif($journal->voucher_type == 'JOURNAL')
                                                    JOURNAL
                                                @endif
                                            </td>
                                            <td>{{ $journal->narration }}</td>
                                            <td>{{ ($journal->amount+$journal->vat_amount) }}</td>
                                            <td>
                                                @if ($journal->authorized==0 && $journal->approved==0)
                                                    <span class="badge badge-dark">Pending</span>
                                                @elseif($journal->authorized==1 && $journal->approved==0)
                                                    <span class="badge badge-info"> Authorized </span>    
                                                @elseif($journal->authorized==1 && $journal->approved==1)
                                                    <span class="badge badge-success">Approved</span>
                                                @endif
                                            </td>
                                            <td style="padding-bottom: 11px; padding-top: 0px">
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" class="btn voucherDetails" v-type="main" style="height: 30px; width: 30px;" title="Print" id="{{$journal->id}}">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/print-icon.png')}}" style=" height: 30px; width: 30px;">
                                                    </a>
                                                    <a href="#" class="btn mVoucherPreview" v-type="main" style="height: 30px; width: 30px;" title="Preview" id="{{$journal->id}}">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;">
                                                    </a>
                                                </div>
                                             </td>
                                        </tr>
                                    @endforeach

                                    @foreach ($journals_temp as $journal)
                                        @php $rowcount=$journal->count(); @endphp
                                        <tr class="trFontSize">
                                            <td><a href="#" style="color: #727E8C;" id="{{$journal->id}}" class="voucherDetails">{{$journal->journal_no}}</a> </td>
                                            <td>{{ \Carbon\Carbon::parse($journal->date)->format('d.m.Y')}}</td>
                                            <td class="pl-2">
                                                @if ($journal->voucher_type == 'DR')
                                                    DEBIT
                                                @elseif($journal->voucher_type == 'CR')
                                                    CREDIT
                                                @elseif($journal->voucher_type == 'JOURNAL')
                                                    JOURNAL
                                                @endif
                                            </td>
                                            <td>{{ $journal->narration }}</td>
                                            <td>{{ ($journal->amount+$journal->vat_amount) }}</td>
                                            <td>
                                                @if ($journal->authorized==0 && $journal->approved==0)
                                                    <span class="badge badge-dark">Pending</span>
                                                @elseif($journal->authorized==1 && $journal->approved==0)
                                                    <span class="badge badge-info"> Authorized </span>    
                                                @elseif($journal->authorized==1 && $journal->approved==1)
                                                    <span class="badge badge-success">Approved</span>
                                                @endif
                                            </td>
                                            <td style="padding-bottom: 11px; padding-top: 0px">
                                                <div class="d-flex justify-content-end">
                                                    {{-- <a href="#" class="btn voucherDetails" v-type="temp" style="height: 30px; width: 30px;" title="Print" id="{{$journal->id}}">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/print-icon.png')}}" style=" height: 30px; width: 30px;">
                                                    </a> --}}
                                                    @if (Auth::id()==$journal->created_by)
                                                    <a href="{{ route('journal_edit', $journal->id)}}" class="btn " style="height: 30px; width: 30px;" title="Print">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                                    </a>  
                                                    @endif

                                                    <a href="#" class="btn mVoucherPreview" v-type="temp" style="height: 30px; width: 30px;" title="Preview" id="{{$journal->id}}">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;">
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
        var v_type= $(this).attr('v-type');
		$.ajax({
			url: "{{URL('voucher-details-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
                v_type:v_type,
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
        var v_type= $(this).attr('v-type');
		$.ajax({
			url: "{{URL('voucher-preview-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
                v_type:v_type,
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

        })





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
                })

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
                    if(respons != '')
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
        // $('#cost_center_name').change(function() {

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
                        console.log(response);
                        $("#cc_code").val(response.cc_code);
                        $("#pi_code").focus();


                    }
                })
            }
        });

        // $('#party_info').change(function() {
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
