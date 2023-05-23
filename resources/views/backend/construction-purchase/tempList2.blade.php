@foreach ($temp_items as $item)
<tr  class="data-row">
    <td>{{$item->itemName->item_name}}</td>
    <td>{{$item->vatRate->name}}</td>
    <td>{{$item->purchase_rate}}</td>
    <td>{{$item->quantity}}</td>
    <td>{{number_format((float)$item->purchase_rate*$item->quantity, 2, '.', '') }}</td>
    <td>
        <button class="btn btn-warning sm-btn row-edit" value="{{$item->id}}" id="{{$item->id}}"> <i class="bx bx-edit"></i> </button>
        <button class="btn btn-danger sm-btn row-delete" value="{{$item->id}}"> <i class="bx bx-trash"></i> </button>
    </td>
</tr>
@endforeach
<tr class="border-top">
    <td colspan="4" class="text-right">Amount (AED): </td>
    <td colspan="2">
        @php
            $amount = $temp_items->sum('total_amount') - $temp_items->sum('vat_amount');
        @endphp
        <input type="number" step="0.1" id="net_amount" name="net_amount" class="form-control" value="{{ number_format((float)$amount, 2, '.', '')}}" readonly>
    </td>
</tr>
<tr>
    <td class="text-right" colspan="4">Discount Type:</td>
    <td colspan="2">
        <select name="discount_type" id="discount_type" class="form-control">
            <option value="">Select Option</option>
            <option value="Percentage">Percentage</option>
            <option value="Fixed">Fixed</option>
        </select>
    </td>
</tr>
<tr>
    <td colspan="4" class="text-right">Discount Value</td>
    <td colspan="2">
        <input type="number" step="0.1" id="discount_amount" name="discount_amount" class="form-control">
    </td>
</tr>
<tr> 
    <td colspan="4" class="text-right">VAT:</td>
    <td colspan="2">
        <input type="number" step="0.1" id="total_vat_amount" name="total_vat_amount" class="form-control" value="{{ number_format((float)$temp_items->sum('vat_amount'), 2, '.', '')}}" readonly>
    </td>
</tr>
<tr>
    <td colspan="4" class="text-right">Grand Total (AED):</td>
    <td colspan="2">
        <input type="number" step="any" id="grand_amount" class="form-control" readonly value="{{number_format((float)$temp_items->sum('total_amount'), 2, '.', '')}}">
    </td>
</tr>