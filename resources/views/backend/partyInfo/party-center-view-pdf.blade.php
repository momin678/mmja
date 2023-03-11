<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Party Center</title>
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
  </style>
  <body>
    @php
        $company_name= \App\Setting::where('config_name', 'company_name')->first();
        $company_address= \App\Setting::where('config_name', 'company_address')->first();
        $company_tele= \App\Setting::where('config_name', 'company_tele')->first();
        $company_email= \App\Setting::where('config_name', 'company_email')->first();
        $trn_no= \App\Setting::where('config_name', 'trn_no')->first();
    @endphp
    <section>
        <div class="divFlex" style="margin-bottom:30px;">
            <div>
                <img src="{{ asset('img/finallogo.jpeg') }}"  style="height: 100px;">
            </div>
            <div style="text-align: center; margin-top: -100px;">
                <h2 style="line-height: .1;">{{ $company_name->config_value }}</h2>
                <h6 style="line-height: .1;">{{ $company_address->config_value }}</h6>
                <h6 style="line-height: .1;">Mobile {{ $company_tele->config_value }} <span style="padding-left:20px !important;">TRN {{ $trn_no->config_value }}</span></h6>
            </div>
        </div>
    </section>
    <section>
        <h2 style="text-align: center">Party Info</h2>
        <table style="width: 100%;">
            <tr>
                <td><strong class="titleStyle">Party Code </strong></td>
                <td><strong>:</strong><span style="font-size: 12px !important;">{{ $pInfo->pi_code }}</span></td>
                <td><strong class="titleStyle">Party Name </strong></td>
                <td><strong>:</strong><span style="font-size: 12px !important;">{{ $pInfo->pi_type }}</span></td>
            </tr>
            <tr>
                <td><strong class="titleStyle">TRN Number </strong></td>
                <td><strong>:</strong><span style="font-size: 12px !important;">{{ $pInfo->trn_no }}</span></td>
                <td><strong class="titleStyle">TRN Number </strong></td>
                <td><strong>:</strong><span style="font-size: 12px !important;">{{ $pInfo->con_person }}</span></td>
            </tr>
            <tr>
                <td><strong class="titleStyle">Contact Number </strong></td>
                <td><strong>:</strong><span style="font-size: 12px !important;">{{ $pInfo->con_no }}</span></td>
                <td><strong class="titleStyle">Phone Number </strong></td>
                <td><strong>:</strong><span style="font-size: 12px !important;">{{ $pInfo->phone_no }}</span></td>
            </tr>
            <tr>
                <td><strong class="titleStyle">Address </strong></td>
                <td><strong>:</strong><span style="font-size: 12px !important;">{{ $pInfo->trn_no }}</span></td>
                <td><strong class="titleStyle">Email </strong></td>
                <td><strong>:</strong><span style="font-size: 12px !important;">{{ $pInfo->con_person }}</span></td>
            </tr>
        </table>
    </section>
    <section>
        <div class="divFooter m-2" style="position: fixed; bottom: 0; width:100%; ">
            <div style="position: relative;">Business Software Solutions Powered by 
                <img class="img-fluid" style="position: absolute;top: -30px;width: 70px;height: 70px;" src="{{ asset('assets/backend/app-assets/zisprink.png')}}" alt="" width="70"></div>
        </div>
    </section>
  </body>
</html>