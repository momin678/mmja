@if (isset($itemReturn))
@foreach (App\SaleReturnTemp::where('invoice_no',$itemReturn->invoice_no)->get() as $item)
<tr class="data-row">
	<td>{{ $i }}</td>
	<td>{{ $item->barcode }}</td>
	<td>{{ $item->item->item_name }}</td>
    <td>{{ $item->unit }}</td>
	<td>{{$price= number_format((float)( $item->itemPrice($item->invoice_no,$item->item_id)->cost_price/$item->itemPrice($item->invoice_no,$item->item_id)->quantity),'3','.','') }}</td>
    <td>{{ $item->quantity }}</td>

	{{-- <td>{{number_format((float)( $item->vat_amount),'2','.','') }}</td> --}}
	<td>{{number_format((float)( $price*$item->quantity),'2','.','') }}</td>


	<td class="text-right">

        {{-- <button class="btn btn-danger invoice-item-delete" >Delete</button> --}}
        <span class="btn btn-warning invoice-item-delete" id="" data_target="{{ route('itemDelete',$item) }}"><i class="bx bx-trash"></i></span>


	</td>
</tr>
<?php $i++; ?>
@endforeach

@endif


