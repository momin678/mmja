@extends('layouts.pdf.appInvoice')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
@endphp
@push('css')
<style>
    td{
        text-align: center !important;
    }

    th, td {
    border: 1px solid #000 !important;
}

.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #000;
}
p{
    color: black !important;
}


</style>
@endpush
@section('content')
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <section id="widgets-Statistics">
                    <div class="row">

                        <div class="col-12 text-center pt-3">
                            <h1>TAX INVOICE</h1>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-12 text-left mb-1">
                            <span><strong style="color: #000">CUSTOMER NAME : {{ $invoice->partyInfo($invoice->customer_name)->pi_name }}</strong></span>
                        </div>
                        <div class="col-md-4">
                            <div class="row">

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p><strong>INVOICE NO</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <p><strong>{{ $invoice->invoice_no }}</strong></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>SHIP ADDRESS</strong> </p>
                                        </div>
                                        <div class="col-6">
                                            <p>{{ $invoice->address == null? "NA":$invoice->address }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>TRN</strong> </p>
                                        </div>
                                        <div class="col-6">
                                            <p>{{ $invoice->trn_no }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>CONTACT NO:</strong> </p>
                                        </div>
                                        <div class="col-6">
                                            <p>{{ $invoice->contact_no }}</p>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>PAYMODE:</strong> </p>
                                        </div>
                                        <div class="col-6">
                                            <p>{{ $invoice->pay_mode }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>DATE:</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <p> {{ date('m/d/Y',strtotime($invoice->date)) }}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row pt-2">
                        <table   class="table table-sm ">
                            <tr>
                                <th class="text-center" colspan="8">Particular Description</th>
                                <th class="text-center"   rowspan="2">Quantity</th>
                                <th class="text-center" rowspan="2">Rate</th>

                                <th class="text-center" rowspan="2" >Amount</th>
                                <th class="text-center"  rowspan="2">VAT</th>
                                <th class="text-center" rowspan="2">Total Amount</th>
                            </tr>

                          @foreach (App\InvoiceItem::where('invoice_id',$invoice->id)->where('size','>',10)->where('size','<',18)->select('style_id')->distinct()
                            ->get() as $it)
                            <tr>
                                <th class="text-center" colspan="8">{{ App\Style::where('id',$it->style_id )->first()->style_name }}</th>
                            </tr>
                            <tr>
                                <td>COLOR</td>
                                @foreach (App\Group::where('group_no','>', 10)->where('group_no','<', 18)->get() as $clr)
                                <th class="text-center">{{ $clr->group_name }}</th>

                                @endforeach
                            </tr>
                            @foreach (App\InvoiceItem::where('invoice_id',$invoice->id)->where('style_id',$it->style_id)->select('color_id','style_id','invoice_id','vat_rate')->distinct()
                                    ->get() as $color)
                                    <tr>
                                        <td>{{ App\Brand::where('id',$color->color_id)->first()->name }}</td>
                                        <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','11')->sum('quantity') }}</td>
                                        <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','12')->sum('quantity') }}</td>
                                        <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','13')->sum('quantity') }}</td>
                                        <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','14')->sum('quantity') }}</td>
                                        <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','15')->sum('quantity') }}</td>
                                        <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','16')->sum('quantity') }}</td>
                                        <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','17')->sum('quantity') }}</td>

                                        <td >{{ $quantity= App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->sum('quantity') }}</td>
                                        <td>{{ $costPrice= App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->first()->unit_price }}</td>
                                        <td>{{ $totalPrice= number_format((float)( $costPrice*$quantity), 2,'.','')  }}</td>
                                        <td>{{ $vat= number_format((float)(  App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->sum('vat_amount')),'2','.','') }}</td>
                                        <td >{{number_format((float)( $totalPrice+$vat), 2,'.','')  }}</td>
                                    </tr>
                            @endforeach
                            @endforeach






                            @foreach (App\InvoiceItem::where('invoice_id',$invoice->id)->where('size','>',17)->where('size','<',24)->select('style_id')->distinct()
                                ->get() as $it)
                                <tr>
                                <th class="text-center" colspan="8">{{ App\Style::where('id',$it->style_id )->first()->style_name }}</th>
                                </tr>
                                <tr>
                                <td colspan="2">COLOR</td>
                                @foreach (App\Group::where('group_no','>', 17)->where('group_no','<', 24)->get() as $clr)
                                    <th class="text-center">{{ $clr->group_name }}</th>

                                @endforeach
                                </tr>
                                @foreach (App\InvoiceItem::where('invoice_id',$invoice->id)->where('style_id',$it->style_id)->select('color_id','style_id','invoice_id','vat_rate')->distinct()
                                            ->get() as $color)
                                        <tr>
                                            <td colspan="2">{{ App\Brand::where('id',$color->color_id)->first()->name }}</td>
                                            <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','18')->sum('quantity') }}</td>
                                            <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','19')->sum('quantity') }}</td>
                                            <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','20')->sum('quantity') }}</td>
                                            <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','21')->sum('quantity') }}</td>
                                            <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','22')->sum('quantity') }}</td>
                                            <td>{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->where('size','23')->sum('quantity') }}</td>

                                            <td >{{ $quantity= App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->sum('quantity') }}</td>
                                            <td>{{ $costPrice= App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->first()->unit_price }}</td>
                                            <td>{{ $totalPrice= number_format((float)( $costPrice*$quantity), 2,'.','')  }}</td>
                                            <td>{{ $vat= number_format((float)(  App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$color->style_id)->where('color_id',$color->color_id)->sum('vat_amount')),'2','.','') }}</td>
                                            <td >{{number_format((float)( $totalPrice+$vat), 2,'.','')  }}</td>
                                        </tr>
                                @endforeach


                                <tr>
                                    <th class="text-center" style="border: none !important" colspan="7"></th>
                                    <th class="text-center"  colspan="1">Total Item <small>Pcs</small></th>
                                    <th class="text-center" colspan="1"  >{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->where('style_id',$it->style_id)->sum('quantity') }}</th>
                                </tr>
                            @endforeach

                                <tr>
                                    <th class="text-center" style="border: none !important" colspan="9"></th>
                                    <th class="text-center"  colspan="2">Total <small>Pcs</small></th>
                                    <th class="text-center" colspan="2"  >{{ App\InvoiceItem::where('invoice_id',$color->invoice_id)->sum('quantity') }}</th>
                                </tr>

                                <tr>
                                    <th class="text-center" style="border: none !important" colspan="9"></th>
                                    <th class="text-center" colspan="2"  >TAXABLE SUPPLIES <small>(AED)</small></th>
                                    <th class="text-center" colspan="2"  >{{number_format((float)(  $invoice->taxableAmount()), 2,'.','')   }}</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="border: none !important" colspan="9"></th>
                                    <th class="text-center" colspan="2"  >VAT <small>(5%)</small></th>
                                    <th class="text-center" colspan="2"  > {{number_format((float)(  $invoice->vatAmount()), 2,'.','')   }}</th>
                                </tr>

                                <tr>
                                    <th class="text-center" style="border: none !important" colspan="9"></th>
                                    <th class="text-center" colspan="2"  >Total Amount <small>(AED)</small></th>
                                    <th class="text-center" colspan="2"  > {{number_format((float)(  $invoice->TotalAmount()), 2,'.','')   }}</th>
                                </tr>
                                @if ($invoice->delivery_note_id==null)
                                    <tr>
                                        <th class="text-center" style="border: none !important" colspan="9"></th>
                                        <th class="text-center" colspan="2"  >Amount from Customer <small>(AED)</small></th>
                                        <th class="text-center" colspan="2"  > {{$invoice->invoiceAmount ? number_format((float)($invoice->invoiceAmount->amount_from), 2,'.',''): '0.00'   }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="border: none !important" colspan="9"></th>
                                        <th class="text-center" colspan="2"  >Amount to Customer <small>(AED)</small></th>
                                        <th class="text-center" colspan="2"  >{{   $invoice->invoiceAmount ? ($invoice->invoiceAmount->amount_to>0?  number_format((float)($invoice->invoiceAmount->amount_to), 2,'.',''): '0.00'): '0.00'   }} </th>
                                    </tr>

                                @endif

                                </table>

                    </div>

                    <div class="row pt-5 mt-5">

                        <div class="col-6">
                            <div class="row">

                                <div class="col-12 pt-5">
                                    <p>Customer Signature</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="row">

                                <div class="col-12 pt-5 text-right">
                                    <p>Authorised Signature</p>
                                    <span>Name: {{ Auth::user()->name }}</span>
                                        <br>
                                    <span class="text-left">User ID: {{ Auth::id() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-5">
                            <div class="col-12 text-left">
                                <span><i>Note: No cash return and exchange of goods. Please check your cash and goods before leaving the store. No complaints are acceptable after delivery.</i></span>
                            </div>
                        </div>

                    </div>


                </section>
            </div>
        </div>
    </div>

@endsection
