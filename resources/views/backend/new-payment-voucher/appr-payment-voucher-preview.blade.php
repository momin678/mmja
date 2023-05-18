
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

        </div>

    </section>
@include('layouts.backend.partial.modal-footer-info')
