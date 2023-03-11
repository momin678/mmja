@foreach ($temp_items as $item)
<tr  class="data-row">
    <td>{{$item->itemName->barcode}}</td>
    <td>{{$item->itemName->item_name}}</td>
    <td>{{$item->unit}}</td>
    <td>{{$item->quantity}}</td>
    <td>
        <button class="btn btn-sm btn-danger row-delete" value="{{$item->id}}"> <i class="bx bx-trash"></i> </button>
    </td>
</tr>
@endforeach
<tr>
    <td colspan="4" class="text-right">Totale QTY:</td>
    <td>{{$temp_items->sum("quantity")}}</td>
</tr>