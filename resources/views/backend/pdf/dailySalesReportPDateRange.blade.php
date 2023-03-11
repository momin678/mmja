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


  <div class="container py-4  page-break">
    <!-- BEGIN: Content-->
    <div class="content-overlay"></div>
    <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4> Sales Report</h4>
                            <p>{{ $from }} to {{ $to }}</p>
                        </div>
                    </div>

                    <div class="row pt-2">

                        <table   class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center" colspan="14">Sales of {{ $from }} to {{ $to }}</th>
                            </tr>
                                <tr>
                                    <td class="text-center" colspan="2">Item</td>
                                    <td class="text-center">COLOR</td>
                                    @foreach (App\Group::where('group_no','>', 10)->where('group_no','<', 18)->get() as $clr)
                                    <th class="text-center">{{ $clr->group_name }} </th>
                                    @endforeach
                                <td class="text-center">Total Pcs</td>
                                <td class="text-center">Rate per Pcs</td>
                                <td class="text-center">Total Value</td>
                                </tr>
                            @foreach (App\ItemList::where('group_no','>=', 11)->where('group_no','<=',17)->select('style_id')->distinct()->get() as $it)
                                @php
                                    $style=App\Style::where('id', $it->style_id)->first();
                                    $row=0;
                                    $styleQty=0;
                                    $styleAmount=0;
                                    $colorCount=App\ItemList::select('brand_id')->where('style_id',$it->style_id)->distinct()->get();

                                @endphp
                                @if($style->colorSaleCountRange($from,$to,$style->id)>0)
                                <tr>
                                    <td rowspan="{{ $style->colorSaleCountRange($from,$to,$style->id) }}"  colspan="2">{{ $style->style_name }}</td>
                                    @php
                                        $xs=0;$s=0;$m=0;$l=0;$xl=0;$xxl=0;$xxxl=0;
                                    @endphp
                                    @foreach (App\ItemList::select('brand_id')->where('style_id',$it->style_id)->distinct()->get()
                                        as $color)
                                        @php
                                        $itmXs= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','11')->first();
                                            $itmS= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','12')->first();
                                            $itmM= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','13')->first();
                                            $itmL= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','14')->first();
                                            $itmXl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','15')->first();
                                            $itmXxl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','16')->first();
                                            $itmXxxl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','17')->first();
                                        $brand=App\Brand::where('id',$color->brand_id)->first();
                                        $itmXsC= isset($itmXs)? $itmXs->saleRange($from,$to):0;
                                            $itmSC =isset($itmS)? $itmS->saleRange($from,$to):0;
                                            $itmMC=isset($itmM)? $itmM->saleRange($from,$to):0;
                                            $itmLC=isset($itmL)? $itmL->saleRange($from,$to):0;
                                            $itmXlC=isset($itmXl)? $itmXl->saleRange($from,$to):0;
                                            $itmXxlC= isset($itmXxl)? $itmXxl->saleRange($from,$to):0;
                                            $itmXxxlC=isset($itmXxxl)? $itmXxxl->saleRange($from,$to):0;
                                            $colorQty= $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC;
                                    @endphp
                                        {{-- @if($brand->colorItemSaleAmount($style,$brand)>0) --}}
                                        @if($colorQty>0)
                                    @if($row==0)

                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $itmXsC }}</td>
                                        <td>{{ $itmSC }}</td>
                                        <td>{{ $itmMC }}</td>
                                        <td>{{ $itmLC }}</td>
                                        <td>{{ $itmXlC }}</td>
                                        <td>{{$itmXxlC }}</td>
                                        <td>{{ $itmXxxlC }}</td>
                                        <td>{{ $tqty=$colorQty }}</td>
                                        <td>{{$sr=number_format((float)$brand->colorItemSaleRateDateRange($style,$brand,$from,$to), 3,'.','') }}</td>
                                        <td>{{$colorAmount = number_format((float)($tqty*$sr),'2','.','') }}</td>
                                        @php
                                            $row=1;
                                        @endphp

                                    @else
                                    <tr>
                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $itmXsC= isset($itmXs)? $itmXs->saleRange($from,$to):0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? $itmS->saleRange($from,$to):0 }}</td>
                                        <td>{{ $itmMC=isset($itmM)? $itmM->saleRange($from,$to):0 }}</td>
                                        <td>{{ $itmLC=isset($itmL)? $itmL->saleRange($from,$to):0 }}</td>
                                        <td>{{ $itmXlC=isset($itmXl)? $itmXl->saleRange($from,$to):0 }}</td>
                                        <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->saleRange($from,$to):0 }}</td>
                                        <td>{{ $itmXxxlC=isset($itmXxxl)? $itmXxxl->saleRange($from,$to):0 }}</td>

                                        <td>{{$tqty=$colorQty=  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC }}</td>
                                        <td>{{$sr=number_format((float)$brand->colorItemSaleRateDateRange($style,$brand,$from,$to), 3,'.','') }}</td>
                                        <td>{{$colorAmount = number_format((float)($tqty*$sr),'2','.','') }}</td>
                                    </tr>
                                    @endif


                                    @php
                                        $styleQty= $styleQty+$colorQty;
                                        $styleAmount=$styleAmount+$colorAmount;
                                        $xs=$xs+$itmXsC;
                                        $s=$s+$itmSC;
                                        $m=$m+$itmMC;
                                        $l=$l+$itmLC;
                                        $xl=$xl+$itmXlC;
                                        $xxl=$xxl+$itmXxlC;
                                        $xxxl=$xxxl+$itmXxxlC;
                                    @endphp
                                    @endif
                                    @endforeach
                                    <tr>
                                        <td colspan="9"></td>
                                        <td  style="font-weight: bold;">Total</td>

                                        <td style="font-weight: bold;">{{ $styleQty }}</td>
                                        <td  style="font-weight: bold;">Total</td>
                                        <td style="font-weight: bold;">{{$stylAmnt=number_format((float) $styleAmount ,2,'.','')}}</td>
                                    </tr>


                                </tr>
                                @php

                                $grand_total_value=$grand_total_value+$stylAmnt;
                                $grand_total_pcs=$grand_total_pcs+$styleQty;
                            @endphp
                                @endif

                            @endforeach




                            <tr>
                                <td class="text-center" colspan="3">Item</td>
                                <td class="text-center">COLOR</td>
                                @foreach (App\Group::where('group_no','>', 17)->where('group_no','<', 24)->get() as $clr)
                                <th class="text-center">{{ $clr->group_name }} </th>
                                @endforeach
                            <td class="text-center">Total Pcs</td>
                            <td class="text-center">Rate per Pcs</td>
                            <td class="text-center">Total Value</td>
                            </tr>
                        @foreach (App\ItemList::where('group_no','>', 17)->where('group_no','<',24)->select('style_id')->distinct()->get() as $it)
                            @php
                                $style=App\Style::where('id', $it->style_id)->first();
                                $row=0;
                                $styleQty=0;
                                $styleAmount=0;
                                $colorCount=App\ItemList::select('brand_id')->where('style_id',$it->style_id)->distinct()->get();

                            @endphp
                            @if($style->colorSaleCountRange($from,$to,$style->id)>0)
                            <tr>
                                <td rowspan="{{ $style->colorSaleCountRange($from,$to,$style->id) }}"  colspan="3">{{ $style->style_name }}</td>
                                @foreach (App\ItemList::select('brand_id')->where('style_id',$it->style_id)->distinct()->get()
                                    as $color)
                                    @php
                                   $itmXs= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','18')->first();
                                        $itmS= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','19')->first();
                                        $itmM= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','20')->first();
                                        $itmL= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','21')->first();
                                        $itmXl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','22')->first();
                                        $itmXxl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','23')->first();
                                    $brand=App\Brand::where('id',$color->brand_id)->first();
                                    $itmXsC= isset($itmXs)? $itmXs->saleRange($from,$to):0;
                                        $itmSC =isset($itmS)? $itmS->saleRange($from,$to):0;
                                        $itmMC=isset($itmM)? $itmM->saleRange($from,$to):0;
                                        $itmLC=isset($itmL)? $itmL->saleRange($from,$to):0;
                                        $itmXlC=isset($itmXl)? $itmXl->saleRange($from,$to):0;
                                        $itmXxlC= isset($itmXxl)? $itmXxl->saleRange($from,$to):0;
                                        $colorQty= $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC;

                                @endphp
                                    {{-- @if($brand->colorItemSaleAmount($style,$brand)>0) --}}
                                    @if($colorQty>0)
                                @if($row==0)

                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $itmXsC= isset($itmXs)? $itmXs->saleRange($from,$to):0 }}</td>
                                    <td>{{ $itmSC =isset($itmS)? $itmS->saleRange($from,$to):0 }}</td>
                                    <td>{{ $itmMC=isset($itmM)? $itmM->saleRange($from,$to):0 }}</td>
                                    <td>{{ $itmLC=isset($itmL)? $itmL->saleRange($from,$to):0 }}</td>
                                    <td>{{ $itmXlC=isset($itmXl)? $itmXl->saleRange($from,$to):0 }}</td>
                                    <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->saleRange($from,$to):0 }}</td>
                                    <td>{{ $colorQty= $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC }}</td>

                                    <td>{{$sr=number_format((float)$brand->colorItemSaleRateDateRange($style,$brand,$from,$to), 3,'.','') }}</td>
                                    <td>{{$colorAmount = number_format((float)($colorQty*$sr),'2','.','') }}</td>
                                    @php
                                        $row=1;
                                    @endphp
                            </tr>

                                @else
                                <tr>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $itmXsC= isset($itmXs)? $itmXs->saleRange($from,$to):0 }}</td>
                                    <td>{{ $itmSC =isset($itmS)? $itmS->saleRange($from,$to):0 }}</td>
                                    <td>{{ $itmMC=isset($itmM)? $itmM->saleRange($from,$to):0 }}</td>
                                    <td>{{ $itmLC=isset($itmL)? $itmL->saleRange($from,$to):0 }}</td>
                                    <td>{{ $itmXlC=isset($itmXl)? $itmXl->saleRange($from,$to):0 }}</td>
                                    <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->saleRange($from,$to):0 }}</td>
                                    <td>{{ $tqty=$colorQty }}</td>
                                    <td>{{$sr=number_format((float)$brand->colorItemSaleRateDateRange($style,$brand,$from,$to), 3,'.','') }}</td>
                                    <td>{{$colorAmount = number_format((float)($tqty*$sr),'2','.','') }}</td>
                                    </tr>
                                @endif


                                @php
                                    $styleQty= $styleQty+$colorQty;
                                    $styleAmount=$styleAmount+$colorAmount;
                                @endphp
                                @endif
                                @endforeach
                                <tr>
                                    <td colspan="9"></td>
                                    <td  style="font-weight: bold;">Total</td>
                                    <td style="font-weight: bold;">{{ $styleQty }}</td>
                                    <td  style="font-weight: bold;">Total</td>
                                    <td style="font-weight: bold;">{{$stylAmnt=number_format((float) $styleAmount ,2,'.','')}}</td>
                                </tr>

                                @php

                                $grand_total_value=$grand_total_value+$stylAmnt;
                                $grand_total_pcs=$grand_total_pcs+$styleQty;
                            @endphp
                            @endif


                        @endforeach
                        <tr>
                            <th colspan="9"></th>
                            <th>Grand Total (Pcs)</th>
                            <td>{{ $grand_total_pcs }}</td>
                            <th>Grand Total</th>
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
