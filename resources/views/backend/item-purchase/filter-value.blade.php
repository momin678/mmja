@foreach ($product_purchases as $product_purchase)
<li><a href="{{route('item-purchase.show', $product_purchase->id)}}">{{$product_purchase->purchase_no}}</a></li>
<small>
    {{$product_purchase->gr_details_check($product_purchase->purchase_no)}}
    /{{$product_purchase->purchase_details->sum("quantity")}}
</small>
@endforeach