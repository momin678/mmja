
<!-- BEGIN: Body-->
<style>
    .th-border {
        border: 1px solid #000 !important;
        width:22% !important;
        margin-top: 100px !important;
    }
    .th-border2 {
        width:12% !important;
        border-top: 0px solid #fff !important;
    }
    .th-border3 {
        border: 1px solid #000 !important;
        width:78% !important;
        margin-top: 100px !important;
    }
    .tableStyle {
        width: 100%;
        margin-bottom: 1rem;
        color: #000;
    }
    p {
        color: black !important;
    }
    h3 {
        /* font-style: italic !important; */
        color: black !important;
        font-weight: 400 !important;
    }
    .spanStyle{
        color: black !important;
        font-weight: 600 !important;
    }
    .smTableStyle th,
    .smTableStyle td {
        /* font-family: cursive !important; */
        /* font-style: italic !important; */
        color: black !important;
        font-weight: 400 !important;
    }
    .lableStyle {
        /* font-family: cursive !important; */
        /* font-style: italic !important; */
        color: black !important;
        font-weight: 400 !important;
    }
    @media print{
        background-image: url('');
    }
    /* .mediaPrint{
        background-image: url('assets/backend/app-assets/beps-logo.png');
        margin: 0 auto;
        background-repeat: no-repeat;
        opacity: .2;
    } */
</style>
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
        <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        {{-- <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
<style>
    .profile-img{
            width: 100px;
            height: 100px;
        }
        .profile-img img{
            padding: 1px;
            height: 100%;
            width:100%;
        }
        .student-title{
            padding: 10px 10px 6px 10px;
            background: #787d82d2;
            color: #fff;
        }
    @media print{
        .student_profle-print{
            margin-top: -40px !important;
        }
        .print-hideen{
            visibility: hidden;
        }
        .modal-lg {
            max-width: 100% !important;
        }
        .student-title{
            padding: 10px 10px 6px 10px;
            background: #787d82d2 !important;
            -webkit-print-color-adjust: exact; 
        }
        .profile-img{
            border: 1px solid black;
            width: 100px;
            height: 100px;
        }
        .profile-img img{
            padding: 1px;
            width:100%;
            height: 100%;
        }
    }
</style>
@include('layouts.backend.partial.modal-header-info')
<section class="mediaPrint">
    <div class="content-wrapper mt-2 ">
    </div>
    <div class="container pt-2 m-2">
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
                        <th class="th-border">{{ $voucher->journal->journal_no}}</th>
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
                            {{ $voucher->ac_head->fld_ac_head}}
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
                <img src="{{ asset('assets/backend/app-assets/beps-logo.png') }}" class="img-fluid" style="height: 490px" alt="">
            </div>

        </div>
    </div>
</section>
@include('layouts.backend.partial.modal-footer-info')
    


