@foreach ($itemLists as $itemList)
    <option value="{{$itemList->id}}" {{ $barcode == $itemList->barcode ? "selected" : "" }} id="{{$itemList->barcode}}">{{$itemList->item_name}}</option>
@endforeach