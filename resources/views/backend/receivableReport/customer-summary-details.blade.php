<style>
    .row{
        margin: 0 !important;
    }
    .party-info{
        background: #a3afbd12 !important;
    }
</style>
<div class="row">
    <div class="col-md-4 border-right party-info">
        <div class="party-name border-bottom mt-1">
            <h4>{{$party->pi_name}}</h4>
        </div>
        <div class="profile d-flex pt-1">
            <img src="{{asset('img/companylogo.jpg')}}" alt="" height="100" width="110" class="rounded-circle">
            <div class="pl-2 pt-2">
                <span>Email: {{$party->email}}</span><br>
                <span>Phone: {{$party->con_no}}</span><br>
                <span>Fax: {{$party->con_no}}</span>
            </div>
        </div>
        <div class="m-1">
            <h5 class="border-bottom">Address</h5>
            <span>{{$party->address}}</span><br>
            <span>Tel: {{$party->con_no}}</span><br>
            <span>Phone: {{$party->con_no}}</span>
        </div>
    </div>
    <div class="col-md-8">
        <h4 class="mt-1"><b>Receivable</b></h4>
        <table class="table table-sm">
            <tr class="party-info">
                <td>Currency</td>
                <td>Outstanding Receivables</td>
                <td>Unused Credits</td>
            </tr>
            @php
                $invoice_amount = 0;
                $received_amount = 0;
                foreach ($invoices as $key => $invoice) {
                    foreach($invoice as $key => $item){
                        $invoice_amount += $item->items($item->invoice_no)->sum('cost_price');
                        $received_amount  += $item->invoiceAmount->amount_from;
                    }
                }
            @endphp
            <tr class="border-bottom">
                <td>AED</td>
                <td>AED {{$invoice_amount}}</td>
                <td>AED {{$invoice_amount-$received_amount}}</td>
            </tr>
        </table>
        <div>
            <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
        </div>
    </div>
</div>
@foreach ($amount_list as $item)
    <input type="hidden" value="{{$item}}" class="amount_list">
@endforeach
@foreach ($date_list as $item)
    <input type="hidden" value="{{$item}}" class="date_list">
@endforeach
  