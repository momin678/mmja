
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
                    <span class="spanStyle"> RECEIPT VOUCHER </span>
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
                        <th class="th-border">{{$voucher->payment_date}}</th>
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
                        <th class="th-border3 align-middle" >
                            {{ $voucher->amount_word($voucher->amount)}}
                        </th>
                        
                    </tr>
                    <tr>
                        <th class="th-border align-middle" >ACCOUNT HEAD</th>
                        <th class="th-border3 align-middle" >
                            {{ $voucher->fld_ac_head}}
                        </th>
                    </tr>

                    <tr style="height: 80px">
                        <th class="th-border align-middle" >DESCRIPTION</th>
                        <th class="th-border3 align-middle" >{{ $voucher->narration}}</th>
                    </tr>

                </table>
            </div>
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


        
    </div>
    <div class="divFooter ml-1 ml-2">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('assets/backend/app-assets/zisprink.png')}}" alt="" width="70"></span>
    </div>
</section>
    


