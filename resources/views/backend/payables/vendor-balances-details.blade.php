<style>
    .row{
        margin: 0 !important;
    }
    .party-info{
        background: #a3afbd12 !important;
    }
</style>
@php
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="text-center">
            <h4>{{ $company_name->config_value}}</h4>
            <p class="mt-1"><b>Vendor Balances Details of {{$vendor->pi_name}}</b></p>
        </div>
        <div class="print-menu">
            <a href="#" class="btn btn-sm btn-info float-right" onclick="window.print()">Print</a>
            <a href="{{route('vbd-pdf-download', $vendor->id)}}" class="btn btn-sm btn-info float-right ml-1 mr-1">PDF Download</a>
            <a href="{{route('vbd-excel-download', $vendor->id)}}" class="btn btn-sm btn-info float-right ml-1 ">Excel Download</a>
        </div>
        <table class="table table-sm exprortTable">
            <thead>
                <tr class="party-info">
                    <th>Date</th>
                    <th>Bill#</th>
                    <th>Status</th>
                    <th>Due Date</th>
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
                        <td>{{$purchase->date}}</td>
                        <td>{{$purchase->purchase_no}}</td>
                        <td>
                            @if ($over_days>$differnet_days)
                                <span class="text-danger">Overdue by {{$over_days-$differnet_days}} days</span>
                            @else
                                <span class="text-success">Open</span>
                            @endif
                        </td>
                        <td>{{$purchase->pay_date}}</td>
                        <td><small>(AED)</small> {{number_format($purchase->purchase_details->sum('total_amount'),2)}}</td>
                        <td><small>(AED)</small> {{number_format($purchase->paid_amount->sum('paid_amount'),2)}}</td>
                        <td><small>(AED)</small> {{number_format($purchase->purchase_details->sum('total_amount')-$purchase->paid_amount->sum('paid_amount'),2)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
  