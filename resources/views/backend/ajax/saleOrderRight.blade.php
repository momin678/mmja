<ul>
    @foreach ($invoicess as $invoice)
    <li><a href="{{ route('saleOrderView',$invoice) }}" class="btn btn-light {{ $invoice->hasTaxInvoice? 'bx bx-check font-small-2':'' }} btn-sm">{{ $invoice->sale_order_no }}</a></li>

    @endforeach

    @if ($invoicess->count()==0)
        <span class="text-red">No Result</span>
    @endif
</ul>


