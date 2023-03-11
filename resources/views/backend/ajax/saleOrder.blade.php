@foreach (App\SaleOrderItemTemp::where('sale_order_no',$invoice_draft->sale_order_no)->get() as $item)
<tr class="data-row">
	<td>{{ $i }}</td>
	<td>{{ $item->barcode }}</td>
	<td>{{ $item->item->item_name }}</td>
    <td>{{ $item->unit }}</td>

    <td>{{number_format((float)( $item->cost_price/$item->quantity),'3','.','') }}</td>
	<td>{{ $item->quantity }}</td>
	{{-- <td>{{ $item->unit_price }}</td> --}}
	{{-- <td>{{ $item->vat_rate }}</td> --}}
	{{-- <td></td> --}}
	{{-- <td>{{ $item->unit_price*$item->quantity }}</td> --}}
	<td>{{number_format((float)($item->cost_price),'2','.','') }}</td>

	<td class="text-right">

        {{-- <button class="btn btn-danger invoice-item-delete" >Delete</button> --}}
        <span class="btn btn-warning invoice-item-delete" id="" data_target="{{ route('itemDeleteSale',$item) }}"><i class="bx bx-trash"></i></span>


	</td>
</tr>
<?php $i++; ?>
@endforeach


