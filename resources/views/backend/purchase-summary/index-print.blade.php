@extends('layouts.pdf.app')
@push('css')
<style>
    th td{
        color: black !important;
        text-align: center !important;
    }



@media print {
     body {
           margin-top: 0mm;
           margin-left: 20mm;
           margin-bottom: 20mm;
           margin-right: 20mm
     }
     * {
                color: inherit !important;
                background-color: transparent !important;
                background-image: none !important;
            }
            table {
                width: 100%;
                border: 1pt solid #000000;
                border-collapse: collapse;
                font-size: 11pt;
            }
            #space { height: 750px; }
}


</style>
@endpush

@php
    $grand_total_value=0;
    $grand_total_pcs=0;
@endphp
  @section('content')

  {{-- $style->styleSTockPositionCheck($style) --}}


  <div class="container py-2  page-break">
    <!-- BEGIN: Content-->
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Widgets Statistics start -->
            <section id="widgets-Statistics">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4> Purchase Summary</h4>
                        <p>{{ $date !=null? $date:($from != null? ( $from.' to '. $to) : date('d M Y')) }}</p>
                    </div>

                </div>

                <div class="row">

                    <table   class="table table-sm table-bordered">
                        <tr>
                            <th class="text-center" colspan="13">Purchase Summary of {{ $date !=null? $date:($from != null? ( $from.' to '. $to) : date('d M Y')) }}</th>
                        </tr>

                       @foreach ($gd_receiveds as $rcv)

                            <tr>
                                <th colspan="13" class="text-center">PO NO: {{ $rcv->po_no }}</th>
                            </tr>
                            @if($rcv->normalItemCheeck())
                            <tr>
                                    <th class="text-center"  colspan="2">Item</th>
                                    <th class="text-center">COLOR</th>
                                    @foreach (App\Group::where('group_no','>', 10)->where('group_no','<', 18)->get() as $clr)
                                    <th class="text-center">{{ $clr->group_name }} </th>
                                    @endforeach
                                    <th class="text-center">Total Pcs</th>
                                    <th class="text-center">Purchase Rate</th>
                                    <th class="text-center">Total Value</th>
                            </tr>
                            @endif

                            @php
                                $purchase=App\Purchase::where('purchase_no',$rcv->po_no)->first();
                            @endphp
                            @foreach (App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('group_id','>=', 11)->where('group_id','<=','17')->select('style_id')->distinct()->get() as $it)
                                    @php
                                        $style=App\Style::where('id', $it->style_id)->first();
                                        $row=0;
                                        $styleQty=0;
                                        $styleAmount=0;
                                        $colorCount=App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id',$it->style_id)->select('brand_id')->distinct()->get();


                                    @endphp
                                    @if($colorCount->count()>0)
                                        <tr>
                                        <td rowspan="{{ $colorCount->count() }}" colspan="2">{{ $style->style_name }}</td>
                                        @foreach (App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id',$it->style_id)->select('brand_id')->distinct()->get()
                                            as $color)
                                                @php
                                                    $itmXs= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','11')->first();

                                                    $itmS= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','12')->first();
                                                    $itmM= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','13')->first();
                                                    $itmL= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','14')->first();
                                                    $itmXl= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','15')->first();
                                                    $itmXxl= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','16')->first();
                                                    $itmXxxl= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','17')->first();
                                                    $brand=App\Brand::where('id',$color->brand_id)->first();
                                                        //    dd($itmXs);

                                                    $itmXsC= isset($itmXs)? $itmXs->rcvdItem( $rcv->goods_received_no,$itmXs->item_id):0;
                                                        $itmSC =isset($itmS)? $itmS->rcvdItem( $rcv->goods_received_no,$itmS->item_id):0;
                                                        $itmMC=isset($itmM)? $itmM->rcvdItem( $rcv->goods_received_no,$itmM->item_id):0;
                                                        $itmLC=isset($itmL)? $itmL->rcvdItem( $rcv->goods_received_no,$itmL->item_id):0;
                                                        $itmXlC=isset($itmXl)?  $itmXl->rcvdItem( $rcv->goods_received_no,$itmXl->item_id):0;
                                                        $itmXxlC= isset($itmXxl)? $itmXxl->rcvdItem( $rcv->goods_received_no,$itmXxl->item_id):0;
                                                        $itmXxxlC=isset($itmXxxl)? $itmXxxl->rcvdItem( $rcv->goods_received_no,$itmXxxl->item_id):0;
                                                        $colorQtycheck= $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC;
                                                        $ppurchasee=App\Purchase::where('purchase_no',$rcv->po_no)->first();
                                                        $p_price=App\Fifo::where('purchase_id',$ppurchasee->id)
                                                        ->where('item_id',isset($itmXs)?$itmXs->item_id:
                                                        (isset($itmS)?$itmS->item_id:
                                                        (isset($itmM)?$itmM->item_id:
                                                        (isset($itmL)?$itmL->item_id:
                                                        (isset($itmXl)?$itmXl->item_id:
                                                        (isset($itmXxl)?$itmXxl->item_id:
                                                        (isset($itmXxxl)?$itmXxxl->item_id:"")))))))->first()
                                                @endphp
                                                    {{-- @if($brand->colorItemSaleAmount($style,$brand)>0) --}}
                                                @if($colorQtycheck >0)
                                                        @if($row==0)

                                                            <td>{{ $brand->name }}</td>
                                                            <td>{{ $itmXsC= isset($itmXs)? $itmXs->rcvdItem( $rcv->goods_received_no,$itmXs->item_id):0}}</td>
                                                            <td>{{ $itmSC =isset($itmS)? $itmS->rcvdItem( $rcv->goods_received_no,$itmS->item_id):0 }}</td>
                                                            <td>{{ $itmMC=isset($itmM)? $itmM->rcvdItem( $rcv->goods_received_no,$itmM->item_id):0 }}</td>
                                                            <td>{{ $itmLC=isset($itmL)? $itmL->rcvdItem( $rcv->goods_received_no,$itmL->item_id):0 }}</td>
                                                            <td>{{ $itmXlC=isset($itmXl)?  $itmXl->rcvdItem( $rcv->goods_received_no,$itmXl->item_id):0 }}</td>
                                                            <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->rcvdItem( $rcv->goods_received_no,$itmXxl->item_id):0 }}</td>
                                                            <td>{{ $itmXxxlC=isset($itmXxxl)? $itmXxxl->rcvdItem( $rcv->goods_received_no,$itmXxxl->item_id):0 }}</td>
                                                            <td>{{ $colorQty= $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC }}</td>

                                                            <td>{{$clr_amnt= App\Fifo::where('purchase_id',$ppurchasee->id)->where('item_id',$p_price->item_id)->first()->unit_cost_price  }}</td>
                                                            <td>{{$colorAmount= number_format((float)($colorQty*$clr_amnt),'2','.','') }}</td>
                                                            @php
                                                                $row=1;
                                                            @endphp

                                                        @else
                                                            <tr>
                                                                <td>{{ $brand->name }}</td>
                                                                <td>{{ $itmXsC= isset($itmXs)? $itmXs->rcvdItem( $rcv->goods_received_no,$itmXs->item_id):0}}</td>
                                                                <td>{{ $itmSC =isset($itmS)? $itmS->rcvdItem( $rcv->goods_received_no,$itmS->item_id):0 }}</td>
                                                                <td>{{ $itmMC=isset($itmM)? $itmM->rcvdItem( $rcv->goods_received_no,$itmM->item_id):0 }}</td>
                                                                <td>{{ $itmLC=isset($itmL)? $itmL->rcvdItem( $rcv->goods_received_no,$itmL->item_id):0 }}</td>
                                                                <td>{{ $itmXlC=isset($itmXl)?  $itmXl->rcvdItem( $rcv->goods_received_no,$itmXl->item_id):0 }}</td>
                                                                <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->rcvdItem( $rcv->goods_received_no,$itmXxl->item_id):0 }}</td>
                                                                <td>{{ $itmXxxlC=isset($itmXxxl)? $itmXxxl->rcvdItem( $rcv->goods_received_no,$itmXxxl->item_id):0 }}</td>
                                                                <td>{{$colorQty=  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC }}</td>
                                                                <td>{{$clr_amnt= App\Fifo::where('purchase_id',$ppurchasee->id)->where('item_id',$p_price->item_id)->first()->unit_cost_price  }}</td>
                                                                <td>{{$colorAmount= number_format((float)($colorQty*$clr_amnt),'2','.','') }}</td>
                                                            </tr>
                                                        @endif
                                                    {{-- @endif --}}


                                                        @php
                                                            $styleQty= $styleQty+$colorQty;
                                                            $styleAmount=$styleAmount+$colorAmount;
                                                        @endphp
                                                @endif
                                        @endforeach
                                        </tr>
                                        <tr>
                                            <td colspan="9"></td>
                                            <td  style="font-weight: bold;">Total</td>
                                            <td style="font-weight: bold;">{{ $styleQty }}</td>
                                            <td  style="font-weight: bold;">Total</td>
                                            <td style="font-weight: bold;">{{$stylAmnt=number_format((float) $styleAmount,'2','.','') }}</td>
                                        </tr>
                                        @php
                                            $grand_total_value=$grand_total_value+$stylAmnt;
                                            $grand_total_pcs=$grand_total_pcs+$styleQty;
                                        @endphp
                                    @endif
                            @endforeach



                            @if($rcv->abnormalItemCheeck())
                            <tr>
                                    <th class="text-center"  colspan="3">Item</th>
                                    <th class="text-center">COLOR</th>
                                    @foreach (App\Group::where('group_no','>', 17)->where('group_no','<', 24)->get() as $clr)
                                    <th class="text-center">{{ $clr->group_name }} </th>
                                    @endforeach
                                    <th class="text-center">Total Pcs</th>
                                    <th class="text-center">Purchase Rate</th>
                                    <th class="text-center">Total Value</th>
                            </tr>
                            @endif
                            @php
                                $purchase=App\Purchase::where('purchase_no',$rcv->po_no)->first();
                            @endphp
                            @foreach (App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('group_id','>=', 18)->where('group_id','<=','23')->select('style_id')->distinct()->get() as $it)
                                    @php
                                        $style=App\Style::where('id', $it->style_id)->first();
                                        $row=0;
                                        $styleQty=0;
                                        $styleAmount=0;
                                        $colorCount=App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('group_id','>', 17)->where('group_id','<',24)->where('style_id',$it->style_id)->select('brand_id')->where('style_id',$it->style_id)->distinct()->get();


                                    @endphp
                                    @if($colorCount->count()>0)
                                        <tr>
                                        <td rowspan="{{ $colorCount->count() }}" colspan="3">{{ $style->style_name }}</td>
                                        @foreach (App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id',$it->style_id)->select('brand_id')->distinct()->get()
                                            as $color)
                                                @php
                                                    $itmXs= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','18')->first();

                                                    $itmS= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','19')->first();
                                                    $itmM= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','20')->first();
                                                    $itmL= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','21')->first();
                                                    $itmXl= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','22')->first();
                                                    $itmXxl= App\PurchaseDetail::where('purchase_no',$rcv->po_no)->where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_id','23')->first();
                                                    $brand=App\Brand::where('id',$color->brand_id)->first();
                                                        //    dd($itmXs);
                                                    $itmXsC= isset($itmXs)? $itmXs->rcvdItem( $rcv->goods_received_no,$itmXs->item_id):0;
                                                        $itmSC =isset($itmS)? $itmS->rcvdItem( $rcv->goods_received_no,$itmS->item_id):0;
                                                        $itmMC=isset($itmM)? $itmM->rcvdItem( $rcv->goods_received_no,$itmM->item_id):0;
                                                        $itmLC=isset($itmL)? $itmL->rcvdItem( $rcv->goods_received_no,$itmL->item_id):0;
                                                        $itmXlC=isset($itmXl)?  $itmXl->rcvdItem( $rcv->goods_received_no,$itmXl->item_id):0;
                                                        $itmXxlC= isset($itmXxl)? $itmXxl->rcvdItem( $rcv->goods_received_no,$itmXxl->item_id):0;
                                                        $colorQtycheck= $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC;

                                                        $itmXsC= isset($itmXs)? $itmXs->rcvdItem( $rcv->goods_received_no,$itmXs->item_id):0;
                                                        $itmSC =isset($itmS)? $itmS->rcvdItem( $rcv->goods_received_no,$itmS->item_id):0;
                                                        $itmMC=isset($itmM)? $itmM->rcvdItem( $rcv->goods_received_no,$itmM->item_id):0;
                                                        $itmLC=isset($itmL)? $itmL->rcvdItem( $rcv->goods_received_no,$itmL->item_id):0;
                                                        $itmXlC=isset($itmXl)?  $itmXl->rcvdItem( $rcv->goods_received_no,$itmXl->item_id):0;
                                                        $itmXxlC= isset($itmXxl)? $itmXxl->rcvdItem( $rcv->goods_received_no,$itmXxl->item_id):0;
                                                        $itmXxxlC=isset($itmXxxl)? $itmXxxl->rcvdItem( $rcv->goods_received_no,$itmXxxl->item_id):0;
                                                        $colorQtycheck= $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC;
                                                        $ppurchasee=App\Purchase::where('purchase_no',$rcv->po_no)->first();
                                                        $p_price=App\Fifo::where('purchase_id',$ppurchasee->id)
                                                        ->where('item_id',isset($itmXs)?$itmXs->item_id:
                                                        (isset($itmS)?$itmS->item_id:
                                                        (isset($itmM)?$itmM->item_id:
                                                        (isset($itmL)?$itmL->item_id:
                                                        (isset($itmXl)?$itmXl->item_id:
                                                        (isset($itmXxl)?$itmXxl->item_id:""))))))->first()
                                                @endphp
                                                    {{-- @if($brand->colorItemSaleAmount($style,$brand)>0) --}}
                                                @if($colorQtycheck >0)
                                                        @if($row==0)

                                                            <td>{{ $brand->name }}</td>
                                                            <td>{{ $itmXsC= isset($itmXs)? $itmXs->rcvdItem( $rcv->goods_received_no,$itmXs->item_id):0}}</td>
                                                            <td>{{ $itmSC =isset($itmS)? $itmS->rcvdItem( $rcv->goods_received_no,$itmS->item_id):0 }}</td>
                                                            <td>{{ $itmMC=isset($itmM)? $itmM->rcvdItem( $rcv->goods_received_no,$itmM->item_id):0 }}</td>
                                                            <td>{{ $itmLC=isset($itmL)? $itmL->rcvdItem( $rcv->goods_received_no,$itmL->item_id):0 }}</td>
                                                            <td>{{ $itmXlC=isset($itmXl)?  $itmXl->rcvdItem( $rcv->goods_received_no,$itmXl->item_id):0 }}</td>
                                                            <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->rcvdItem( $rcv->goods_received_no,$itmXxl->item_id):0 }}</td>
                                                            <td>{{ $colorQty= $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC }}</td>
                                                            <td>{{$clr_amnt= App\Fifo::where('purchase_id',$ppurchasee->id)->where('item_id',$p_price->item_id)->first()->unit_cost_price  }}</td>
                                                            <td>{{$colorAmount= number_format((float)($colorQty*$clr_amnt),'2','.','') }}</td>
                                                            @php
                                                                $row=1;
                                                            @endphp

                                                        @else
                                                            <tr>
                                                                <td>{{ $brand->name }}</td>
                                                                <td>{{ $itmXsC= isset($itmXs)? $itmXs->rcvdItem( $rcv->goods_received_no,$itmXs->item_id):0}}</td>
                                                                <td>{{ $itmSC =isset($itmS)? $itmS->rcvdItem( $rcv->goods_received_no,$itmS->item_id):0 }}</td>
                                                                <td>{{ $itmMC=isset($itmM)? $itmM->rcvdItem( $rcv->goods_received_no,$itmM->item_id):0 }}</td>
                                                                <td>{{ $itmLC=isset($itmL)? $itmL->rcvdItem( $rcv->goods_received_no,$itmL->item_id):0 }}</td>
                                                                <td>{{ $itmXlC=isset($itmXl)?  $itmXl->rcvdItem( $rcv->goods_received_no,$itmXl->item_id):0 }}</td>
                                                                <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->rcvdItem( $rcv->goods_received_no,$itmXxl->item_id):0 }}</td>

                                                                <td>{{$colorQty=  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC}}</td>
                                                                <td>{{$clr_amnt= App\Fifo::where('purchase_id',$ppurchasee->id)->where('item_id',$p_price->item_id)->first()->unit_cost_price  }}</td>
                                                                <td>{{$colorAmount= number_format((float)($colorQty*$clr_amnt),'2','.','') }}</td>
                                                            </tr>
                                                        @endif
                                                    {{-- @endif --}}


                                                        @php
                                                            $styleQty= $styleQty+$colorQty;
                                                            $styleAmount=$styleAmount+$colorAmount;
                                                        @endphp
                                                @endif
                                        @endforeach
                                        </tr>
                                        <tr>
                                            <td colspan="9"></td>
                                            <td  style="font-weight: bold;">Total</td>
                                            <td style="font-weight: bold;">{{ $styleQty }}</td>
                                            <td  style="font-weight: bold;">Total</td>
                                            <td style="font-weight: bold;">{{$stylAmnt=number_format((float) $styleAmount,'2','.','') }}</td>
                                        </tr>

                                        @php
                                        $grand_total_value=$grand_total_value+$stylAmnt;
                                        $grand_total_pcs=$grand_total_pcs+$styleQty;
                                        @endphp
                                    @endif
                            @endforeach
                        @endforeach
                        <tr>
                            <th colspan="7"></th>
                            <th colspan="3"><small>Grand Total (Pcs)</small></th>
                            <td>{{ $grand_total_pcs }}</td>
                            <th><small>Grand Total</small></th>
                            <td>{{number_format((float) $grand_total_value,'2','.','') }}</td>
                        </tr>
                    </table>

                </div>

            </section>
            <!-- Widgets Statistics End -->



        </div>
    </div>
    <div class="row pt-3">
        <table class="table table-sm table-bordered" >
            <tr>
                <th>Prepared By</th>
                <th>Checked By</th>
                <th>Endorsed By</th>
                <th>Authorized By</th>
                <th>Authorized By</th>
                <th>Approved By</th>
            </tr>

            <tr>
                <td>Mahidul Islam Bappy</td>
                <td>Ridwanuzzaman</td>
                <td>Habibur Rahaman</td>
                <td>Md. Akhter Hosain</td>
                <td>S.M Arifen</td>
                <td>Salim Osman</td>


            </tr>

        </table>
 </div>
</div>


  @endsection
