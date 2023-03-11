<option value="">Select...</option>
@foreach ($customers as $item)
<option value="{{ $item->pi_code }}">{{ $item->pi_name }}</option>

@endforeach
