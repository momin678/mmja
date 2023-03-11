<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Barcode</th>
            <th>Item Name</th>
            <th>Sale Price</th>
            <th>Vat</th>
            <th>QTY</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="">

@foreach (App\SaleOrderItemTemp::where('sale_order_no',$invoice_draft->sale_order_no)->get() as $item)
<tr class="data-row">
	<td>{{ $i }}</td>
	<td>{{ $item->barcode }}</td>
	<td>{{ $item->item->item_name }}</td>

    <td>{{ $item->unit_price}}</td>
<td>{{ $item->vat_rate }}</td>
    <td>{{ $item->quantity }}</td>
	{{-- <td>{{ $item->unit_price }}</td> --}}
	{{-- <td>{{ $item->vat_rate }}</td> --}}
	{{-- <td></td> --}}
	{{-- <td>{{ $item->unit_price*$item->quantity }}</td> --}}
	<td>{{ $item->cost_price }}</td>

	<td class="text-right">

        {{-- <button class="btn btn-danger invoice-item-delete" >Delete</button> --}}
        <span class="btn btn-warning invoice-item-delete" id="" data_target="{{ route('itemDeleteSale',$item) }}"><i class="bx bx-trash"></i></span>


	</td>
</tr>
<?php $i++; ?>
@endforeach

</tbody>



</table>
