@foreach ($rvs as $item)
    <li><a href="{{route("receipt-voucher.show", $item->id)}}">{{$item->rv_no}}</a></li>
@endforeach