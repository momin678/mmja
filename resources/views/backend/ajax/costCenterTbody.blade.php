@foreach ($costCenters as $cCenter)
    <tr>
        <td>{{ $cCenter->cc_code }}</td>
        <td>{{ $cCenter->cc_name }}</td>
        <td>{{ $cCenter->activity }}</td>
        <td>{{ $cCenter->prsn_responsible }}</td>


        <td style="white-space: nowrap">
            <a href="{{ route('costCenEdit', $cCenter) }}" class="btn btn-sm btn-warning"><i
                    class="bx bx-edit"></i></a>
            <a href="{{ route('profitCenDelete', $cCenter) }}"
                onclick="return confirm('about to delete Cost Center. Please, Confirm?')"
                class="btn btn-sm btn-danger"><i class="bx bx-trash" aria-hidden="true"></i></a>

        </td>
    </tr>
@endforeach
