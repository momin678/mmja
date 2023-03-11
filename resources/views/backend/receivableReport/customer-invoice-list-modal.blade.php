
<section class="print-hideen border-bottom p-1">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
      </div>
</section>
<section id="widgets-Statistics" class="m-2">
    <h4 class="ml-2 text-center">Branch Details</h4>
    <table class="table table-sm table-bordered">
        <tr style="height: 50px;">
            <th>Date</th>
            <th>Transaction#</th>
            <th>Transaction Type</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Balance</th>
            
        </tr>
        <tbody class="invoice-tbody">
            @php
                $gtotal_amount=0;
                $gtotal_balance=0;
            @endphp
        @foreach($invoices as $inv)

        <tr>
        <td>{{ $inv->date }}</td>
        <td>
            <a href="#" class="btn invoice-details" id="{{ $inv->invoice_no}}"> {{ $inv->invoice_no }}</a>
        </td>
        <td>Invoice</td>
        <td></td>
        <td>{{ $inv->grand_total}} </td> 
        <td>{{ $inv->grand_total}} </td>                               
        </tr>
            @php
                $gtotal_amount=$gtotal_amount + $inv->grand_total;
                $gtotal_balance=$gtotal_balance + $inv->grand_total;
            @endphp
        @endforeach
        <tr>
            <td colspan="3" style="text-center">Grand Total</td>
            <td>{{ number_format((float)$gtotal_amount,'2','.','')}}</td>
            <td>{{ number_format((float)$gtotal_balance,'2','.','')}}</td>

        </tr>
        </tbody>


    </table>
</section>
@push('js')

@endpush