@extends('layouts.pdf.appInvoice')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
@endphp
@push('css')
<style>
    .custom-border{
        border: 1px solid #000 !important;
    }
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #000;
    }
    p{
        color: black !important;
    }
</style>
@endpush
@section('content')
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-12 text-center pt-1">
                            <h3>Delivery Challan Details</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            Deliver To <br>
                            <span class="text-success">{{$delivery_note->deliverySale->saleOrder->partyInfo($delivery_note->deliverySale->saleOrder->customer_name)->pi_name}}</span><br>
                            <span >{{$delivery_note->deliverySale->saleOrder->partyInfo($delivery_note->deliverySale->saleOrder->customer_name)->address}}</span>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-6 text-right">Date: </div>
                                <div class="col-md-6 text-right">{{$delivery_note->deliverySale->saleOrder->date}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 text-right">Challan Type: </div>
                                <div class="col-md-6 text-right"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 text-right">LPO#: </div>
                                <div class="col-md-6 text-right"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 text-right">Vehicle#: </div>
                                <div class="col-md-6 text-right"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row pt-2">
                        <table class="table table-sm ">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Description</th>
                                    <th scope="col" class="text-right pr-3">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->saleItem->item->item_name}}</td>
                                        <td class="text-right pr-3">{{$item->quantity}}</td>
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
