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
            <p class="mt-1"><b>Purchase Orders Details by Vendor of {{$vendor->pi_name}}</b></p>
        </div>
        <div class="print-menu">
            <a href="#" class="btn btn-sm btn-info float-right" onclick="window.print()">Print</a>
            <a href="{{route('pov-pdf-download', $vendor->id)}}" class="btn btn-sm btn-info float-right ml-1 mr-1">PDF Download</a>
            <a href="{{route('pov-excel-download', $vendor->id)}}" class="btn btn-sm btn-info float-right ml-1 ">Excel Download</a>
        </div>
        <table class="table table-sm exprortTable">
            <thead>
                <tr class="party-info">
                    <th>Date</th>
                    <th>Bill#</th>
                    <th>Due Date</th>
                    <th class="text-center">Vat</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Paid Balance</th>
                    <th class="text-center">Balance Due</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $purchase)
                    <tr>
                        <td>{{$purchase->date}}</td>
                        <td>{{$purchase->purchase_no}}</td>
                        <td>{{$purchase->pay_date}}</td>
                        <td class="text-right pr-2"><small>(AED)</small> {{number_format($purchase->purchase_details->sum('vat_amount'),2)}}</td>
                        <td class="text-right pr-2"><small>(AED)</small> {{number_format($purchase->purchase_details->sum('total_amount'),2)}}</td>
                        <td class="text-right pr-2"><small>(AED)</small> {{number_format($purchase->paid_amount->sum('paid_amount'),2)}}</td>
                        <td class="text-right pr-2"><small>(AED)</small> {{number_format($purchase->purchase_details->sum('total_amount')-$purchase->paid_amount->sum('paid_amount'),2)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
  