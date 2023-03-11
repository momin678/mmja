<option value="">Select...</option>
@foreach ($items as $item)
<option value="{{ $item->item_id }}">{{ $item->item->item_name }}</option>

@endforeach
