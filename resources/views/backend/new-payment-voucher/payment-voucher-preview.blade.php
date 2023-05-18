
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
        <div class="py-1 pr-1"><a href="#" onclick="window.print()" class="btn btn-icon btn-secondary voucherDetails"><i class='bx bx-printer'></i></a></div>
        <div class="py-1 pr-1"><a href="{{route("receipt-voucher-view-pdf", $payment_voucher->id)}}" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        {{-- <div class="py-1 pr-1"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
<div class="print-layout">
    @include('layouts.backend.partial.modal-header-info')
</div>

    <section class="m-4">
        <div class="table-responsive">
            <table class="table table-borderless table-sm">
                <tr>
                    <td><b>Paid By</b></td>
                    <td><b>:</b> {{$payment_voucher->party->pi_name}}</td>
                    <td><b>Date</b></td>
                    <td><b>:</b> {{$payment_voucher->payment_date}}</td>
                </tr>
                <tr>
                    <td><b>Payment Type</b></td>
                    <td><b>:</b> {{$payment_voucher->type}}</td>
                    <td><b>Payment Mode</b></td>
                    <td><b>:</b> {{$payment_voucher->pay_mode}}</td>
                </tr>
                <tr>
                    <td><b>Amount</b></td>
                    <td><b>:</b> {{$payment_voucher->amount}}</td>
                    <td><b>Narration</b></td>
                    <td><b>:</b> {{$payment_voucher->narration}}</td>
                </tr>
            </table>
        </div>
        <div class="row pt-4">
            <div class="col-md-6 grid-container3">
                <div>
                    <span class="border-top"><strong style="color: #000">Receiver Sign: </strong></span>
                </div>
            </div>
            <div class="col-md-6 grid-container3">
                <div class="text-right">
                    <span class="border-top"><strong style="color: #000">Signature: </strong></span>

                </div>
            </div>
            @if (!($payment_voucher->status=='Rejected'))
                <div class="col-12 d-flex justify-content-end print-hideen pt-3">
                    @if (Auth::user()->hasPermission('payment_voucher_authorize') && Auth::user()->hasPermission('payment_voucher_approval'))
                        <button type="submit" class="btn mr-1 btn-primary formButton" title="Authorize">
                            <a href="{{ route('payment-voucher-make-authorize',$payment_voucher->id)}}" onclick="return confirm('Are you sure to {{ $payment_voucher->status=='Authoize'? 'Authorize':'Approve' }} the Voucher?')" class="btn btn-primary formButton btn-block">
                                <img src="{{asset("assets/backend/app-assets/icon/save-icon.png")}}" alt="" srcset="" width="25">
                                {{ $payment_voucher->status=="Authorize"? "Authorize":"Approve" }}
                            </a>
                        </button>

                    @elseif(Auth::user()->hasPermission('payment_voucher_authorize'))
                        @if ($payment_voucher->status=='Authorize')
                            <button type="submit" class="btn mr-1 btn-primary formButton" title="Authorize">
                                <a href="{{ route('payment-voucher-make-authorize',$payment_voucher->id)}}" onclick="return confirm('Are you sure to {{ $payment_voucher->status=='Authoize'? 'Authorize':'Approve' }} the Voucher?')" class="btn btn-primary formButton btn-block">
                                    <img src="{{asset("assets/backend/app-assets/icon/save-icon.png")}}" alt="" srcset="" width="25">
                                    {{ $payment_voucher->status=="Authorize"? "Authorize":"Approve" }}
                                </a>
                            </button>
                        @else
                            <p class="text-center"> <a href="#" class="btn btn-secondary" style="pointer-events: none" onclick="return confirm('Please, Confirm?')">Authorized</a></p>


                        @endif
                        @elseif(Auth::user()->hasPermission('payment_voucher_approval'))
                            @if ($payment_voucher->status=='Approve')
                                <button type="submit" class="btn mr-1 btn-primary formButton" title="Authorize">
                                    <a href="{{ route('payment-voucher-make-authorize',$payment_voucher->id)}}" onclick="return confirm('Are you sure to {{ $payment_voucher->status=='Authoize'? 'Authorize':'Approve' }} the Voucher?')" class="btn btn-primary formButton btn-block">
                                        <img src="{{asset("assets/backend/app-assets/icon/save-icon.png")}}" alt="" srcset="" width="25">
                                        {{ $payment_voucher->status=="Authorize"? "Authorize":"Approve" }}
                                    </a>
                                </button>
                            @endif
                        @endif
                </div>
            @endif
        </div>

    </section>
@include('layouts.backend.partial.modal-footer-info')
