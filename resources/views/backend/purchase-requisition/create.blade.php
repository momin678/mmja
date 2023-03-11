@extends('layouts.backend.app')

@section('title', 'purchase requisition create')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 card">
                        <div class="card-body">
                            <form action="{{route('item-purchase.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="border-bottom">
                                    <h4>Purchase</h4>
                                </div>
                                    <div class="row">
                                        <div class="col-sm-3 col-12 mb-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type" id="TaxInvoice" value="Tax Invoice">
                                                <label class="form-check-label" for="TaxInvoice">
                                                Tax Invoice
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type" id="PO" value="PO">
                                                <label class="form-check-label" for="PO">
                                                PO
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-12 mb-1">
                                            <label for="item_type_no">PO List</label>
                                            <select name="po_list" id="po_list" class="form-control">
                                                <option value=""></option>
                                                
                                            </select>
                                            @error('po_list')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 col-12 mb-1">
                                            <label for="project_id">Branch Name</label>
                                            <select name="project_id" id="project_id" class="form-control" required>
                                                <option value=""></option>
                                                @foreach ($projects as $project)
                                                    <option value="{{$project->id}}">{{$project->proj_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('project_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-3 col-12 mb-1">
                                            <label for="tax_invoice_date">Tax Invoice Date</label>
                                            <input type="date" required class="form-control curentDate" name="tax_invoice_date" id="tax_invoice_date" value="{{old('tax_invoice_date')}}">
                                            @error('tax_invoice_date')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 col-12 mb-1">
                                            <label for="mode">Serial No</label>
                                            @php
                                            $item_list_id_value = '';
                                            $item_list_id = App\ProductPurchase::max('serial_no');
                                                if($item_list_id){
                                                    $item_list_id_value = ($item_list_id + 1);
                                                }else {
                                                    $item_list_id_value = 1001;
                                                }
                                            @endphp
                                            <input type="text" required value="{{$item_list_id_value}}" readonly class="form-control" name="serial_no" id="serial_no">
                                        </div>
                                    </div>
                                <div class="border-bottom">
                                    <h5 class="card-title ">Receipt Details</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 col-12 mb-1">
                                        <label for="mode">Supplier Name</label>
                                        <select name="supplier_id" id="supplier_id" required class="form-control">
                                            <option value=""></option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{$supplier->id}}">{{$supplier->cc_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3 col-12 mb-1">
                                        <label for="trn">TRN</label>
                                        <input type="text" name="trn" class="form-control" id="trn" readonly>
                                        @error('trn')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-5 col-12 mb-1">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" class="form-control" id="address" readonly>
                                        @error('address')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2 col-12 mb-1">
                                        <label for="pay_mode">Pay Mode</label>
                                        <select name="pay_mode" id="pay_mode" class="form-control" required>
                                            <option value=""></option>
                                            @foreach ($payMode as $payMode)
                                                <option value="{{$payMode->title}}" {{ old('pay_mode') == $payMode->title ? "selected" : "" }}>{{$payMode->title}}</option>                                                    
                                            @endforeach
                                        </select>
                                        @error('pay_mode')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2 col-12 mb-1">
                                        <label for="pay_term">Pay Terms</label>
                                        <select name="pay_term" id="pay_term" class="form-control" required>
                                            <option value=""></option>
                                            @foreach ($payTerms as $payTerm)
                                                <option value="{{$payTerm->value}}" {{ old('pay_term') == $payTerm->title ? "selected" : "" }}>{{$payTerm->title}}</option>                                                    
                                            @endforeach
                                        </select>
                                        @error('pay_term')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2 col-12 mb-1">
                                        <label for="pay_date">Pay Date</label>
                                        <input type="date" name="pay_date" class="form-control" id="pay_date" readonly>                                    
                                        @error('pay_date')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3 col-12 mb-1">
                                        <label for="tax_invoice_no">Quotation / Reference No</label>
                                        <input type="text" required class="form-control" name="tax_invoice_no" id="tax_invoice_no" value="{{old('tax_invoice_no')}}">
                                        @error('tax_invoice_no')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3 col-12 mb-1">
                                        <label for="contact_no">Contact No</label>
                                        <input type="text" required class="form-control" name="contact_no" id="contact_no" value="{{old('contact_no')}}" readonly>
                                        @error('contact_no')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="border-bottom">
                                    <h5 class="card-title ">Product Information</h5>
                                </div>
                                    <div class="row">
                                        <div class="col-sm-3 col-12 mb-1">
                                            <label for="brand_id">Brand</label>
                                            <select name="brand_id" id="brand_id" class="form-control">
                                                <option value=""></option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{$brand->id}}" {{ old('brand_id') == $brand->name ? "selected" : "" }}>{{$brand->name}}</option>                                                    
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="brandErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-3 col-12 mb-1">
                                            <label for="mode">Group ID</label>
                                            <select name="group_id" id="group_id" class="form-control">
                                                <option value=""></option>
                                                @foreach ($groups as $group)
                                                    <option value="{{$group->id}}" {{ old('group') == $group->item_type ? "selected" : "" }}>{{$group->item_type}}</option>                                                    
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="groupErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-3 col-12 mb-1">
                                            <label for="mode">Item List</label>
                                            <select name="item_list_id" id="item_list_id" class="form-control">
                                                <option value=""></option>
                                                @foreach ($itemLists as $itemList)
                                                    <option value="{{$itemList->id}}" {{ old('item_list_id') == $itemList->item_name ? "selected" : "" }}>{{$itemList->item_name}}</option>                                                    
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="itemListErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-3 col-12 mb-1">
                                            <label for="shipping_id">Shipping ID</label>
                                            <input type="text" class="form-control" name="shipping_id" id="shipping_id" value="{{old('shipping_id')}}">
                                            <span class="text-danger" id="shippingErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-3 col-12 mb-1">
                                            <label for="purchase_rate">Purchase Rate</label>
                                            <input type="number" class="form-control" name="purchase_rate" id="purchase_rate" value="{{old('purchase_rate')}}">
                                            <span class="text-danger" id="purchaseRateErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-2 col-12 mb-1">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control" name="quantity" id="quantity" value="{{old('quantity')}}">
                                            <span class="text-danger" id="quantityErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-2 col-12 mb-1">
                                            <label for="mode">Unit</label>
                                            <select name="unit" id="unit" class="form-control">
                                                <option value=""></option>
                                                @foreach ($units as $unit)
                                                    <option value="{{$unit->name}}" {{ old('unit') == $unit->name ? "selected" : "" }}>{{$unit->name}}</option>                                                    
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="unitErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-2 col-12 mb-1">
                                            <label for="mode">Vat Rate</label>
                                            <select name="vat_rate" id="vat_rate" class="form-control">
                                                <option value=""></option>
                                                @foreach ($vatRates as $vatRate)
                                                    <option value="{{$vatRate->name}}" {{ old('vat_rate') == $vatRate->name ? "selected" : "" }}>{{$vatRate->name}}</option>                                                    
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="vatRateErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-3 col-12 mb-1">
                                            <label for="taxable_supplies">Taxable Supplies</label>
                                            <input type="number" class="form-control" name="taxable_supplies" id="taxable_supplies" value="{{old('taxable_supplies')}}">
                                            <span class="text-danger" id="taxableSuppliesRateErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-3 col-12 mb-1">
                                            <label for="vat_amount">Vat Amount</label>
                                            <input type="number" class="form-control" name="vat_amount" id="vat_amount" value="{{old('vat_amount')}}">
                                            <span class="text-danger" id="vatAmountRateErrorMsg"></span>
                                        </div>
                                        <div class="col-sm-3 col-12 mb-1">
                                            <label for="total_amount">Total Amount</label>
                                            <input type="number" class="form-control" name="total_amount" id="total_amount" value="{{old('total_amount')}}" readonly>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end mb-1">
                                            <button class="btn btn-primary" id="add_product">Add Product</button>
                                        </div>
                                    </div>
                                <table class="table table-striped mt-2 border">
                                    <thead class="">
                                        <tr>
                                            <th scope="col">Item Name</th>
                                            <th scope="col">Brand</th>
                                            <th scope="col">Shipment ID</th>
                                            <th scope="col">Pur. Rate</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tempLists">
                                        @isset($item_list_id)
                                            @php
                                                $temp_items = App\TempItemStore::where('serial_id', $item_list_id_value)->get();
                                            @endphp
                                        @endisset
                                        @isset($temp_items)
                                            @foreach ($temp_items as $item)
                                            <tr>
                                                <td>{{$item->itemName->item_name}}</td>
                                                <td>{{$item->brandName->name}}</td>
                                                <td>{{$item->shipping_id}}</td>
                                                <td>{{$item->purchase_rate}}</td>
                                                <td>{{$item->quantity}}</td>
                                                <td>{{$item->total_amount}}</td>
                                                <td>{{$item->unit}}</td>
                                                <td>
                                                    <a href="{{ route('temp-item-list-delete', $item->id)}}" class="btn btn-danger sm-btn"> <i class="bx bx-trash"></i> </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                                <div class="col-12 d-flex justify-content-end mb-1">
                                    <button type="submit" class="btn btn-primary" id="add_product">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });
    document.getElementById('tax_invoice_date').valueAsDate = new Date();
    // pay days count
    let selectID = document.getElementById('pay_term');
    selectID.addEventListener('change', function(){
        let currentDate = new Date();
        let addNumberOfDays = this.value;
        var myDate = new Date(new Date().getTime()+(Number(addNumberOfDays)*24*60*60*1000));
        document.getElementById('pay_date').valueAsDate = new Date(myDate);
    });
     // supplier information
    $("#supplier_id").change(function (e) { 
        e.preventDefault();
        var supplier_id = $('#supplier_id option:selected').val();
        $.ajax({
            type:"post",
            url: "{{URL::to('supplier-information')}}",
            data:{
                "supplier_id":supplier_id
            },
            success:function(data){
                document.getElementById('trn').value = data.trn_no;
                document.getElementById('address').value = data.address;
                document.getElementById('contact_no').value = data.con_no;
            }
        });
    });
    // input information get    
    let serial_info = document.getElementById("serial_no");
    let brand_info = document.getElementById("brand_id");
    let group_info = document.getElementById("group_id");
    let item_list_info = document.getElementById("item_list_id");
    let shipping_id_val = document.getElementById("shipping_id");
    let purchase_rate_val = document.getElementById("purchase_rate");
    let quantity_val = document.getElementById("quantity");
    let unit_info = document.getElementById("unit");
    let vat_rate_info = document.getElementById("vat_rate");
    let taxable_supplies_info = document.getElementById("taxable_supplies");
    let vat_amount_val = document.getElementById("vat_amount");
    let total_amount_val = document.getElementById("total_amount");
    // total amount count
    purchase_rate_val.addEventListener('change', function(){
        let total_amount_get = Number((this.value * quantity_val.value)) + Number(vat_amount_val.value);
        total_amount_val.value = total_amount_get;

    });
    quantity_val.addEventListener('change', function(){
        let total_amount_get = Number((purchase_rate_val.value * this.value)) + Number(vat_amount_val.value);
        total_amount_val.value = total_amount_get;
    });
    vat_amount_val.addEventListener('change', function(){
        let total_amount_get = Number((quantity_val.value * purchase_rate_val.value)) + Number(this.value);
        total_amount_val.value = total_amount_get;
    });
    // temporary item store in table
    $('#add_product').on('click',function(e){
        e.preventDefault();
        $.ajax({
          url: "{{URL::to('temporary-item-list-store')}}",
          type:"post",
          data:{
            serial_id:serial_info.value,
            brand_id:brand_info.value,
            group_id:group_info.value,
            item_list_id:item_list_info.value,
            shipping_id:shipping_id_val.value,
            purchase_rate:purchase_rate_val.value,
            quantity:quantity_val.value,
            unit:unit_info.value,
            vat_rate:vat_rate_info.value,
            taxable_supplies:taxable_supplies_info.value,
            vat_amount:vat_amount_val.value,
            total_amount:total_amount_val.value,
          },
          success:function(response){
            document.getElementById("tempLists").innerHTML = response;
            brand_info.selectedIndex = 0;
            group_info.selectedIndex = 0;
            item_list_info.selectedIndex = 0;
            unit_info.selectedIndex = 0;
            vat_rate.selectedIndex = 0;
            quantity_val.value = '';
            purchase_rate_val.value = '';
            taxable_supplies.value = '';
            vat_amount.value = '';
            total_amount.value = '';
          },
            error: function(response) {
                if(response.responseJSON.errors.brand_id){
                    document.getElementById('brandErrorMsg').innerHTML = response.responseJSON.errors.brand_id;
                }else{
                    document.getElementById('brandErrorMsg').innerHTML = '';
                }
                if(response.responseJSON.errors.group_id){
                    document.getElementById('groupErrorMsg').innerHTML = response.responseJSON.errors.group_id;
                }else{
                    document.getElementById('groupErrorMsg').innerHTML = '';
                }
                if(response.responseJSON.errors.item_list_id){
                    document.getElementById('itemListErrorMsg').innerHTML = response.responseJSON.errors.item_list_id;
                }else{
                    document.getElementById('itemListErrorMsg').innerHTML = '';
                }
                if(response.responseJSON.errors.shipping_id){
                    document.getElementById('shippingErrorMsg').innerHTML = response.responseJSON.errors.shipping_id;
                }else{
                    document.getElementById('shippingErrorMsg').innerHTML = '';
                }
                if(response.responseJSON.errors.purchase_rate){
                    document.getElementById('purchaseRateErrorMsg').innerHTML = response.responseJSON.errors.purchase_rate;
                }else{
                    document.getElementById('purchaseRateErrorMsg').innerHTML = '';
                }
                if(response.responseJSON.errors.quantity){
                    document.getElementById('quantityErrorMsg').innerHTML = response.responseJSON.errors.quantity;
                }else{
                    document.getElementById('quantityErrorMsg').innerHTML = '';
                }
                if(response.responseJSON.errors.unit){
                    document.getElementById('unitErrorMsg').innerHTML = response.responseJSON.errors.unit;
                }else{
                    document.getElementById('unitErrorMsg').innerHTML = '';
                }
                if(response.responseJSON.errors.vat_rate){
                    document.getElementById('vatRateErrorMsg').innerHTML = response.responseJSON.errors.vat_rate;
                }
                if(response.responseJSON.errors.taxable_supplies){
                    document.getElementById('taxableSuppliesRateErrorMsg').innerHTML = response.responseJSON.errors.taxable_supplies;
                }else{
                    document.getElementById('taxableSuppliesRateErrorMsg').innerHTML = '';
                }
                if(response.responseJSON.errors.vat_amount){
                    document.getElementById('vatAmountRateErrorMsg').innerHTML = response.responseJSON.errors.vat_amount;
                }else{
                    document.getElementById('vatAmountRateErrorMsg').innerHTML = '';
                }
            },
        });
    });
</script>
@endpush