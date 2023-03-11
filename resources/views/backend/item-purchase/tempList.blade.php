@foreach ($temp_items as $item)
<tr  class="data-row">
    <td>{{$item->itemName->barcode}}</td>
    <td>{{$item->itemName->item_name}}</td>
    <td>{{$item->brandName->name}}</td>
    <td>{{$item->vatRate->name}}</td>
    <td>{{$item->purchase_rate}}</td>
    <td>{{$item->quantity}}</td>
    <td>{{number_format((float)$item->total_amount, 2, '.', '') }}</td>
    <td>
        <button class="btn btn-warning sm-btn row-edit" value="{{$item->id}}" id="{{$item->id}}"> <i class="bx bx-edit"></i> </button>
        <button class="btn btn-danger sm-btn row-delete" value="{{$item->id}}"> <i class="bx bx-trash"></i> </button>
    </td>
</tr>
@endforeach
<tr class="border-top">
    <td colspan="6"  class="text-right">Amount (AED): </td>
    <td colspan="2">
        @isset($temp_items)
        @php
            $amount = $temp_items->sum('total_amount') - $temp_items->sum('vat_amount');
        @endphp
        {{ number_format((float)$amount, 2, '.', '')}}
        @endisset
    </td>
</tr>
<tr> 
    <td colspan="6" class="text-right">VAT:</td>
    <td colspan="2">
        @isset($temp_items)
            {{ number_format((float)$temp_items->sum('vat_amount'), 2, '.', '')}}
        @endisset
    </td>
</tr>
<tr>
    <td colspan="6" class="text-right">Net Amount (AED):</td>
    <td colspan="2">
        @isset($temp_items)
        {{number_format((float)$temp_items->sum('total_amount'), 2, '.', '') }}
        @endisset
    </td>
</tr>