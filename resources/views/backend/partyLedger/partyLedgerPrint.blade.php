@extends('layouts.pdf.app')
@push('css')
<style>
    th td{
        color: black !important;
        text-align: center !important;
    }


@media print {
     body {
           margin-top: 0mm;
           margin-left: 20mm;
           margin-bottom: 20mm;
           margin-right: 20mm
     }
     * {
                color: inherit !important;
                background-color: transparent !important;
                background-image: none !important;
            }
            table {
                width: 100%;
                border: 1pt solid #000000;
                border-collapse: collapse;
                font-size: 11pt;
            }
            #space { height: 750px; }
}

</style>
@endpush

@php
    $grand_total_value=0;
    $grand_total_pcs=0;

@endphp
  @section('content')


  <div class="container py-4  page-break">
    <!-- BEGIN: Content-->
    <div class="content-overlay"></div>
    <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4> Party Ledger - {{ $partyInfo->pi_name }}</h4>
                            @if (isset($date))
                            {{ $date }}
                            @else
                            <p>{{ $from }} to {{ $to }}</p>

                            @endif
                        </div>
                    </div>

                    <div class="row pt-2">

                        <table class="table table-sm table-bordered">
                            <tr>
                                <th>Date</th>
                                <th>Journal Number</th>
                                <th>Description</th>
                                <th>Account</th>
                                <th>Debit</th>
                                <th>Credit</th>
                            </tr>

                            <tbody>
                                @foreach ($journals as $item)
                                @foreach (App\Journal::where('party_info_id',$item->party_info_id)->where('date',$item->date)->orderBy('date','ASC')->get() as $journal)
                                @php
                                    $i=0;
                                @endphp
                                    @foreach ($journal->records as $record)
                                    @if ($i==0)
                                    <tr>
                                        <td rowspan="{{ $journal->records->count() }}">{{ $journal->date }}</td>
                                        <td>{{ $record->journal_no}}</td>
                                        <td>{{ $journal->narration }}</td>
                                        <td>{{ $record->ac_head->fld_ac_head }}</td>
                                        <td>{{  $record->transaction_type=="DR"?$record->amount:"" }}</td>
                                        <td>{{  $record->transaction_type=="CR"?$record->amount:"" }}</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td>{{ $record->journal_no}}</td>
                                        <td>{{ $journal->narration }}</td>
                                        <td>{{ $record->ac_head->fld_ac_head }}</td>
                                        <td>{{  $record->transaction_type=="DR"?$record->amount:"" }}</td>
                                        <td>{{  $record->transaction_type=="CR"?$record->amount:"" }}</td>
                                    </tr>
                                    @endif
                                    @php
                                    $i=1;
                                @endphp
                                    @endforeach
                                @endforeach
                                @endforeach
                            </tbody>



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
