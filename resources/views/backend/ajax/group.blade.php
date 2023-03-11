@foreach ($groups as $item)
    <tr class="data-row">
        <td>{{$item->group_no}}</td>
        <td>{{$item->group_name}}</td>
        <td>
            <a href="{{route('group.edit', $item->id)}}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>                                    
            <a href="">
                <form action="{{ route('group.destroy', $item->id) }}" method="POST" class="flot-right">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirm?')" ><i class="bx bx-trash"></i></button>
                </form>
            </a>
        </td>
    </tr>
@endforeach