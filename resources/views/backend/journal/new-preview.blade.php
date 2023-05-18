
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="py-1 pr-1"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="py-1 pr-1"><a href="#" id="{{$journal->id}}" class="btn btn-icon btn-secondary voucherDetails"><i class='bx bx-printer'></i></a></div>
        <div class="py-1 pr-1"><a href="{{route("journal-view-pdf", $journal->id)}}" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        {{-- <div class="py-1 pr-1"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
@include('layouts.backend.partial.modal-header-info')
<section id="widgets-Statistics">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 ml-2 mt-1">
                    <h4>Journal</h4>
                </div>
            </div>
        </div>
    </div>
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

    <div class="row pt-4">
        <div class="col-12 text-center">
            <h3>Supporting Document</h3>
            @if ($journal->voucher_scan != '')
                <img src="{{asset('storage/upload/documents')}}/{{$journal->voucher_scan}}" class="img-fluid" style="height: 490px" alt=""> 
            @endif            
        </div>
    </div>

    <div class="divFooter mb-1 ml-1">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('assets/backend/app-assets/zisprink.png')}}" alt="" width="70"></span>
    </div>
</section>

