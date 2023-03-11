<div class="col-md-12">

    <div class="row">
        <div class="col-12">
            <div class="card d-flex align-items-center" style="min-height: 180px">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3 form-group">
                            <label for="">Branch</label>
                            <select name="branch" class="form-control" id="" readonly disabled>
                                <option value="">Select...</option>
                                @foreach ($projects as $item)
                                    <option value="{{ $item->proj_no }}"
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
                        <div class="col-sm-3 form-group">
                            <label for="">Date</label>
                            <input type="date" value="{{ $invoice->date }}" class="form-control" name="date"
                                id="date" readonly disabled>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="">Sale Order No</label>
                            <input type="text" class="form-control" value="{{ $invoice->sale_order_no }}"
                                name="invoice_no" id="invoice_no" readonly disabled>
                        </div>
                        <div class="col-sm-3 form-group">
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
                        <div class="col-sm-3 form-group">
                            <label for="">TRN</label>
                            <input type="text" class="form-control" value="{{ $invoice->trn_no }}" name="trn_no"
                                id="trn_no" class="form-control" readonly disabled>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="">Payment Mode</label>
                            <select name="pay_mode" id="" class="form-control" readonly disabled>
                                <option value="">Select...</option>
                                @foreach ($modes as $item)
                                    <option value="{{ $item->title }}"
                                        {{ $invoice->pay_mode == $item->title ? 'selected' : '' }}>{{ $item->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="">Payment Terms </label>
                            <select name="pay_terms" id="pay_terms" class="form-control" readonly disabled>
                                <option value="">Select...</option>

                                @foreach ($terms as $item)
                                    <option value="{{ $item->value }}"
                                        {{ $invoice->pay_terms == $item->value ? 'selected' : '' }}>{{ $item->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="">Due Date</label>
                            <input type="date" value="{{ $invoice->due_date }}" class="form-control"
                                name="due_date" id="due_date" readonly disabled>
                        </div>

                        <div class="col-sm-3 form-group">
                            <label for="">Contact Number</label>
                            <input type="text" value="{{ $invoice->contact_no }}" class="form-control"
                                name="contact_no" id="contact_no" readonly disabled>
                        </div>

                        <div class="col-sm-3 form-group">
                            <label for="">Shipping Address</label>
                            <input type="text" value="{{ $invoice->address }}" class="form-control" name="address"
                                id="address" readonly disabled>
                        </div>
                        <div class="col-sm-4 form-group">
                            <form action="{{ route('asignDeliveryNote', $invoice) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <label for="">Delivery Note No</label>
                                        <input type="number" name="note_no" class="form-control" list="browsers"
                                            value="{{ isset($invoice->deliveryNoteSale) ? $invoice->deliveryNoteSale->deliveryNote->delivery_note_no : '' }}"
                                            id="" required  readonly disabled>
                                        <datalist id="browsers">
                                            @foreach ($notes as $item)
                                                <option value="{{ $item->delivery_note_no }}">
                                                    {{ $item->delivery_note_no }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    {{-- <div class="col-3 form-group">
                                        <label for=""></label>
                                        <button class="btn btn-primary" type="submit">Add</button>
                                    </div> --}}
                                </div>
                            </form>
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
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>QTY</th>

                    <th>Vat </th>
                    <th>Discount</th>
                    <th>Net Amount</th>
                    <th>Cost Price </th>

                </tr>
            </thead>
            <tbody class="all-data-area">


               @foreach (App\SaleOrderItem::where('sale_order_no', $invoice->sale_order_no)->get() as $item)
               @foreach (App\DeliveryItem::where('delivery_note_id', $dnote)->where('sale_order_item_id', $item->id)->get() as $dn )
               <tr class="data-row">
                   <td>{{ $i }}</td>
                   <td>{{ $item->barcode }}</td>
                   <td>{{ $item->item->item_name }}</td>
                   <td>{{ $item->unit }}</td>
                   <td>{{number_format((float)( $item->unit_price),'3','.','') }}</td>
                   <td>{{ $dn->quantity }}</td>

                   <td>{{number_format((float)(  $item->vat_amount/$item->quantity*$dn->quantity),'2','.','') }}</td>
                   <td></td>
                   <td>{{number_format((float)(  $item->cost_price/$item->quantity*$dn->quantity),'2','.','') }}</td>
                   <td>{{-- {{ $item->cost_price }} --}}</td>

               </tr>
               <?php $i++; ?>
           @endforeach

               @endforeach

            </tbody>



        </table>
    </div>

    <div class="row">
        <div class="col-12 text-center">
            <a href="{{ route('genTaxInvoiceDN', $dnote) }}" class="btn btn-sm btn-secondary" onclick="return confirm('Want to generate Tax invoice of this sale order? please, confirm.')"
                >Generate Tax Invoice</a>

        </div>
    </div>
    </form>
</div>
