<option value="">Select...</option>
    @foreach ($items as $item)
    <option value="{{ $item->id }}">{{ App\Group::where('group_no',$item->group_no)->first()->group_name }}</option>

    @endforeach

