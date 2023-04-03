@extends('layouts.backend.app')
@php
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
@endphp
@section('title', 'Vendor Debit Details')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content print-hidden">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="tab-content bg-white">
            <div>
                <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                    <div class="row">
                        <div class="col-md-12 mt-2 text-center">
                            <h4>{{ $company_name->config_value}}</h4>
                            <h5>Vendor Debit Details</h5>
                        </div>
                        {{-- <div class="col-md-6  mt-2 text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                Fitter
                              </button>
                        </div> --}}
                    </div>
                </section>

                <section class="mr-1 ml-1">
                    <div class="mt-2">
                        <div class="cardStyleChange">
                            <table class="table mb-0 table-sm table-hover exprortTable ">
                                <thead  class="thead-light">
                                    <tr style="height: 50px;">
                                        <th>Status</th>
                                        <th>Vendor Debit Date</th>
                                        <th>Debit  Note</th>
                                        <th>Vendor name</th>
                                        <th class="text-right pr-2">Amount</th>
                                        <th class="text-right pr-2">Balance Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($returns as $key => $return)
                                        @php
                                            $amount = $return->returnAmount($return->purchase_return_no, $return->po_no);
                                            $total += $amount;
                                        @endphp
                                        <tr>
                                            <td>
                                                @if ($return->status==200)
                                                    <span class="text-success">Paid</span>
                                                @else
                                                    <span class="text-primary">Open</span>
                                                @endif
                                            </td>
                                            <td>{{$return->date}}</td>
                                            <td>{{$return->purchase_return_no}}</td>
                                            <td>{{$return->partInfo->pi_name}}</td>
                                            <td class="text-right pr-2"><small>(AED)</small> {{$amount}}</td>
                                            <td class="text-right pr-2"><small>(AED)</small> {{$amount}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>Total</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right pr-2"><small>(AED)</small> {{$total}}</td>
                                        <td class="text-right pr-2"><small>(AED)</small> {{$total}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('js')
    
@endpush