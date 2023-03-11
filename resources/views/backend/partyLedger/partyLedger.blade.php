@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>

    </style>
@endpush
@php
    $grand_total_value=0;
    $grand_total_pcs=0;
@endphp
@section('title', 'General Ledger')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-2">
                            {{-- {{ date('d M Y') }} --}}
                            <h4>Party Ledger</h4>
                        </div>
                           {{-- <div class="col-md-2 text-right">
                            <form action="{{ route('searchDailySale') }}" method="GET">
                               <div class="row form-group">
                                <input type="text" class="form-control col-9" name="date"  placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                               </div>
                            </form>
                           </div> --}}
                           <div class="col-md-5  col-left-padding">
                            <form >
                                <div class="row form-group">
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="date"
                                        placeholder="From"  value="{{ isset($searchDatefrom)? $searchDatefrom:"" }}"  onfocus="(this.type='date')"  id="date" required>
                                    </div>
                                    <div class="col-10 col-right-padding">
                                        <select name="party_date" id="party_date" class="form-control common-select2">
                                            <option value="">Select...</option>
                                            @foreach ($parties as $item)
                                                <option value="{{ $item->id }}">{{ $item->pi_name }}</option>
                                            @endforeach
                                        </select>
                                          </div>
                                          <div class="col-2 col-left-padding">
                                            <i class="bx bx-search btn btn-warning btn-sm btn-block" id="clickDate"></i>

                                          </div>
                                </div>
                            </form>
                       </div>
                           <div class="col-md-5  col-left-padding">
                                <form >
                                    <div class="row form-group">
                                        <div class="col-6 col-right-padding">
                                            <input type="text" class="form-control" name="from"
                                            placeholder="From"  value="{{ isset($searchDatefrom)? $searchDatefrom:"" }}"  onfocus="(this.type='date')"  id="from" required>

                                        </div>
                                        <div class="col-6  col-left-padding ">
                                            <input type="text" class="form-control" name="to"
                                            placeholder="To" value="{{ isset($searchDateto)? $searchDateto:"" }}" onfocus="(this.type='date')" id="to" required>
                                        </div>
                                        <div class="col-10 col-right-padding">
                                            <select name="party" id="party" class="form-control common-select2">
                                                <option value="">Select...</option>
                                                @foreach ($parties as $item)
                                                    <option value="{{ $item->id }}">{{ $item->pi_name }}</option>
                                                @endforeach
                                            </select>
                                              </div>
                                              <div class="col-2 col-left-padding">
                                                <i class="bx bx-search btn btn-warning btn-sm btn-block" id="click"></i>

                                              </div>
                                    </div>
                                </form>
                           </div>
                           <div class="col-md-3">

                           </div>

                           <div class="col-md-12">
                            {{-- <select name="journal_no" id="journal_no" class="form-control journal_no common-select2">
                                <option value="">Select..</option>
                            </select>
                           </div> --}}
                            <input type="hidden" name="hidden_date_from" value="{{ isset($from)? $from:"" }}" id="hidden_date_from">
                            <input type="hidden" name="hidden_date_to" value="{{ isset($to)? $to:"" }}" id="hidden_date_to">


                            <div class="col-md-12 " id="table-body">

                            </div>

                        </div>
                    </div>


                </section>
                <!-- Widgets Statistics End -->



            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $('#click').click(function() {
                var from = $('#from').val();
                var to = $('#to').val();
                var party = $('#party').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findPartyLedgers') }}",
                    method: "GET",
                    data: {
                        from: from,
                        to: to,
                        party: party,
                        _token: _token,
                    },
                    success: function(response) {
                        $("#table-body").empty().append(response.page);
                        $.each(response.journals, function(i, item) {
                            // alert(item);
                                $('.journal_no').append($('<option>', {
                                    value: item.id,
                                    text: item.journal_no
                                }));
                            });
                    }
                })
            });



            $('#clickDate').click(function() {
                var date = $('#date').val();
                var party = $('#party_date').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findPartyLedgersDate') }}",
                    method: "GET",
                    data: {
                        date: date,
                        party: party,
                        _token: _token,
                    },
                    success: function(response) {
                        $("#table-body").empty().append(response.page);
                        $.each(response.journals, function(i, item) {
                            // alert(item);
                                $('.journal_no').append($('<option>', {
                                    value: item.id,
                                    text: item.journal_no
                                }));
                            });
                    }
                })


            });
        });
    </script>


@endpush
