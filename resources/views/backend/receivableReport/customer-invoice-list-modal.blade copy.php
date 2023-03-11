
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        .table-bordered {
            border: 1px solid #f4f4f4;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
        table {
            background-color: transparent;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        .tarek-container {
            width: 85%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 88% 12%;
            background-color: #ffff;
        }
        .invoice-label {
            font-size: 10px !important
        }
    </style>
@endpush
<section class="print-hideen border-bottom p-1">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
      </div>
</section>
@include('layouts.backend.partial.modal-header-info')
<section id="widgets-Statistics">
    <div class="row">
        <div class="col-md-12">
            <div class="cardStyleChange">
                <div class="card-header">
                    <h4>Branch Details</h4>
                </div>
                <div class="m-1 pt-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive pt-1">
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
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>


    
</section>

@push('js')
<script>
    $(document).ready(function() {






});
  </script>


@endpush