<ul>
    @foreach ($saleReturns as $invoice)
    <li><a href="{{ route('saleReturnPrint', $invoice->invoice_no) }}">{{ $invoice->invoice_no }}</a></li>

    @endforeach
</ul>
