<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
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
            <div class="row">
                <div class="col-md-12 ml-2 mt-1">
                    <h2 style="text-align:center;">Journal</h2>
                </div>
                <table>
                    <tr>
                        <th>Journal No</th>
                        <td><strong>:</strong>         {{ $journal->journal_no}}</td>
                        <th>Payment Mode</th>
                        <td><strong>:</strong>       {{ $journal->pay_mode}}</td>
                    </tr>
                    <tr>
                        <th>Journal Date</th>
                        <td><strong>:</strong>       {{ $journal->date}}</td>
                        <th>Amount</th>
                        <td><strong>:</strong>       {{ $journal->total_amount}}</td>
                    </tr>
                    <tr>
                        <th>Project</th>
                        <td><strong>:</strong>       @if ($journal->project) {{ $journal->project->proj_name}} @endif</td>
                        <th>Vat Rate</th>
                        <td><strong>:</strong>       {{ $journal->tax_rate}}</td>
                    </tr>
                    <tr>
                        <th>Cost Center</th>
                        <td><strong>:</strong>      @if ($journal->costCenter) {{ $journal->costCenter->cc_name}} @endif </td>
                        <th>Total Amount</th>
                        <td><strong>:</strong>       {{ $journal->amount}}</td>
                    </tr>
                    <tr>
                        <th>Party</th>
                        <td><strong>:</strong>       @if ($journal->PartyInfo) {{ $journal->PartyInfo->pi_name}} @endif </td>
                        <th>Invoice No</th>
                        <td><strong>:</strong>       {{ $journal->invoice_no}}</td>
                    </tr>
                </table>        
            </div>
        </section><br>
        <section>
            <div class="table-responsive">
                <table class="table table-sm table-bordered border-botton">
                    <thead class="thead-light">
                        <tr class="mTheadTr trFontSize">
                            {{-- <th>Date</th> --}}
                            <th style="width:15%">Description</th>
                            <th style="width:15%">Debit</th>
                            <th style="width:15%">Credit</th>
                        </tr>
                    </thead>

                    <tbody class="user-table-body">
                            @php
                                $rowcount=$journal->records->count(); 
                            @endphp
                            @foreach ($journal->records as $record)
                            <tr class="trFontSize">
                                {{-- @if ($loop->index==0)
                                    <td rowspan="{{$rowcount+1}}">{{ \Carbon\Carbon::parse($record->created_at)->format('d.m.Y')}}</td>
                                @endif --}}
                                
                                <td style="border-bottom: none;">{{ $record->account_head }}</td>
                                <td style="border-bottom: none;">{{ $retVal = ($record->transaction_type=='DR') ? $record->amount : ''  }}</td>
                                <td style="border-bottom: none;">{{ $retVal = ($record->transaction_type=='CR') ? $record->amount : ''  }}</td>
                                
                            </tr>
                            @endforeach
                            <tr class="border-bottom">
                                <td>( {{$journal->narration}} ) </td>
                                <td></td>
                                <td></td>
                            </tr>
                    </tbody>
                </table>
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