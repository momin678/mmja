<ul>
    @foreach ($invoicess as $invoice)
    <li><a href="{{ route('invoiceView', $invoice) }}">{{ $invoice->invoice_no }}</a></li>

    @endforeach
</ul>


