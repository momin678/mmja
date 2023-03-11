@foreach ($temp_items as $item)
    <tr class="data-row">
        <td>
            {{$item->itemName->barcode}}
        </td>
        <td>
            {{$item->itemName->item_name}}
        </td>
        <td>{{$item->itemName->brandName->name}}</td>
        <td>
            {{$item->itemName->group_name}}
        </td>
        <td>
            {{$item->received_qty}}
        </td>
        <td>
            {{$item->return_qty}}
        </td>
        <td>
            {{$item->comment}}
        </td>
        <td>
            <a href="{{ route('temp-return-item-list-delete', $item->id)}}" class="btn btn-danger sm-btn"> <i class="bx bx-trash"></i> </a>
        </td>
    </tr>
@endforeach