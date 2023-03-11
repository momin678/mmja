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
                        <h4> General Ledger</h4>
                        {{-- <p>{{ date('d M Y') }}</p> --}}
                    </div>

                </div>

                <div class="row">

                    <table   class="table table-sm table-bordered">
                        <tr>
                            <th class="text-center" colspan="5">General Ledger </th>
                        </tr>

                        @foreach (App\JournalRecordsTemp::distinct()->get('account_head_id') as $unique_acc_head)
                        <tr>                                
                            <th>{{ $unique_acc_head->ac_head->fld_ac_code}}</th>
                            <th>{{ $unique_acc_head->ac_head->fld_ac_head}}</th>
                            <th></th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                        </tr>
                        <tr>                                
                            <th>Date</th>
                            <th>Narration</th>
                            <th>Ref. No.</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Credit</th>
                        </tr>
                            @php
                                $each_ledger_dr=0;
                                $each_ledger_cr=0;
                            @endphp
                            @foreach (App\JournalRecordsTemp::where('account_head_id', $unique_acc_head->account_head_id )->get() as $record)
                                
                                @php
                                    $reverse= $record->transaction_type== "DR" ? "CR" : "DR";   
                                @endphp
                                @foreach (App\JournalRecordsTemp::where('journal_temp_id',$record->journal_temp_id)->where('transaction_type', $reverse)->get() as $ledger_record)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($ledger_record->created_at)->format('d.m.Y')}}</td>
                                    <td>
                                        {{$ledger_record->account_head}}
                                    </td>
                                    <td></td>
                                    <td class="text-right">{{ $dr_amount= $record->transaction_type=='DR' ? $record->amount : 0 }} </td>
                                    <td class="text-right">{{ $cr_amount= $record->transaction_type=='CR' ? $record->amount : 0 }}</td>
                                </tr>
                                @php
                                    $each_ledger_dr= $each_ledger_dr+$dr_amount;
                                    $each_ledger_cr= $each_ledger_cr+$cr_amount;
                                @endphp

                                @endforeach

                            @endforeach
                            <tr>                                
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th class="text-right">{{ number_format($each_ledger_dr,2) }}</th>
                                <th class="text-right">{{ number_format($each_ledger_cr,2)}}</th>
                            </tr>

                            <tr>                                
                                <td> <p></p></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>


                        @endforeach
                        
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
