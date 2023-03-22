<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AR Ageing Details</title>
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
    </style>
</head>
<body>
    @php
        $company_name= \App\Setting::where('config_name', 'company_name')->first();
    @endphp
    <div>
        <div class="col-md-12 text-center">
            <h4>{{ $company_name->config_value}}</h4>
            <h6> AR Ageing Details By Invoice Due Date</h6>
        </div>
        <table class="table table-sm table-bordered" >
            <tr style="background: rgba(128, 128, 128, 0.644); padding: 5px !important;">
                <th style="padding-left: 15px !important; padding-right: 15px !important;">Date</th>
                <th>Transaction#</th>
                <th>Type</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th style="padding-left: 10px !important; padding-right: 10px !important;">Age</th>
                <th>Amount</th>
                <th>Balance Due</th>                                    
            </tr>
            <tbody class="invoice-tbody">
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->date }}</td>
                        <td>{{ $invoice->invoice_no }}</td>
                        <td>{{ 'Invoice' }}</td>
                        <td>{{ 'Sent' }}</td>
                        <td>{{ isset($invoice->partyInfo($invoice->customer_name)->pi_name)? $invoice->partyInfo($invoice->customer_name)->pi_name : '' }}</td>
                        <td>
                            @php
                                
                                $date = \Carbon\Carbon::parse($invoice->due_date);
                                $now = \Carbon\Carbon::now();
                                echo $diff = $date->diffInDays($now).' Days';

                            @endphp
                        </td>
                        <td class="text-right">{{ $invoice->grand_total }}</td>
                        <td class="text-right">{{ $invoice->grand_total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>