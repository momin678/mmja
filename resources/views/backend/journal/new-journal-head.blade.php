<div class="row justify-content-between every-form-row">
    <div class="col-md-4 col-sm-12">
        <label for="invoice_no">A/C Head</label>
        <select name="multi_acc_head" class="form-control common-select2 multi-acc-head input-due-payment">
            <option value="">Select A/C Head</option>
            @foreach ($acHeads as $item)
                <option value="{{ $item->id }}"
                    {{ isset($journalF) ? ($journalF->ac_head_id == $item->id ? 'selected' : '') : '' }}>
                    {{ $item->fld_ac_head }}</option>
            @endforeach
            
        </select>
    </div>
    <div class="col-md-2 col-sm-12">
        <label for="password">Total Amount</label>
        <input type="number" name="multi_total_amount" class="form-control amount_withvat inputFieldHeight" placeholder="Total Amount">
    </div>
    <div class="col-md-2 col-sm-12">
        <label for="password">Vat Rate</label>
        <select name="multi_tax_rate"  class="common-select2 form-control multi-tax-rate inputFieldHeight" style="width: 100% !important"
        required>
        @foreach ($vats as $item)
            <option value="{{ $item->id }}" >
                {{ $item->name }}</option>
        @endforeach
    </select>
    </div>

    <div class="col-md-2 col-sm-12">
        <label for="password">Amount</label>
        <input type="number" name="multi_amount" class="form-control amount_without_vat inputFieldHeight"  step="any" placeholder="Amount">
    </div>
    
    <div class="col-md-2 col-sm-12 form-group d-flex align-items-center pt-2">
        {{-- <button class="btn btn-danger text-nowrap px-1" data-repeater-delete type="button"> <i class="bx bx-x"></i>
            Delete
        </button> --}}
        <button type="button" class="btn btn-danger formButton mDeleteIcon" data-repeater-delete title="Delete">
            <div class="d-flex">
                <div class="formSaveIcon">
                    <img  src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" alt="" srcset=""  width="25">
                </div>
                <div><span> Delete</span></div>
            </div>
        </button>
    </div>
</div>