@foreach ($return_lists as $return)
    <li><a href="{{route('pt-details', $return->id)}}">{{$return->purchase_return_no}}</a></li>
@endforeach