<style>
    .row{
        margin: 0 !important;
    }
    .party-info{
        background: #a3afbd12 !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <h4 class="mt-1"><b>Vendor Balances Details</b></h4>
        <table class="table table-sm">
            <tr class="party-info">
                <td>Date</td>
                <td>Bill#</td>
                <td>Status</td>
                <td>Due Date</td>
                <td>Amount</td>
                <td>Paid Balance</td>
                <td>Balance Due</td>
            </tr>
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
        </table>
    </div>
</div>
  