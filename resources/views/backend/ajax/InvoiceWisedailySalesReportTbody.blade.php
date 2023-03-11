@php
$grand_total_taxable=0;
$grand_total_vat=0;
$grand_total_amount=0;
@endphp
@foreach ($invoicess as $inv)
    <tr>
        <td>{{ $inv->invoice_no }}</td>
        <td>{{ $inv->date }}</td>
        <td>{{ $inv->pay_mode }}</td>
        <td>{{$txable=number_format((float)( App\InvoiceItem::where('invoice_id',$inv->id)->sum('total_unit_price')), 2,'.','')    }}</td>
        <td>{{$vat=number_format((float)(  App\InvoiceItem::where('invoice_id',$inv->id)->sum('vat_amount')), 2,'.','')   }}</td>
        <td>{{$total=number_format((float)(App\InvoiceItem::where('invoice_id',$inv->id)->sum('cost_price')), 2,'.','')   }}</td>
        <td> {{ $inv->invoiceAmount ? number_format((float) $inv->invoiceAmount->amount_from, 2, '.', '') : '0.00' }}</td>
        <td>{{ $inv->invoiceAmount ? ($inv->invoiceAmount->amount_to > 0 ? number_format((float) $inv->invoiceAmount->amount_to, 2, '.', '') : '0.00') : '0.00' }}</td>

    </tr>
    @php
    $grand_total_taxable=$grand_total_taxable+$txable;
    $grand_total_vat=$grand_total_vat+$vat;
    $grand_total_amount=$grand_total_amount+$total;
@endphp
@endforeach
<tr>
    <td colspan="3" style="text-center">Grand Total</td>
    <td>{{ number_format((float)$grand_total_taxable,'2','.','')}}</td>
    <td>{{ number_format((float)$grand_total_vat,'2','.','')}}</td>
    <td>{{ number_format((float)$grand_total_amount,'2','.','')}}</td>

</tr>
