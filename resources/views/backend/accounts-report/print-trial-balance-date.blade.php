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
                        <h4> Trial Balance</h4>
                        {{-- <p>{{ date('d M Y') }}</p> --}}
                    </div>

                </div>

                <div class="row">

                    <table   class="table table-sm table-bordered">
                        <tr>
                            <th colspan="4" class="text-center">
                                <h2>Trial Balance</h2>
                                <h4>{{$date}}</h4>
                            </th>
                        </tr>
                        <tr>                                
                            <th>A/C Head</th>
                            <th></th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Credit</th>
                        </tr>
                        @php
                            $total_debit=0;
                            $total_credit=0;
                        @endphp
                        @foreach (App\JournalRecordsTemp::where('journal_date', $date)->distinct()->get('master_account_id') as $unique_master_ac)

                        <tr>                                
                            <th>{{$unique_master_ac->master_ac->mst_definition}}</th>
                            <th></th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                        </tr>
                            @php
                                $each_ledger_dr=0;
                                $each_ledger_cr=0;
                            @endphp
                            @foreach (App\JournalRecordsTemp::where('master_account_id', $unique_master_ac->master_account_id )->where('journal_date', $date)->distinct()->get('account_head_id') as $account_head_id)
                                
                                @php
                                    $single_dr=0;
                                    $single_cr=0;
                                @endphp
                                @foreach (App\JournalRecordsTemp::where('account_head_id', $account_head_id->account_head_id)->where('journal_date', $date)->get() as $single_jl_entry)

                                @php                                        
                                if($single_jl_entry->transaction_type=="DR"){
                                    $single_dr= $single_dr+ $single_jl_entry->amount;
                                }else{
                                    $single_cr =$single_cr+ $single_jl_entry->amount;
                                }   
                                @endphp
                                    
                                @endforeach
                                
                                @php
                                    if($single_dr> $single_cr){
                                            $debit_balance = $single_dr- $single_cr;
                                            $credit_balance=0;
                                            $total_debit= $total_debit+ $debit_balance;
                                        }elseif($single_cr> $single_dr){
                                            $credit_balance = $single_cr- $single_dr;
                                            $debit_balance=0;
                                            $total_credit = $total_credit + $credit_balance;
                                    }
                                @endphp
                                <tr>
                                    <td>{{$account_head_id->ac_head->fld_ac_head}}</td>
                                    <td></td>
                                    <td>{{$debit_balance}}</td>
                                    <td>{{$credit_balance}}</td>
                                </tr>

                            @endforeach
                            

                            <tr>                                
                                <td> <p></p></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>


                        @endforeach
                        <tr>
                            <th></th>
                            <th>Grand Total</th>
                            <th>{{ number_format($total_debit,2)}} </th>
                            <th>{{ number_format($total_credit,2)}}</th>
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
