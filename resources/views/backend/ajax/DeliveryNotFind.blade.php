@foreach ($dNotes as $item)
<div class="col-md-12 btn btn-light btn-sm  mx-1 mb-1 text-center"
    id="sale-order-details"
    data_target="{{ route('deliveryNoteDetails', $item) }}">
    {{ $item->delivery_note_no }}
</div>
@endforeach
