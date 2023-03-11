
<style>
    @media print{
        html, body{
            overflow: hidden;
        }
    }
</style>
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="py-1 pr-1"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="py-1 pr-1"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
        <div class="py-1 pr-1"><a href="{{route("journal-view-pdf", $voucher->id)}}" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        {{-- <div class="py-1 pr-1"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
@include('layouts.backend.partial.modal-header-info')
<section class="mediaPrint">
    <div class="content-wrapper mt-2 ">
        
    </div>
    <div class="pt-2 m-2">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>
                    <span class="spanStyle"> {{ $voucher->type=='DR' ? 'DEBIT' : ($voucher->type=='CR' ? 'CREDIT' : 'JOURNAL') }} VOUCHER </span>
                </h2>
            </div>
        </div>
        <div class="row pt-3 mr-2">
            <div class="col-12">
                <table class="table tableStyle table-sm smTableStyle">
                    <tr>
                        <th class="th-border">Serial No</th>
                        <th class="th-border">{{ $voucher->journal_no}}</th>
                        <th class="th-border2"></th>
                        <th class="th-border">Date</th>
                        <th class="th-border">{{$voucher->date}}</th>
                    </tr>
                    <tr>
                        <th class="th-border align-middle">Amount</th>
                        <th class="th-border align-middle">{{$voucher->amount}}</th>
                        <th class="th-border2"></th>
                        <th class="th-border align-middle">Pay Mode</th>
                        <th class="th-border align-middle">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                <label class="form-check-label lableStyle" for="flexRadioDefault1">
                                 {{$voucher->pay_mode}}
                                </label>
                              </div>
                        </th>
                    </tr>

                </table>

                <table class="table table-sm mt-1 smTableStyle">

                    <tr>
                        <th class="th-border align-middle" >RECEIVED FROM </th>
                        <th class="th-border3 align-middle" >{{ $voucher->party->pi_name}}</th>
                        
                    </tr>
                    <tr>
                        <th class="th-border align-middle" >AMOUNT IN WORD </th>
                        <th class="th-border3 align-middle" >{{ $voucher->amount_word($voucher->amount)}}</th>
                        
                    </tr>
                    <tr>
                        <th class="th-border align-middle" >ACCOUNT HEAD</th>
                        <th class="th-border3 align-middle" >
                            {{ $voucher->fld_ac_head}}
                            @php
                                $records= App\JournalRecord::where('journal_id',$voucher->journal_id)->where('is_main_head', 1 )->get();
                            @endphp
                            @foreach ($records as $item)
                                {{$item->account_head}},
                            @endforeach
                        </th>
                    </tr>

                    <tr style="height: 80px">
                        <th class="th-border align-middle" >DESCRIPTION</th>
                        <th class="th-border3 align-middle" >{{ $voucher->narration}}</th>
                    </tr>

                </table>
            </div>
        </div>
        <div class="pt-5 mt-5 mr-2 border-bottom d-flex justify-content-between">
            <div>
                <span class="p-2">
                    @if ($voucher->type == 'DR')
                        Paid By
                    @else
                        Received By
                    @endif
                </span>
            </div>
            <div>
                <spap class="p-2">Authorize By</span>
            </div>
            <div>
                <spap class="p-2">Approve By</span>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-12 text-center">
                <h3>Supporting Document</h3>
                @if ($voucher->journal->voucher_scan != '')
                <img src="{{asset('storage/upload/documents')}}/{{$voucher->journal->voucher_scan}}" class="img-fluid" style="height: 490px" alt="">    
                @endif                
            </div>

        </div>
    </div>
    <div class="divFooter ml-1 ml-2">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('assets/backend/app-assets/zisprink.png')}}" alt="" width="70"></span>
    </div>
</section>
    


