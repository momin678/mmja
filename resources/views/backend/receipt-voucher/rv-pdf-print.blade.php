@extends('layouts.pdf.app')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
@endphp
@section('title', 'pv pdf print')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1>{{ $company_name->config_value }}</h1>
                            <h6>{{ $company_address->config_value }}</h6>
                            <div class="row">
                                <div class="col-6 text-right">
                                    <h6>Mobile {{ $company_tele->config_value }}</h6>
                                </div>
                                <div class="col-6 text-left">
                                    <h6>TRN: </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center pt-3">
                            <h1>Receipt Voucher</h1>
                        </div>
                    </div>

                    
                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">
                                    <div class="row">
                                        
                                        <div class="col-sm-3 col-12">
                                            <label for="mode">RV No</label>
                                            <p>{{$rv_info->rv_no}}</p>
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="mode">TI No</label>
                                            <p>{{$rv_info->tax_invoice->invoice_no}}</p>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">Project Name</label>
                                            <p>{{$rv_info->project->proj_name}}</p>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">GL Code</label>
                                           <p>{{ $rv_info->tax_invoice->gl_code }}</p>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">TI Date</label>
                                            <p>{{ $rv_info->tax_invoice->date }}</p>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">Tax Invoice No</label>
                                            <p>{{ $rv_info->tax_invoice->invoice_no }}</p>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">Customer Name</label>
                                            <p>{{$rv_info->partyInfo->pi_name}}</p>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">TRN</label>
                                            <p>{{ $rv_info->tax_invoice->trn_no }}</p>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">Payment Mode</label>
                                            <p>{{ $rv_info->tax_invoice->paymode }}</p>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">Payment Terms </label>
                                            <select name="pay_terms" id="pay_terms" class="form-control"
                                                readonly disabled>
                                                <option value="">Select...</option>

                                                @foreach ($terms as $item)
                                                    <option value="{{ $item->value }}" {{ $rv_info->tax_invoice->pay_terms==$item->value? "selected":"" }}>{{ $item->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">Due Date</label>
                                            <p>{{ $rv_info->tax_invoice->due_date }}</p>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">Contact Number</label>
                                            <p>{{ $rv_info->tax_invoice->contact_no }}</p>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">Shipping Address</label>
                                            <p>{{ $rv_info->tax_invoice->address }}</p>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label for="">RV Issu Date</label>
                                            <p>{{ date("d-m-y"), strtotime($rv_info->date) }}</p>
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
                                    @foreach ($rv_info->tax_invoice_items($rv_info->tax_invoice_id) as $i => $item)
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
                                            {{number_format((float)( $rv_info->tax_invoice_items($rv_info->tax_invoice_id)->sum("total_unit_price")),'2','.','') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">VAT (AED):</td>
                                        <td colspan="2">
                                            {{number_format((float)( $rv_info->tax_invoice_items($rv_info->tax_invoice_id)->sum("vat_amount")),'2','.','') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">Total Gross (AED):</td>
                                        <td colspan="2">
                                            {{number_format((float)( $rv_info->tax_invoice_items($rv_info->tax_invoice_id)->sum("vat_amount") + $rv_info->tax_invoice_items($rv_info->tax_invoice_id)->sum("total_unit_price")),'2','.','') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h5>Payment</h5>
                        <div class="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3 col-12">
                                        <label for="mode">Date</label>
                                        <p>{{$rv_info->date}}</p>
                                    </div>
                                    <div class="col-sm-3 col-12">
                                        <label for="mode">Method</label>
                                        <p>{{$rv_info->payment_method}}</p>
                                    </div>
                                    <div class="col-sm-3 col-12">
                                        <label for="mode">Pay Amount</label>
                                        <p>{{$rv_info->paid_amount}}</p>
                                    </div>
                                    <div class="col-sm-3 col-12">
                                        <label for="mode">Due Amount</label>
                                        <p>{{$rv_info->due_amount}}</p>
                                    </div>
                                    @if ($rv_info->payment_method == "Check")
                                        <div id="banck_information" class="col-12 col-md-12 col-sm-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-6 col-12">
                                                    <label for="mode">Check No</label>
                                                    <p>{{$rv_info->check_no}}</p>
                                                </div>                                            
                                                <div class="col-sm-6 col-12">
                                                    <label for="mode">Bank Name</label>
                                                    <p>{{$rv_info->bank_name}}</p>
                                                </div>                                            
                                                <div class="col-sm-6 col-12">
                                                    <label for="mode">Branch Name</label>
                                                    <p>{{$rv_info->branch_name}}</p>
                                                </div>
                                                <div class="col-sm-6 col-12">
                                                    <label for="customer_name">Supplier Name</label>
                                                    <p>{{$rv_info->customer_name}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row mt-5 pt-5">
                        <div class="col-12">
                            <div class="mt-5">
                                <div class="d-flex text-center" style="justify-content: space-between">
                                    <div>
                                        <h6>Prepared By:</h5>
                                        <h5>Mahidul Islam Bappi</h5>
                                    </div>
                                    <div>
                                        <h5>Endorsed By:</h5>
                                        <h5>Mohammad Habibur Rahman</h5>
                                    </div>
                                    <div>
                                        <h5>Authorized By:</h5>
                                        <h5>Md. Akhter Hossain</h5>
                                    </div>
                                    <div>
                                        <h5>Approved By:</h5>
                                        <h5>Salim Osman</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
