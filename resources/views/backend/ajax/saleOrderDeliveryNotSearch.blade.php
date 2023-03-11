@foreach ($sales as $item)
<div class="col-md-12 btn {{$item->deliveryNoteSale ? 'btn-light' : 'btn-light' }}  mx-1 mb-1 text-center" id="sale-order-details" data_target="{{ route('saleOrderDetails',$item) }}">
    {{ $item->delivery_note_no }} <small>{{ $item->deliverItemQuantity() }}/{{ $item->saleItemQuantity() }}</small>
</div>
@endforeach

@if($sales->count()<1)
<div class="col-md-12 text-center">
    <span>No Result Found</span>
</div>
@endif

