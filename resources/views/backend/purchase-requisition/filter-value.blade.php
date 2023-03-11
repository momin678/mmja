@foreach ($purchaseRequisitions as $product_purchase)
    <li><a href="{{route('purchase-requisition.show', $product_purchase->id)}}">{{$product_purchase->purchase_no}}</a></li>
@endforeach