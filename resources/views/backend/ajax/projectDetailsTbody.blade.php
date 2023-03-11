@foreach ($projDetails as $proj)
<tr>
    <td>{{ $proj->proj_no }}</td>
    <td>{{ $proj->proj_name }}</td>
    <td>{{ $proj->proj_type }}</td>
    <td>{{ $proj->cons_agent }}</td>
    <td>{{ $proj->address }}</td>
    <td>{{ $proj->owner_name }}</td>
    <td>{{ $proj->cont_no }}</td>
    {{-- <td>{{ $proj->ord_date }}</td>
    <td>{{ $proj->hnd_over_date }}</td> --}}
    <td style="white-space: nowrap">
        <a href="{{ route('projectView', $proj) }}"
                                                class="btn btn-sm btn-warning" ><i
                                                    class="bx bx-hide "></i></a>
        <a href="{{ route('projectEdit',$proj) }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
        <a href="{{ route('projectDelete',$proj) }}" onclick="return confirm('about to delete project. Please, Confirm?')" class="btn btn-sm btn-danger"><i class="bx bx-trash" aria-hidden="true"></i></a>

    </td>
</tr>

@endforeach
