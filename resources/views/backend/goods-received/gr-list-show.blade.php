@foreach ($purchaseRequisitions as $received)
<li><a href="{{route('gr-details', $received->id)}}">{{$received->goods_received_no}}</a></li>
@endforeach