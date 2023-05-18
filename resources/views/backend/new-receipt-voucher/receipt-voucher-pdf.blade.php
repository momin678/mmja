<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cahrt of Account</title>
  </head>
  <style>
    .divFlex{
        display: grid;
        grid-template-columns: 200px 800px;
    }
    .colStyle{
        line-height: 1.5;
        
    }
    .titleStyle{
        min-width: 100px !important;
        display:inline-block;
    }
    .colStyle span{
        padding-left: 30px !important;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }

    td{
        font-size:12px;
    }
    th, td {
        text-align: left;
    }

  </style>
  <body>
        @php
            $company_name= \App\Setting::where('config_name', 'company_name')->first();
            $company_address= \App\Setting::where('config_name', 'company_address')->first();
            $company_tele= \App\Setting::where('config_name', 'company_tele')->first();
            $company_email= \App\Setting::where('config_name', 'company_email')->first();
            $trn_no= \App\Setting::where('config_name', 'trn_no')->first();
            $company_logo= \App\Setting::where('config_name', 'company_logo')->first();
        @endphp
        <section>
            <div class="divFlex" style="margin-bottom:30px;">
                <div>
                    <img src="{{ asset('storage/upload/settings/')}}/{{$company_logo->config_value}}" style="height: 100px;" />
                </div>
                <div style="text-align: center; margin-top: -100px;">
                    <h2 style="line-height: .1;">{{ $company_name->config_value }}</h2>
                    <h6 style="line-height: .1;">{{ $company_address->config_value }}</h6>
                    <h6 style="line-height: .1;">Mobile {{ $company_tele->config_value }} <span style="padding-left:20px !important;">TRN {{ $trn_no->config_value }}</span></h6>
                </div>
            </div>
        </section>
        <section>
            <div class="container py-4">
                <section class="m-4">
                    <div class="col-md-12 ml-2 mt-1">
                        <h2 style="text-align:center;">Receipt Voucher</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th><strong>Paid By</strong></th>
                                <td><strong>:</strong> {{$receipt_voucher->party->pi_name}}</td>
                                <th><strong>Date</strong></th>
                                <td><strong>:</strong> {{$receipt_voucher->payment_date}}</td>
                            </tr>
                            <tr>
                                <th><strong>Payment Type</strong></th>
                                <td><strong>:</strong> {{$receipt_voucher->type}}</td>
                                <th><strong>Payment Mode</strong></th>
                                <td><strong>:</strong> {{$receipt_voucher->pay_mode}}</td>
                            </tr>
                            <tr>
                                <th><strong>Amount</strong></th>
                                <td><strong>:</strong> {{$receipt_voucher->amount}}</td>
                                <th><strong>Narration</strong></th>
                                <td><strong>:</strong> {{$receipt_voucher->narration}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-6 grid-container3">
                            <div style="padding-top: 90px; padding-right: 100px">
                                <span class="border-top" style="border-top: 1px solid;"><strong>Receiver Sign: </strong></span>
                            </div>
                            {{-- <div style="text-align: end; margin-top: -20px; padding-right: 100px; right: 0;">
                                <span class="border-top" style="border-top: 1px solid;"><strong>Signature: </strong></span>
                            </div> --}}
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <section>
            <div class="divFooter m-2" style="position: fixed; bottom: 0; width:100%; ">
                <div style="position: relative;">Business Software Solutions Powered by 
                    <img class="img-fluid" style="position: absolute;top: -30px;width: 70px;height: 70px;" src="{{ asset('assets/backend/app-assets/zisprink.png')}}" alt="" width="70"></div>
            </div>
        </section>
  </body>
</html>