@foreach ($temp_items as $item)
<tr  class="data-row">
    <td>{{$item->itemName->barcode}}</td>
    <td>{{$item->itemName->item_name}}</td>
    <td>{{$item->unit}}</td>
    <td>{{$item->quantity}}</td>
    <td>
        <a href="{{ route('temp-item-list-delete', $item->id)}}" class="btn btn-danger sm-btn"> <i class="bx bx-trash"></i> </a>
    </td>
</tr>
@endforeach