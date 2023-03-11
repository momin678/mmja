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
            <div class="container py-4">
                <div class="row">
                    <div class="col-md-12">
                    <section id="widgets-Statistics">
                        <div class="row">
                            <div class="col-12 mt-1 mb-2">
                                <h4>Master Account Details</h4>
                                <hr>
                            </div>
                        </div>

                            <div class="row">
                                    <table id="customers">
                                        <tr style="font-size: 12px; text-align: left !important;">
                                            <th> Code</th>
                                            <th style="text-align: left !important;">Master A/C Head</th>
                                            <th>Desfinition</th>
                                            <th>A/C Type</th>
                                            <th>VAT Type</th>
                                        </tr>

                                        @foreach ($masterDetails as $masterAcc)
                                        <tr style="font-size: 12px; border-bottom: 1px solid black !important;" >
                                            <td>{{ $masterAcc->mst_ac_code }}</td>
                                            <td>{{ $masterAcc->mst_ac_head }}</td>
                                            <td>{{ $masterAcc->mst_definition }}</td>
                                            <td>{{ $masterAcc->mst_ac_type }}</td>
                                            <td>{{ $masterAcc->vat_type }}</td>


                                        </tr>

                                        @endforeach



                                    </table>
                            </div>
                    </section>
                    </div>
                </div>
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