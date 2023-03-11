@extends('layouts.pdf.app')
@section('title', 'item-purchase print')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1>Purchase Order</h1>
                        </div>
                    </div>

                    <div class="row pt-4">
                        <div class="col-12 col-md-4 col-lg-4">
                            <p><strong>Purchase Order No: </strong>{{$purchase_info->purchase_no}}</p>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <p><strong>Ship Address: </strong>{{$supplier_info->address}}</p>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <p><strong>TRN: </strong>{{$purchase_info->trn_no}}</p>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <p><strong>TO: </strong>Cash Customer</p>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <p><strong>Paymode: </strong>{{$purchase_info->pay_mode}}</p>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <p><strong>Payment Date: </strong>{{$purchase_info->pay_date}}</p>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <p><strong>Purchase Order No: </strong>{{$purchase_info->purchase_no}}</p>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <p><strong>Date: </strong>{{date('d-m-Y', strtotime($purchase_info->date))}}</p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">                        
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Pur. Rate</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="tempLists">
                                @foreach ($purchase_items as $item)
                                <tr  style="line-height: 0;">
                                    <td>{{$item->itemName->barcode}}</td>
                                    <td>{{$item->itemName->item_name}}</td>
                                    <td>{{$item->brandName->name}}</td>
                                    <td>{{$item->purchase_rate}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{number_format((float)$item->total_amount, 2, '.', '') }}</td>
                                </tr>
                                @endforeach
                                <tr class="border-top" style="line-height: 0;">
                                    <td colspan="4" class="text-right">Amount (AED): </td>
                                    <td colspan="2">
                                        @php
                                            $amount = $purchase_items->sum('total_amount') - $purchase_items->sum('vat_amount');
                                        @endphp
                                            {{ number_format((float)$amount, 2, '.', '')}}
                                    </td>
                                </tr>
                                <tr style="line-height: 0;">
                                    <td colspan="4" class="text-right">VAT:</td>
                                    <td colspan="2">
                                        {{ number_format((float)$purchase_items->sum('vat_amount'), 2, '.', '')}}
                                    </td>
                                </tr>
                                <tr style="line-height: 0;">
                                    <td colspan="4" class="text-right">Net Amount (AED):</td>
                                    <td colspan="2">
                                        {{ number_format((float)$purchase_items->sum('total_amount'), 2, '.', '')}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

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
