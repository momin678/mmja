<table>
    <tr>
        <td>Item name</td>
        <td>Item PO Price</td>
        <td>Item FIFO Price</td>
    </tr>
    @foreach ($po_items as $item)
    @php
        $po_id = App\Purchase::where('purchase_no', $item->purchase_no)->first();
    @endphp
        <tr>
            <td style="{{number_format((float)( $item->purchase_rate+(($item->purchase_rate*5)/100)), 3,'.','') == App\Fifo::where('purchase_id', $po_id->id)->where('item_id', $item->item_id)->first()->unit_cost_price ? "" : "color:red;"}}">{{$item->itemName->item_name}}</td>
            <td>{{$item->purchase_rate+(($item->purchase_rate*5)/100)}}</td>
            <td>{{App\Fifo::where('purchase_id', $po_id->id)->where('item_id', $item->item_id)->first()->unit_cost_price}}</td>
        </tr>
    @endforeach
</table>
<a href="{{route('fifo-update-submit')}}" class="">update</a>