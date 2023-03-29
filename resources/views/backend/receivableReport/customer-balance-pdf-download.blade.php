<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Balance Summary</title>
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
            <p class="mt-1"><b>Customer Balance Summary</b></p>
        </div>
        <table class="table table-sm exprortTable">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Invoiced amount</th>
                    <th>Amount received</th>
                    <th>Closing balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $key => $customer)
                    @php
                        $party = App\PartyInfo::where('pi_code', $customer->customer_name)->first();
                        $invoices = App\Invoice::where('customer_name', $customer->customer_name)->get();
                        $invoice_amount = 0;
                        $received_amount = 0;
                        foreach ($invoices as $key => $invoice) {
                            if($invoice->invoiceAmount){
                                $invoice_amount += ($invoice->invoiceAmount->amount_from - $invoice->invoiceAmount->amount_to);
                                $received_amount  += $invoice->invoiceAmount->amount_from;
                            }
                        }
                    @endphp
                    @if ($party)
                        <tr>
                            <td> {{ $party->pi_name }} </td>
                            <td class="text-right">{{ $invoice_amount }}</td>
                            <td class="text-right">{{ $received_amount }}</td>
                            <td class="text-right">{{ $invoice_amount-$received_amount }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>