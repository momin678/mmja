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
                            <h1>Payment Voucher</h1>
                        </div>
                    </div>

                    <form action="{{route('payment-voucher.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 col-12">
                                        <label for="mode">PV No</label>
                                        <p>{{$pv_info->payment_voucher_no}}</p>
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <label for="mode">IP No</label>
                                        <p>{{$pv_info->ip_no}}</p>
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <label for="mode">Goods Received No</label>
                                        <p>{{$pv_info->goods_received_no}}</p>
                                        
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <label for="mode">PO No</label>
                                        <p>{{$pv_info->po_no}}</p>
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <label for="mode">PR No</label>
                                        <p>{{$pv_info->pr_no}}</p>
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <label for="mode">Supplier Name</label>
                                        <p>{{$pv_info->partInfo->pi_name}}</p>
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <label for="">PV Date:</label>
                                        <p>{{date('d-m-Y', strtotime($pv_info->date))}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">P Rate</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="tempLists"  class="user-table-body">
                                @foreach ($ip_items as $item)
                                <tr class="data-row">
                                    <td> {{$item->itemName->barcode}} </td>
                                    <td> {{$item->itemName->item_name}} </td>
                                    <td> {{$item->itemName->brandName->name}} </td>
                                    <td> {{$item->itemName->group_name}} </td>
                                    <td> {{$item->quantity}} </td>
                                    <td>{{ number_format((float)$item->purchase_rate, 3, '.', '')}}</td>
                                    <td>{{ number_format((float)$item->total_amount, 2, '.', '')}}</td>
                                </tr>
                                @endforeach
                                <tr class="border-top">
                                    <td colspan="5" class="text-right">Amount (AED): </td>
                                    <td colspan="2">
                                        @php
                                            $amount = $ip_items->sum('total_amount') - $ip_items->sum('vat_amount');
                                        @endphp
                                            {{ number_format((float)$amount, 2, '.', '')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">VAT:</td>
                                    <td colspan="2">
                                        {{ number_format((float)$ip_items->sum('vat_amount'), 2, '.', '')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Net Amount (AED):</td>
                                    <td colspan="2">
                                        {{ number_format((float)$ip_items->sum('total_amount'), 2, '.', '')}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h5>Payment</h5>
                        <div class="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3 col-12">
                                        <label for="mode">Date</label>
                                        <p>{{$pv_info->date}}</p>
                                    </div>
                                    <div class="col-sm-3 col-12">
                                        <label for="mode">Method</label>
                                        <p>{{$pv_info->payment_method}}</p>
                                    </div>
                                    <div class="col-sm-3 col-12">
                                        <label for="mode">Pay Amount</label>
                                        <p>{{$pv_info->paid_amount}}</p>
                                    </div>
                                    <div class="col-sm-3 col-12">
                                        <label for="mode">Due Amount</label>
                                        <p>{{$pv_info->due_amount}}</p>
                                    </div>
                                    @if ($pv_info->payment_method == "Check")
                                        <div id="banck_information" class="col-12 col-md-12 col-sm-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-6 col-12">
                                                    <label for="mode">Check No</label>
                                                    <p>{{$pv_info->check_no}}</p>
                                                </div>                                            
                                                <div class="col-sm-6 col-12">
                                                    <label for="mode">Bank Name</label>
                                                    <p>{{$pv_info->bank_name}}</p>
                                                </div>                                            
                                                <div class="col-sm-6 col-12">
                                                    <label for="mode">Branch Name</label>
                                                    <p>{{$pv_info->branch_name}}</p>
                                                </div>
                                                <div class="col-sm-6 col-12">
                                                    <label for="supplier_name">Supplier Name</label>
                                                    <p>{{$pv_info->supplier_name}}</p>
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
