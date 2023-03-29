<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receivable Summary</title>
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
        <div class="text-center">
            <h2>{{ $company_name->config_value}}</h2>
            <p class="mt-1"><b>Receivable Summary</b></p>
        </div>
        <table class="table table-sm exprortTable">
            <thead class="thead-light">
                <tr style="height: 50px;">
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Transaction#</th>
                    <th>Reference#</th>
                    <th>Status</th>
                    <th>Transaction Type</th>
                    <th>Total</th>
                    <th>Balance</th>                                    
                </tr>
            <thead/>
            <tbody>
                @php
                    $grand_total_invoice=0;
                    $grand_total_credit=0;
                    $grand_total_balance=0;
                @endphp
                @foreach($invoices as $invoice)
                    <tr>
                        <td>
                            @if (isset($invoice->partyInfo($invoice->customer_name)->pi_name))
                                <a href="{{ route('receivable-details', $invoice->partyInfo($invoice->customer_name)->id) }}" target="_blank">{{ $invoice->partyInfo($invoice->customer_name)->pi_name }}</a>
                            @endif
                        </td>
                        <td>{{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }} </td>
                        <td>{{ $invoice->invoice_no }}</td>
                        <td>-</td>
                        <td>Sent</td>
                        <td>Invoice</td>
                        <td>{{ $invoice->grand_total }}</td>
                        <td>{{ $invoice->grand_total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>