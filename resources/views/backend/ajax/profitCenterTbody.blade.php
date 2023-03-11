@foreach ($profitDetails as $pCenter)
<tr>
    <td>{{ $pCenter->pc_code }}</td>
    <td>{{ $pCenter->pc_name }}</td>
    <td>{{ $pCenter->activity }}</td>
    <td>{{ $pCenter->prsn_responsible }}</td>


    <td style="white-space: nowrap">
        <a href="{{ route('profitCenEdit',$pCenter) }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
        <a href="{{ route('profitCenDelete',$pCenter) }}" onclick="return confirm('about to delete Profit Center. Please, Confirm?')" class="btn btn-sm btn-danger"><i class="bx bx-trash" aria-hidden="true"></i></a>

    </td>
</tr>

@endforeach
