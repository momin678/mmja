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
                                    <h6>TRN 100305813600003</h6>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-12 text-center pt-3">
                            <h1>Purchase Requisition</h1>
                        </div>
                    </div>
                    <div class="row pt-2">                        
                        <div class="col-md-6 col-6">
                            <p><strong>Purchase Requisition No:</strong> {{$purchase_info->purchase_no}}</p>
                        </div>
                        <div class="col-md-6 col-6">
                            <p><strong>Branch Name:</strong> {{$purchase_info->projectInfo->proj_name}}</p>
                        </div>
                        <div class="col-md-6 col-6">
                            <p><strong>Date:</strong> {{date('d-m-Y', strtotime($purchase_info->created_at))}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">                        
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Qty</th>
                                </tr>
                            </thead>
                            <tbody id="tempLists">
                                @foreach ($purchase_items as $item)
                                <tr  style="line-height: 0;">
                                    <td>{{$item->itemName->barcode}}</td>
                                    <td>{{$item->itemName->item_name}}</td>
                                    <td>{{$item->unit}}</td>
                                    <td>{{$item->quantity}}</td>
                                </tr>
                                @endforeach
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
