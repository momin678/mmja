
@extends('layouts.pdf.app')
@section('content')

<div class="container py-4">
   <div class="row">
       <div class="col-12 text-center">
           <h1>Marhaba Building Materials LLC</h1>
           <h6>Ras Al-Kahimah, United Arab AMirates,0000</h6>
           <div class="row">
               <div class="col-6 text-right">
                   <h6>Mobile +971569011164</h6>
               </div>
               <div class="col-6 text-left">
                <h6>TRN 100305813600003</h6>
            </div>
           </div>
       </div>

       <div class="col-12 text-center">
        <h1>TAX INVOICE</h1>
       </div>
   </div>

   <div class="row pt-4">
       <div class="col-4">
           <div class="row">
               <div class="col-12">
                  <div class="row">
                      <div class="col-6">
                        <p><strong>INVOICE NO:</strong></p>
                      </div>
                      <div class="col-6">
                        <p>{{ $invoice->invoice_no }}</p>
                      </div>
                  </div>
               </div>
               <div class="col-12">
               <div class="row">
                   <div class="col-6">
                    <p> <strong>SHIP ADDRESS:</strong> </p>
                   </div>
                   <div class="col-6">
                       <p>{{ $invoice->invoice_no }}</p>
                   </div>
               </div>
             </div>
             <div class="col-12">
               <div class="row">
                   <div class="col-6">
                    <p> <strong>TRN:</strong> </p>
                   </div>
                   <div class="col-6">
                       <p>{{ $invoice->invoice_no }}</p>
                   </div>
               </div>
             </div>
           </div>
       </div>

       <div class="col-4">
        <div class="row">
            <div class="col-12">
               <div class="row">
                   <div class="col-6">
                    <p> <strong>CONTACT NO:</strong> </p>
                   </div>
                   <div class="col-6">
                    {{ $invoice->invoice_no }}
                   </div>
               </div>
            </div>
            <div class="col-12">
            <div class="row">
                <div class="col-6">
                    <p> <strong>TO:</strong> </p>
                </div>
                <div class="col-6">
                    <p>{{ $invoice->invoice_no }}</p>
                </div>
            </div>
          </div>

        </div>
    </div>

    <div class="col-4">
        <div class="row">
            <div class="col-12">
               <div class="row">
                   <div class="col-6">
                    <p> <strong>PAYMODE:</strong> </p>
                   </div>
                   <div class="col-6">
                       <p>{{ $invoice->invoice_no }}</p>
                   </div>
               </div>
            </div>
            <div class="col-12">
             <div class="row">
                 <div class="col-6">
                    <p> <strong>DATE:</strong></p>
                 </div>
                 <div class="col-6">
                     <p> {{ $invoice->invoice_no }}</p>
                 </div>
             </div>
          </div>

        </div>
    </div>

   </div>
   <hr>


   <div class="row">
    <div class="row">
        <table id="customers">
            <tr>
                <th>ITEM NO</th>
                <th>PRODUCT NAME</th>
                <th>UNIT</th>
                <th>UNIT PRICE</th>
                <th>QUANTITY</th>
                <th>NET AMOUNT</th>
            </tr>

            @foreach (App\InvoiceItem::where('invoice_no',$invoice->invoice_no)->get() as $item)
            <tr>
                <td>{{ $item->barcode }}</td>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->unit }}</td>
                <td>{{ $item->unit_price }}</td>
                <td>{{ $item->quantity }}</td>

                <td>{{ $item->net_amount }}</td>


            </tr>

            @endforeach


        </table>
 </div>
   </div>
</div>

@endsection
