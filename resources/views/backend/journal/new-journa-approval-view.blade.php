<style>
    html, body {
        height:100%; 
        overflow: hidden;
    }
</style>
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div> --}}
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
        <div class="mIconStyleChange"><a href="{{route("tem-journal-view-pdf", $journal->id)}}" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        {{-- <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
@include('layouts.backend.partial.modal-header-info')
<section id="widgets-Statistics" class="p-2">
    <div class="cardStyleChange">
        <div class="d-flex ml-2 mr-2">
            <h4 class="flex-grow-1">Journal View</h4>
        </div>
        <div class="card-body">
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
                            <strong>:</strong>{{ $journal->project->proj_name}}
                        </div>

                        <div class="col-5">
                            <strong>Cost Center</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong> {{ $journal->cost_center->cc_name}}
                        </div>

                        <div class="col-5">
                            <strong>Party</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong>  {{ $journal->party->pi_name}}
                        </div>

                        <div class="col-5">
                            <strong>Invoice No</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong> {{ $journal->invoice_no}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        {{-- <div class="col-5">
                            <strong>Account Head </strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong>
                        </div> --}}

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
                            <strong>Narration</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong> {{ $journal->narration}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cardStyleChange">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered border-bottom">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
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
                        <tr>
                            @if ($loop->index==0)
                                <td rowspan="{{$rowcount+1}}">{{ \Carbon\Carbon::parse($record->created_at)->format('d.m.Y')}}</td>
                            @endif

                            <td style="border-bottom: none;">{{ $record->account_head }}</td>
                            <td style="border-bottom: none;">{{ $retVal = ($record->transaction_type=='DR') ? $record->amount : ''  }}</td>
                            <td style="border-bottom: none;">{{ $retVal = ($record->transaction_type=='CR') ? $record->amount : ''  }}</td>

                        </tr>
                        @endforeach
                        <tr>
                            <td>( {{$journal->narration}} ) </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h3>Supporting Document</h3>
                    @if ($journal->voucher_scan !='')
                    <img src="{{asset('storage/upload/documents')}}/{{$journal->voucher_scan}}" class="img-fluid" style="height: 490px" alt="">    
                    @endif                    
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end print-hideen">
                <button type="submit" class="btn mr-1 btn-primary formButton" title="Authorize">
                    <a href="{{ route('journalMakeApprove',$journal) }}" onclick="return confirm('about to authorize journal. Please, Confirm?')" class="btn btn-primary formButton btn-block">
                        <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" width="25">
                        Approve
                    </a>
                </button>
            </div>
        </div>
    </div>
</section>
@include('layouts.backend.partial.modal-footer-info')