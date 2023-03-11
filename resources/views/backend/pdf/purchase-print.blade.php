@extends('layouts.pdf.app')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
@endphp
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <section id="widgets-Statistics">
                    <div class="row">
                        {{-- <div class="col-12 text-center">
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
                        </div> --}}

                        <div class="col-12 text-center pt-3">
                            <h1>Purchase Order</h1>
                        </div>
                    </div>

                    <div class="row pt-4">
                        <div class="col-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p><strong>Purchase Order No:</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <p>{{$purchase_info->purchase_no}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>SHIP ADDRESS:</strong> </p>
                                        </div>
                                        <div class="col-6">
                                            <p>{{$supplier_info->address}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>TRN:</strong> </p>
                                        </div>
                                        <div class="col-6">
                                            <p>{{$supplier_info->trn_no}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>CONTACT NO:</strong> </p>
                                        </div>
                                        <div class="col-6">
                                            {{$supplier_info->con_no}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>TO:</strong> </p>
                                        </div>
                                        <div class="col-6">
                                            <p>CASH CUSTOMER</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>PAYMODE:</strong> </p>
                                        </div>
                                        <div class="col-6">
                                            <p>{{$purchase_info->pay_mode}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>DATE:</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <p>{{$purchase_info->pay_date}}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
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
                                    <td>{{$item->total_amount}}</td>
                                </tr>
                                @endforeach
                                <tr class="border-top" style="line-height: 0;">
                                    <td colspan="4" class="text-right">Net Amount: </td>
                                    <td colspan="2">
                                        {{ $purchase_items->sum('total_amount') - $purchase_items->sum('vat_amount')}}
                                    </td>
                                </tr>
                                <tr style="line-height: 0;">
                                    <td colspan="4" class="text-right">Vat:</td>
                                    <td colspan="2">
                                        {{$purchase_items->sum('vat_amount')}}
                                    </td>
                                </tr>
                                <tr style="line-height: 0;">
                                    <td colspan="4" class="text-right">Total Gross:</td>
                                    <td colspan="2">
                                        {{$purchase_items->sum('total_amount')}}
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
