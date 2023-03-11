@foreach ($itme_lists as $itme_list)
    <tr style="line-height: 0px;">
        <td>{{$itme_list->barcode}}</td>
        <td>{{$itme_list->item_name}}</td>
        <td>{{$itme_list->sell_price}}</td>
        <td>{{$itme_list->vat_amount}}</td>
        <td>{{$itme_list->total_amount}}</td>
        <td>
            <div class="btn-group mr-1 mb-1">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{route('item-list.edit', $itme_list->id)}}">Edit</a>
                        <a class="dropdown-item" href="{{route('item-list.show', $itme_list->id)}}">View</a>
                        <a class="dropdown-item" href="{{ route('item-list.item-delete', $itme_list->id)}}">Delete</a>
                    </div>
                </div>
            </div>
        </td>
    </tr>
@endforeach