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
        <div class="mIconStyleChange"><a href="{{route("tem-journal-view-pdf", $voucher->id)}}"  class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        {{-- <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
@include('layouts.backend.partial.modal-header-info')
<section id="widgets-Statistics" class="p-2">
    <div class="cardStyleChange">
        <div class="d-flex ml-2 mr-2">
            <h4 class="flex-grow-1">Receipt Voucher</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-5">
                            <strong>Journal No </strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong>  {{ $voucher->journal_no}}
                        </div>

                        <div class="col-5">
                            <strong>Journal Date</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong> {{ $voucher->date}}
                        </div>

                        <div class="col-5">
                            <strong>Project</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong> {{ $voucher->project->proj_name}}
                        </div>

                        <div class="col-5">
                            <strong>Cost Center</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong> {{ $voucher->cost_center->cc_name}}
                        </div>

                        <div class="col-5">
                            <strong>Party</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong> {{ $voucher->party->pi_name}}
                        </div>

                        <div class="col-5">
                            <strong>Invoice No</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong> {{ $voucher->invoice_no}}
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
                            <strong>:</strong> {{ $voucher->pay_mode}}
                        </div>

                        <div class="col-5">
                            <strong>Amount</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong> {{ $voucher->total_amount}}
                        </div>

                        <div class="col-5">
                            <strong>Vate Rate</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong> {{ $voucher->tax_rate}}
                        </div>

                        <div class="col-5">
                            <strong>Total Amount</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong> {{ $voucher->amount}}
                        </div>

                        <div class="col-5">
                            <strong>Narration</strong>
                        </div>
                        <div class="col-7">
                            <strong>:</strong> {{ $voucher->narration}}
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
                            $rowcount=$voucher->records->count();
                        @endphp
                        @foreach ($voucher->records as $record)
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
                            <td>( {{$voucher->narration}} ) </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-md-2">
                    
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end print-hideen">
                <button type="submit" class="btn mr-1 btn-primary formButton" title="Authorize">
                    <a href="{{ route('journalMakeAuthorize',$voucher) }}" onclick="return confirm('about to authorize journal. Please, Confirm?')" class="btn btn-primary formButton btn-block">
                        <img src="{{asset("assets/backend/app-assets/icon/save-icon.png")}}" alt="" srcset="" width="25">
                        Authorize
                    </a>
                </button>
            </div>
        </div>
    </div>
</section>
@include('layouts.backend.partial.modal-footer-info')