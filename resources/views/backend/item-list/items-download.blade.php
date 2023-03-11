@extends('layouts.backend.app')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
@endphp
@push('css')
    <style>
        .main-header-navbar{
            visibility: hidden;
        }
        .main-menu{
            visibility: hidden;
        }
    </style>
@endpush
@section('title', 'item export to excel')
@section('content')
    <div class="m-2">
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
                            <h1>Item List</h1>
                        </div>
                    </div>
                    
                    <div class="table-responsive card">
                        <div class="d-flex">
                            <div class="p-1">
                                <button class="btn btn-xs btn-info float-right mr-1"  onclick="exportTableToCSV('Items.csv')">Export To Excel</button>
                            </div>
                          </div>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Item Name</th>
                                    <th>Style ID</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Unit</th>
                                    <th>Base Price</th>
                                    <th>Vat Rate</th>
                                    <th>Vat</th>
                                    <th>Sell Price</th>
                                </tr>
                            </thead>
                            <tbody class="user-table-body">
                                @foreach ($itme_lists as $itme_list)
                                    <tr  class="data-row">
                                        <td>{{$itme_list->barcode}}</td>
                                        <td>{{$itme_list->item_name}}</td>
                                        <td>{{$itme_list->style->style_name}}</td>
                                        <td>{{$itme_list->brandName->name}}</td>
                                        <td>{{$itme_list->group_name}}</td>
                                        <td>{{$itme_list->unit}}</td>
                                        <td>{{$itme_list->sell_price}}</td>
                                        <td>{{$itme_list->vatRate->name}}</td>
                                        <td>{{$itme_list->vat_amount}}</td>
                                        <td>{{$itme_list->total_amount}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
