@foreach ($bankDetails as $bank)
<tr>
    <td>{{ $bank->bank_code }}</td>
    <td>{{ $bank->bank_name }}</td>
    <td>{{ $bank->branch }}</td>
    <td>{{ $bank->ac_no }}</td>
    <td>{{ $bank->signatory }}</td>
    <td style="white-space: nowrap">
        <a href="{{ route('bankEdit', $bank) }}"
            class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
        <a href="{{ route('bankDelete', $bank) }}"
            onclick="return confirm('about to delete Bank Information. Please, Confirm?')"
            class="btn btn-sm btn-danger"><i class="bx bx-trash"
                aria-hidden="true"></i></a>
    </td>
</tr>
@endforeach
