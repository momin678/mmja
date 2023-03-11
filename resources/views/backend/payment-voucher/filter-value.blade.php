@foreach ($payment_voucher as $each_item)
    <li><a href="{{route('approve-pv-view', $each_item->id)}}">{{$each_item->payment_voucher_no}}</a></li>
@endforeach