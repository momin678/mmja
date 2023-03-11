<div class="col-md-12">

    <div class="row">
        <div class="col-12">
            <div class="card d-flex align-items-center" >
                <div class="card-body">
                    <div class="row">
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

                    <th>QTY</th>



                </tr>
            </thead>
            <tbody class="all-data-area">


               @foreach (App\SaleOrderItem::where('sale_order_no', $invoice->sale_order_no)->get() as $item)
               @foreach (App\DeliveryItem::where('delivery_note_id', $dnote)->where('sale_order_item_id', $item->id)->get() as $dn )
               <tr class="data-row">
                   <td>{{ $i }}</td>
                   <td>{{ $item->barcode }}</td>
                   <td>{{ $item->item->item_name }}</td>
                   <td>{{ $dn->quantity }}</td>


               </tr>
               <?php $i++; ?>
           @endforeach

               @endforeach

            </tbody>



        </table>
    </div>

    <div class="row">
        <div class="col-12 text-center">
            <a href="{{ route('deliveryNotePrint', $dnote) }}" class="btn btn-sm btn-secondary"
                target="_blank">Print</a>


        </div>
    </div>
    </form>
</div>
