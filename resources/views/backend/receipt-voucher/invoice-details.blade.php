@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
    .invoice-label{
        font-size: 10px !important
    }
</style>
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <h4>Tax Invoice</h4>
                                <hr>
                            </div>
                            <form action="{{ route('finalSaveInvoice') }}" method="POST" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card d-flex align-items-center" style="min-height: 180px">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Project Name</label>
                                                        <input type="text" class="form-control" readonly value="{{$invoice->project->proj_name}}">
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">GL Code</label>
                                                       <input type="text" name="gl_code" id="gl_code" value="{{ $invoice->gl_code }}" class="form-control" disabled>

                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Date</label>
                                                        <input type="date"
                                                            value="{{ $invoice->date }}"
                                                            class="form-control" name="date" id="date" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Tax Invoice No</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $invoice->invoice_no }}" name="invoice_no"
                                                            id="invoice_no" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Customer Name</label>
                                                        <input type="text" readonly class="form-control" value="{{$invoice->partyInfo($invoice->customer_name)->pi_name}}">
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">TRN</label>
                                                        <input type="text" class="form-control" value="{{  $invoice->trn_no }}" name="trn_no" id="trn_no"
                                                            class="form-control" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Mode</label>
                                                        <input type="text" class="form-control" value="{{  $invoice->paymode }}" name="trn_no" id="trn_no"
                                                            class="form-control" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Terms </label>
                                                        <select name="pay_terms" id="pay_terms" class="form-control"
                                                            readonly disabled>
                                                            <option value="">Select...</option>

                                                            @foreach ($terms as $item)
                                                                <option value="{{ $item->value }}" {{ $invoice->pay_terms==$item->value? "selected":"" }}>{{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Due Date</label>
                                                        <input type="date" value="{{ $invoice->due_date }}" class="form-control" name="due_date"
                                                            id="due_date" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Contact Number</label>
                                                        <input type="text" value="{{ $invoice->contact_no }}" class="form-control" name="contact_no"
                                                            id="contact_no" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Shipping Address</label>
                                                        <input type="text" value="{{ $invoice->address }}" class="form-control" name="address"
                                                            id="address" readonly disabled>
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
                                                <th>Unit</th>
                                                <th>Unit Price</th>
                                                <th>Vat</th>
                                                <th>Discount</th>
                                                <th>Total Price </th>
                                            </tr>
                                        </thead>
                                        <tbody class="all-data-area">
                                            @foreach ($invoice_items as $i => $item)
                                            <tr class="data-row">
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $item->barcode }}</td>
                                                <td>{{ $item->item->item_name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->unit }}</td>
                                                <td>{{ $item->unit_price }}</td>
                                                <td>{{ $item->vat_amount }}</td>
                                                <td></td>
                                                <td>{{number_format((float)( $item->cost_price),'2','.','') }}</td>
                                            </tr>
                                            @endforeach
                                            <tr class="border-top">
                                                <td colspan="7" class="text-right">TAXABLE SUPPLIES (AED): </td>
                                                <td colspan="2">
                                                    {{number_format((float)( $invoice->taxbleSup($invoice->invoice_no)),'2','.','') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="text-right">VAT (AED):</td>
                                                <td colspan="2">
                                                    {{number_format((float)( $invoice->vat($invoice->invoice_no)),'2','.','') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="text-right">Total Gross (AED):</td>
                                                <td colspan="2">
                                                    {{number_format((float)( $invoice->grossTotal($invoice->invoice_no)),'2','.','') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <div class="row">
                                <div class="col-12">
                                 <a  class="btn btn-warning" href="{{ route('receipt-voucher-create', $invoice) }}">Process</a>
                                   <a href="{{ route('invoicePrint', $invoice) }}" class="btn btn-light" target="_blank">print</a>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
@endsection
