<div class="row">
    <div class="col-md-5">
        <div class="row">
            <div class="col-sm-5">
                <label for="">UPC</label>
                <input type="text" class="form-control item-select-by-term"
                    placeholder="Barcode" value="{{ $item->cc_code }}" name="barcode" id="barcode" autocomplete="off"
                    autofocus title="Barcode" data-id="barcode"
                    data-url="{{ route('selectItemByTerm') }}">
            </div>

            <div class="col-sm-7">
                <label for="">Item Name</label>
                <input type="text" value="{{ $item->cc_name }}" class="form-control" name="" id="name" id="">
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="row">
            <div class="col-sm-1">
                <label for="">QTY</label>
                <input type="number" value="1" class="form-control" name="" id="">
            </div>

            <div class="col-sm-3">
                <label for="">Unit Price</label>
                <input type="text" class="form-control" name="" id="">
            </div>

            <div class="col-sm-2">
                <label for="">Discount</label>
                <input type="text" class="form-control" name="" id="">
            </div>

            <div class="col-sm-3">
                <label for="">Net Amount</label>
                <input type="text" class="form-control" name="" id="">
            </div>

            <div class="col-sm-3">
                <label for="">Cost Price</label>
                <input type="text" class="form-control" name="" id="">
            </div>
        </div>
    </div>
</div>
