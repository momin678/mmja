@if ($journals->count()>0)
<div class="row">
    <div class="col-12 text-right">
        <a href="{{ route('printLedger',['from'=>$from,'to'=>$to,'party'=>$partyInfo]) }}" class="btn btn-info btn-sm" target="_blank">Print</a>
    </div>
</div>

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



@else
<tr>
    <td class="text-center text-danger" colspan="6">No Result Found</td>
</tr>

@endif
