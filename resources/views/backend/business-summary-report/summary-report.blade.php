@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        td{
            text-align: center !important;
        }
    </style>
@endpush
@php
    $grand_total_value=0;
@endphp
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>{{ date('d M Y') }} Business Summary Report</h4>
                           </div>
                           <div class="col-md-4 text-right">
                            {{-- <form action="{{ route('searchDailySale') }}" method="GET">
                               <div class="row form-group">
                                <input type="text" class="form-control col-9" name="date" placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                               </div>
                            </form> --}}
                           </div>
                    </div>

                    <div class="row pt-2">
                        <div class="col-md-12">
                            <a href="{{ route('b-summary-report-print') }}" class="btn btn-sm btn-info float-right"
                            target="_blank">Print</a>
                            <button class="btn  btn-info btn-sm float-right mr-1"
                        onclick="exportTableToCSV('business-summary-report-{{ date('d M Y') }}.csv')">Export To CSV</button>
                        </div>
                        <table   class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center" colspan="7">Expense Summary</th>
                            </tr>
                            <tr>
                                <th class="text-center"  colspan="2">Master A/C</th>
                                <th class="text-center">A/C Head</th>
                                <th class="text-center">Party</th>
                                <th class="text-center">Taxable Amount</th>
                                <th class="text-center">Vat</th>
                                <th class="text-center">Total Amount</th>
                            </tr>
                            @php
                                $total_taxable_amount=0;
                                $total_vat=0;
                                $grand_total=0;
                            @endphp
                            @foreach (App\Expense::where('date',date('Y-m-d'))->get() as $expense)
                            @php
                                $total_taxable_amount= $total_taxable_amount + $expense->taxable_amount;
                                $total_vat= $total_vat + $expense->vat_amount;
                                $grand_total= $grand_total + $expense->total_amount;
                            @endphp
                            <tr>
                                <td colspan="2"> {{ $expense->master_account->mst_ac_head}} </td>
                                <td> {{ $expense->account_head->fld_ac_head}} </td>
                                <td> {{ $expense->party->pi_name}} </td>
                                <td> {{ $expense->taxable_amount}} </td>
                                <td> {{ $expense->vat_amount}} </td>
                                <td> {{ $expense->total_amount}} </td>
                            </tr>
                            @endforeach


                            
                            <tr>
                                <th colspan="3"></th>
                                <th>Grand Total</th>
                                <td> {{ $total_taxable_amount}} </td>
                                <td> {{ $total_vat}}</td>
                                <td> {{ $grand_total}}</td>
                            </tr>
                        </table>

                    </div>

                </section>
                <!-- Widgets Statistics End -->



            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        // $(document).ready(function() {
        // Page Script
        // alert("Alhamdulillah");
        // });
    </script>


@endpush
