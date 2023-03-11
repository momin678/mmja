@extends('layouts.pdf.app')
@push('css')
<style>
    th td{
        color: black !important;
        text-align: center !important;
    }

    @media print {
@page { margin: 0; }
.page-break { page-break-after: always; }
}

</style>
@endpush
@php
    $grand_total_value=0;
@endphp
  @section('content')

  {{-- $style->styleSTockPositionCheck($style) --}}


  <div class="container py-2  page-break">
    <!-- BEGIN: Content-->
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Widgets Statistics start -->
            <section id="widgets-Statistics">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4>{{ date('d M Y') }} Business Summary Report</h4>
                    </div>

                </div>

                <div class="row">

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
    <div class="row pt-3">
        <table class="table table-sm table-bordered" >
            <tr>
                <th>Prepared By</th>
                <th>Checked By</th>
                <th>Endorsed By</th>
                <th>Authorized By</th>
                <th>Authorized By</th>
                <th>Approved By</th>
            </tr>

            <tr>
                <td>Mahidul Islam Bappy</td>
                <td>Ridwanuzzaman</td>
                <td>Habibur Rahaman</td>
                <td>Md. Akhter Hosain</td>
                <td>S.M Arifen</td>
                <td>Salim Osman</td>


            </tr>

        </table>
 </div>
</div>


  @endsection
