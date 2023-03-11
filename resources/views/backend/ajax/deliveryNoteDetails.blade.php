<div class="col-md-12">

  <form action="{{ route('generateDeliveryNote', $invoice) }}" method="POST" onsubmit="return confirm('Are you confirm the item quantity?')">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card d-flex align-items-center" style="min-height: 180px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2 form-group">
                            <label for="">Branch</label>
                            <select name="branch" class="form-control" id="" readonly>
                                <option value="">Select...</option>
                                @foreach ($projects as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $invoice->project_id == $item->id ? 'selected' : '' }}>{{ $item->proj_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 form-group d-none">
                            <label for="">GL Code</label>
                            <input type="text" name="gl_code" id="gl_code" value="{{ $invoice->gl_code }}"
                                class="form-control" disabled>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="">Date</label>
                            <input type="date" value="{{ $invoice->date }}" class="form-control" name="date"
                                id="date" readonly disabled>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="">Sale Order No</label>
                            <input type="text" class="form-control" value="{{ $invoice->sale_order_no }}"
                                name="invoice_no" id="invoice_no" readonly disabled>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="">Customer Name</label>
                            <select name="customer_name" id="customer_name" class="form-control party-info"
                                data-target="" readonly disabled>
                                <option value="">Select...</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->cc_code }}"
                                        {{ $invoice->customer_name == $customer->pi_code ? 'selected' : '' }}>
                                        {{ $customer->pi_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="">TRN No</label>
                            <input type="text" class="form-control" value="{{ $invoice->trn_no }}" name="trn_no"
                                id="trn_no" class="form-control" readonly disabled>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="">Contact Number</label>
                            <input type="text" value="{{ $invoice->contact_no }}" class="form-control"
                                name="contact_no" id="contact_no" readonly disabled>
                        </div>

                        <div class="col-sm-3 form-group">
                            <label for="">Shipping Address</label>

                                <textarea name="address" class="form-control" readonly disabled>{{ $invoice->address }}</textarea>

                        </div>
                        <div class="col-sm-4 form-group">

                                <div class="row">
                                    <div class="col-8">
                                        <label for="">Delivery Note No</label>
                                        <input type="text" name="note_no" class="form-control"
                                            value="{{ isset($invoice->dNote)? $invoice->dNote->deliveryNote->delivery_note_no:  $no }}"
                                            id="" required  readonly>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Barcode</th>
                    <th>Item Name</th>
                    <th>QTY <small>Delivered / Ordered</small></th>

                </tr>
            </thead>
            <tbody class="all-data-area">
                @foreach (App\SaleOrderItem::where('sale_order_no', $invoice->sale_order_no)->orderBy('barcode','DESC')->get() as $item)
                    <tr class="data-row">
                        <td>{{ $i }}</td>
                        <td class="d-none"> <input type="text" name="items[{{ $item->id }}][id]" value="{{ $item->id }}" id=""> </td>
                        <td class="d-none"> <input type="text" name="items[{{ $item->id }}][item_id]" value="{{  $item->item->id}}" id=""> </td>
                        <td class="d-none"> <input type="text" name="items[{{ $item->id }}][style_id]" value="{{  $item->style_id}}" id=""> </td>
                        <td class="d-none"> <input type="text" name="items[{{ $item->id }}][size]" value="{{  $item->size}}" id=""> </td>
                        <td class="d-none"> <input type="text" name="items[{{ $item->id }}][color_id]" value="{{  $item->color_id}}" id=""> </td>

                        <td>{{ $item->barcode }}</td>
                        <td>{{ $item->item->item_name }}</td>
                        <td>
                            <div class="row">
                                <div class="col-3 d-flex align-items-center" style="white-space: nowrap;">
                                 {{ $item->deliverQuantity() }}/   {{ $item->quantity }}
                                </div>
                                <div class="col-7">
                                    <input type="number" name="items[{{ $item->id }}][quantity]" placeholder="Deliverable Item Quantity: {{ $item->quantity-$item->deliverQuantity() }}" value="{{ $item->quantity-$item->deliverQuantity() }}" class="form-control {{ $item->quantity<=$item->deliverQuantity()?'d-none':'' }}" max="{{ $item->quantity-$item->deliverQuantity() }}" min="0" id="">                                </div>
                                </div>
                                </div>
                        </td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row pt-2">
        <div class="col-12 text-center">

                <button class="btn btn-primary" type="submit" {{ $invoice->deliverItemQuantity()- $invoice->saleItemQuantity()==0?'disabled readonly':'' }}>{{ $invoice->deliverItemQuantity()- $invoice->saleItemQuantity()==0?'Completed':'Generate Delivery Note' }} </button>

        </div>
    </div>
  </form>

</div>
