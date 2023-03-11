@foreach ($masterDetails as $masterAcc)
<tr>
    <td>{{ $masterAcc->mst_ac_code }}</td>
    <td>{{ $masterAcc->mst_ac_head }}</td>
    <td>{{ $masterAcc->mst_definition }}</td>
    <td>{{ $masterAcc->mst_ac_type }}</td>
    <td>{{ $masterAcc->vat_type }}</td>

    <td style="white-space: nowrap">
        <a href="{{ route('masterEdit',$masterAcc) }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
        <a href="{{ route('masterDelete',$masterAcc) }}" onclick="return confirm('about to delete master account. Please, Confirm?')" class="btn btn-sm btn-danger"><i class="bx bx-trash" aria-hidden="true"></i></a>

    </td>
</tr>

@endforeach
