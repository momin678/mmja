<label class="invoice-label" for="">Item Name</label>
<select name="item_name" id="item_name" class="form-control">
    <option value="">Select</option>
    @foreach ($items as $itm)
    <option value="{{ $itm->barcode }}" {{ $itm->barcode== $item->barcode? "selected":"" }}>{{ $itm->item_name }}</option>
    @endforeach
</select>
