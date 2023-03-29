<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Orders by Vendor Details</title>
    <style>
        table{
            border: 1px solid black;
            border-collapse: collapse;
        }
        table tr{
            border: 1px solid black !important;
        }
        td{
            font-size:12px;
            border: 1px solid black !important;
        }
        th{
            font-size: 16px;
            border: 1px solid black !important;
        }
        .text-center{
            text-align: center !important;
        }
        .text-right{
            text-align: right !important;
        }
        .custom{
            min-width: 100px !important;
            text-align: right !important;
        }
    </style>
</head>
<body>
    @php
        $company_name= \App\Setting::where('config_name', 'company_name')->first();
    @endphp
    <div>
        <div class="text-center">
            <h2>{{ $company_name->config_value}}</h2>
            <p class="mt-1"><b>Purchase Orders by Vendor Details {{$vendor->pi_name}}</b></p>
        </div>
        <table class="table table-sm exprortTable">
            <thead>
                <tr class="party-info">
                    <th>Date</th>
                    <th>Bill#</th>
                    <th>Due Date</th>
                    <th>Vat</th>
                    <th>Amount</th>
                    <th>Paid Balance</th>
                    <th>Balance Due</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $purchase)
                    @php
                        $today = strtotime(date('Y-m-d'));
                        $to = strtotime($purchase->date);
                        $from = strtotime($purchase->pay_date);
                        $differnet_days = (int)(($from - $to)/86400);
                        $over_days = (int)(($today - $to)/86400);
                    @endphp
                    <tr>
                        <tr>
                            <td class="custom">{{$purchase->date}}</td>
                            <td class="custom">{{$purchase->purchase_no}}</td>
                            <td class="custom">{{$purchase->pay_date}}</td>
                            <td class="custom"><small>(AED)</small> {{number_format($purchase->purchase_details->sum('total_amount'),2)}}</td>
                            <td class="custom"><small>(AED)</small> {{number_format($purchase->purchase_details->sum('vat_amount'),2)}}</td>
                            <td class="custom"><small>(AED)</small> {{number_format($purchase->paid_amount->sum('paid_amount'),2)}}</td>
                            <td class="custom"><small>(AED)</small> {{number_format($purchase->purchase_details->sum('total_amount')-$purchase->paid_amount->sum('paid_amount'),2)}}</td>
                        </tr>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>