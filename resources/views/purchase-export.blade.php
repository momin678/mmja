@extends('layouts.backend.app')
@section('content')
<div class="app-content content">

    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <button class="btn btn-xs btn-info float-right mr-1"
        onclick="exportTableToCSV('tax.csv')">Export To CSV</button>
        <div class="row d-flex justify-content-center">
        <div class="content-body">
            <div>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th scope="col">Supplier Name</th>
                        <th scope="col">TRN Number</th>
                        <th scope="col">Date</th>
                        <th scope="col">Purchase No</th>
                        <th scope="col">Taxable Amount</th>
                        <th scope="col">Tax Amount</th>TAXABLE AMOUNT
                        <th scope="col">Total Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $taxable_amount = 0;
                            $tax_amount = 0;
                            $total_amount = 0;
                        @endphp
                        @foreach ($purchases as $item)
                        @php
                            $taxable_amount += ($item->purchase_details->sum('total_amount') - $item->purchase_details->sum('vat_amount'));
                            $tax_amount += $item->purchase_details->sum('vat_amount');
                            $total_amount += $item->purchase_details->sum('total_amount');
                        @endphp
                            <tr>
                                <td>{{$item->partInfo->pi_name}}</td>
                                <td>{{$item->partInfo->trn_no}}</td>
                                <td>{{$item->date}}</td>
                                <td>{{$item->purchase_no}}</td>
                                <td>{{number_format($item->purchase_details->sum('total_amount') - $item->purchase_details->sum('vat_amount'),2)}}</td>
                                <td>{{number_format($item->purchase_details->sum('vat_amount'),2)}}</td>
                                <td>{{number_format($item->purchase_details->sum('total_amount'),2)}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>Total:</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($taxable_amount,2)}}</td>
                            <td>{{number_format($tax_amount,2)}}</td>
                            <td>{{number_format($total_amount,2)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
