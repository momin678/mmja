@extends('layouts.pdf.app2')
@push('css')
@endpush


@section('content')

@foreach (App\ItemList::where('group_no','<',18)->select('style_id')->distinct()->get() as $it)

        @php
            $style = App\Style::where('id', $it->style_id)->first();
            $xsOpening=0;$xsSell=0;$xsCurStock=0;$sOpening=0; $sSell=0;$sCurStock=0;$mOpening=0;$mSell=0;$mCurStock=0;$lOpening=0;
            $lSell=0;$lCurStock=0;$xlOpening=0;$xlSell=0;$xlCurStock=0;$xxlOpening=0; $xxlSell=0;$xxlCurStock=0;
            $xxxlOpening=0;$xxxlSell=0;$xxxlCurStock=0; $xsPurch=0;$sPurch=0;$mPurch=0;$lPurch=0;$xlPurch=0;$xxlPurch=0;$xxxlPurch=0; $ttttP=0;
            $tttttS=0;

        @endphp
        <section class="container page-break">
            <div class="row pt-2">
                <div class="col-md-12 text-center">
                    <h4> Stock Report</h4>
                    <p>{{ date('d M Y') }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr style=""><th></th></tr>
                            </thead>
                            <tfoot>
                                <tr style="border: none">
                                    <td colspan="12" style="text-align: left !important;"> Business Solutions by
                                        <span><img src="{{ asset('img/zisprink.png') }}" style="max-height: 50px"
                                                class="img-fluid" alt=""></span>,
                                        Product of Zinith
                                    </td>
                                </tr>
                            </tfoot>

                            <tbody>
                                <tr>
                                    <th class="text-center" colspan="12">
                                        {{ $style->style_name }} </th>
                                </tr>
                                <tr>
                                    <th class="text-center" >COLOR</th>
                                    @foreach (App\Group::where('group_no','>=', 11)->where('group_no','<=', 17)->get() as $clr)

                                    <th class="text-center">{{ $clr->group_name }}</th>

                                            @endforeach
                                    <th class="text-center">Total</th>
                                    <th><small><strong>Cost Price</strong></small></th>
                                    <th><small><strong>Sale Price</strong></small></th>
                                </tr>
                                @foreach (App\ItemList::select('brand_id')->where('style_id', $it->style_id)->distinct()->get()
                                        as $color)
                                    @php
                                        $itmXs= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','11')->first();
                                            $itmS= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','12')->first();
                                            $itmM= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','13')->first();
                                            $itmL= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','14')->first();
                                            $itmXl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','15')->first();
                                            $itmXxl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','16')->first();
                                            $itmXxxl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','17')->first();
                                        $brand = App\Brand::where('id', $color->brand_id)->first();
                                    @endphp
                                    {{-- $brand->stockPositionCheck($brand,$style) --}}
                                    @if (1 == 1)
                                    <tr>
                                        <td><strong>{{ $brand->name }}</strong></td>
                                        <td>{{ $itmXsC= isset($itmXs)? $itmXs->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? $itmS->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmMC=isset($itmM)? $itmM->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmLC=isset($itmL)? $itmL->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmXlC=isset($itmXl)? $itmXl->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmXxlC=isset($itmXxl)? $itmXxl->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmXxxlC=isset($itmXxxl)? $itmXxxl->todayOpeningStock():0 }}</td>
                                        <td>{{  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC }}</td>
                                        <td></td>
                                            <td></td>
                                    </tr>
                                    @php
                                        $xsOpening=$xsOpening+$itmXsC;
                                        $sOpening=$sOpening +$itmSC;
                                        $mOpening=$mOpening+$itmMC;
                                        $lOpening=$lOpening+$itmLC;
                                        $xlOpening= $xlOpening+$itmXlC;
                                        $xxlOpening= $xxlOpening+$itmXxlC;
                                        $xxxlOpening=$xxxlOpening+$itmXxxlC;
                                    @endphp
                                        <tr>
                                            <td><small>Sale</small></td>
                                            <td>{{ $itmXsC= isset($itmXs)? $itmXs->saleToday():0 }}</td>
                                            <td>{{ $itmSC =isset($itmS)? $itmS->saleToday():0 }}</td>
                                            <td>{{ $itmMC=isset($itmM)? $itmM->saleToday():0 }}</td>
                                            <td>{{ $itmLC=isset($itmL)? $itmL->saleToday():0 }}</td>
                                            <td>{{ $itmXlC=isset($itmXl)? $itmXl->saleToday():0 }}</td>
                                            <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->saleToday():0 }}</td>
                                            <td>{{ $itmXxxlC=isset($itmXxxl)? $itmXxxl->saleToday():0 }}</td>
                                            <td>{{  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @php
                                        $xsSell=$xsSell+$itmXsC;
                                        $sSell=$sSell +$itmSC;
                                        $mSell=$mSell+$itmMC;
                                        $lSell=$lSell+$itmLC;
                                        $xlSell= $xlSell+$itmXlC;
                                        $xxlSell= $xxlSell+$itmXxlC;
                                        $xxxlSell=$xxxlSell+$itmXxxlC;
                                    @endphp
                                    <tr>
                                        <td><small>Purchase</small></td>
                                        <td>{{$itmXsC= isset($itmXs)? $itmXs->purchaseToday():0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? $itmS->purchaseToday():0 }}</td>
                                        <td>{{$itmMC= isset($itmM)? $itmM->purchaseToday():0 }}</td>
                                        <td>{{$itmLC= isset($itmL)? $itmL->purchaseToday():0 }}</td>
                                        <td>{{$itmXlC= isset($itmXl)? $itmXl->purchaseToday():0 }}</td>
                                        <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->purchaseToday():0 }}</td>
                                        <td>{{ $itmXxxlC=isset($itmXxxl)? $itmXxxl->purchaseToday():0 }}</td>
                                        <td>{{  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC }}</td>
                                        <td></td>
                                            <td></td>
                                    </tr>
                                    @php
                                        $xsPurch=$xsPurch+$itmXsC;
                                        $sPurch=$sPurch +$itmSC;
                                        $mPurch=$mPurch+$itmMC;
                                        $lPurch=$lPurch+$itmLC;
                                        $xlPurch= $xlPurch+$itmXlC;
                                        $xxlPurch= $xxlPurch+$itmXxlC;
                                        $xxxlPurch=$xxxlPurch+$itmXxxlC;
                                    @endphp
                                    <tr>
                                        <td><small>Current Stock</small></td>
                                        <td>{{$itmXsC= isset($itmXs)? $itmXs->itemStock():0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? $itmS->itemStock():0 }}</td>
                                        <td>{{$itmMC= isset($itmM)? $itmM->itemStock():0 }}</td>
                                        <td>{{ $itmLC=isset($itmL)? $itmL->itemStock():0 }}</td>
                                        <td>{{$itmXlC= isset($itmXl)? $itmXl->itemStock():0 }}</td>
                                        <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->itemStock():0 }}</td>
                                        <td>{{$itmXxxlC= isset($itmXxxl)? $itmXxxl->itemStock():0 }}</td>
                                        <td>{{$qqttyy=  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC }}</td>
                                        @php
                                        $itmmmm= App\PurchaseDetail::where('item_id',isset($itmXs->id)? $itmXs->id:"null")
                                        ->orWhere('item_id',isset($itmS->id)? $itmS->id:"null")
                                        ->orWhere('item_id',isset($itmM->id)? $itmM->id:"null" )
                                        ->orWhere('item_id',isset($itmL->id)? $itmL->id:"null" )
                                        ->orWhere('item_id',isset($itmXl->id)? $itmXl->id:"null" )
                                        ->orWhere('item_id',isset($itmXxl->id)? $itmXxl->id:"null" )
                                        ->orWhere('item_id',isset($itmXxxl->id)? $itmXxxl->id:"null" )
                                        ->first();

                                        $itmmmmm= App\ItemList::where('id',isset($itmXs->id)? $itmXs->id:"null")
                                        ->orWhere('id',isset($itmS->id)? $itmS->id:"null")
                                        ->orWhere('id',isset($itmM->id)? $itmM->id:"null" )
                                        ->orWhere('id',isset($itmL->id)? $itmL->id:"null" )
                                        ->orWhere('id',isset($itmXl->id)? $itmXl->id:"null" )
                                        ->orWhere('id',isset($itmXxl->id)? $itmXxl->id:"null" )
                                        ->orWhere('id',isset($itmXxxl->id)? $itmXxxl->id:"null" )
                                        ->first();
                                        $ppppp=isset( $itmmmm)? $itmmmm->purchase_rate:0;
                                        $ttttt=isset( $itmmmmm)? $itmmmmm->total_amount:0
                                    @endphp
                                        <td>{{$ttttPU= number_format((float)($qqttyy*$ppppp),'2','.','')  }}</td>
                                        <td>{{$tttttSU=number_format((float)( $qqttyy*$ttttt ),'2','.','') }} </td>
                                    </tr>
                                    @php
                                        $xsCurStock=$xsCurStock+$itmXsC;
                                        $sCurStock=$sCurStock +$itmSC;
                                        $mCurStock=$mCurStock+$itmMC;
                                        $lCurStock=$lCurStock+$itmLC;
                                        $xlCurStock= $xlCurStock+$itmXlC;
                                        $xxlCurStock= $xxlCurStock+$itmXxlC;
                                        $xxxlCurStock=$xxxlCurStock+$itmXxxlC;
                                        $ttttP=$ttttP+$ttttPU;
                                        $tttttS=$tttttS+$tttttSU;
                                    @endphp
                                    @endif
                                @endforeach
                                <tr>
                                    <td><small>Opening Stock</small></td>
                                    <td>{{ $xsOpening }}</td>
                                    <td>{{ $sOpening }}</td>
                                    <td>{{ $mOpening }}</td>
                                    <td>{{ $lOpening }}</td>
                                    <td>{{ $xlOpening }}</td>
                                    <td>{{ $xxlOpening }}</td>
                                    <td>{{ $xxxlOpening }}</td>
                                    <td>{{ $xsOpening + $sOpening + $mOpening + $lOpening + $xlOpening + $xxlOpening + $xxxlOpening }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td><small>Total Sale</small></td>
                                    <td>{{ $xsSell }}</td>
                                    <td>{{ $sSell }}</td>
                                    <td>{{ $mSell }}</td>
                                    <td>{{ $lSell }}</td>
                                    <td>{{ $xlSell }}</td>
                                    <td>{{ $xxlSell }}</td>
                                    <td>{{ $xxxlSell }}</td>
                                    <td>{{ $xsSell + $sSell + $mSell + $lSell + $xlSell + $xxlSell + $xxxlSell }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><small>Total Purchase</small></td>
                                    <td>{{  $xsPurch }}</td>
                                    <td>{{ $sPurch }}</td>
                                    <td>{{ $mPurch }}</td>
                                    <td>{{ $lPurch }}</td>
                                    <td>{{ $xlPurch }}</td>
                                    <td>{{ $xxlPurch }}</td>
                                    <td>{{ $xxxlPurch }}</td>
                                    <td>{{ $xsPurch+$sPurch+$mPurch+$lPurch+$xlPurch+$xxlPurch+$xxxlPurch }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><small>Total Current Stock</small></td>
                                    <td>{{ $xsCurStock }}</td>
                                    <td>{{ $sCurStock }}</td>
                                    <td>{{ $mCurStock }}</td>
                                    <td>{{ $lCurStock }}</td>
                                    <td>{{ $xlCurStock }}</td>
                                    <td>{{ $xxlCurStock }}</td>
                                    <td>{{ $xxxlCurStock }}</td>
                                    <td>{{ $xsCurStock + $sCurStock + $mCurStock + $lCurStock + $xlCurStock + $xxlCurStock + $xxxlCurStock }}
                                    </td>
                                    <td>{{ number_format((float)($ttttP),'2','.','') }}</td>
                                    <td>{{  number_format((float)($tttttS),'2','.','') }}</td>
                                </tr>
                                <tr style="height: 130px" class="text-center">
                                    <td>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th><small>Prepared By</small> </th>
                                            <th><small>Checked By</small> </th>
                                            <th><small>Endorsed By</small> </th>
                                            <th><small>Authorized By</small> </th>
                                            <th><small>Authorized By</small> </th>
                                            <th><small>Approved By</small> </th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><small>Mahidul Islam Bappy</small> </td>
                                            <td><small>Ridwanuzzaman</small> </td>
                                            <td><small>Habibur Rahaman</small> </td>
                                            <td><small>Md. Akhter Hosain</small> </td>
                                            <td><small>S.M Arifen</small> </td>
                                            <td><small>Salim Osman</small> </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>


                                        </tr>

                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>


                </div>
            </div>
        </section>
@endforeach




@foreach (App\ItemList::where('group_no','>',17)->select('style_id')->distinct()->get() as $it)

        @php
            $style = App\Style::where('id', $it->style_id)->first();
            $xsOpening=0;$xsSell=0;$xsCurStock=0;$sOpening=0; $sSell=0;$sCurStock=0;$mOpening=0;$mSell=0;$mCurStock=0;$lOpening=0;
            $lSell=0;$lCurStock=0;$xlOpening=0;$xlSell=0;$xlCurStock=0;$xxlOpening=0; $xxlSell=0;$xxlCurStock=0;
            $xxxlOpening=0;$xxxlSell=0;$xxxlCurStock=0; $xsPurch=0;$sPurch=0;$mPurch=0;$lPurch=0;$xlPurch=0;$xxlPurch=0;$xxxlPurch=0; $ttttP=0;
            $tttttS=0;

        @endphp
        <section class="container page-break">
            <div class="row pt-2">
                <div class="col-md-12 text-center">
                    <h4> Stock Report</h4>
                    <p>{{ date('d M Y') }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr style=""><th></th></tr>
                            </thead>
                            <tfoot>
                                <tr style="border: none">
                                    <td colspan="12" style="text-align: left !important;"> Business Solutions by
                                        <span><img src="{{ asset('img/zisprink.png') }}" style="max-height: 50px"
                                                class="img-fluid" alt=""></span>,
                                        Product of Zinith
                                    </td>
                                </tr>
                            </tfoot>

                            <tbody>
                                <tr>
                                    <th class="text-center" colspan="12">
                                        {{ $style->style_name }} </th>
                                </tr>
                                <tr>
                                    <th class="text-center" >COLOR</th>
                                    @foreach (App\Group::where('group_no','>', 17)->where('group_no','<', 24)->get() as $clr)
                                    <th class="text-center">{{ $clr->group_name }}</th>

                                    @endforeach
                                    <th class="text-center">Total</th>
                                    <th><small><strong>Cost Price</strong></small></th>
                                    <th><small><strong>Sale Price</strong></small></th>
                                    <th></th>
                                </tr>
                                @foreach (App\ItemList::select('brand_id')->where('style_id', $it->style_id)->distinct()->get()
                                        as $color)
                                    @php
                                         $itmXs= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','18')->first();
                                        $itmS= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','19')->first();
                                        $itmM= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','20')->first();
                                        $itmL= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','21')->first();
                                        $itmXl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','22')->first();
                                        $itmXxl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_no','23')->first();
                                        $brand = App\Brand::where('id', $color->brand_id)->first();
                                    @endphp
                                    {{-- $brand->stockPositionCheck($brand,$style) --}}
                                    @if (1 == 1)
                                    <tr>
                                        <td><strong>{{ $brand->name }}</strong></td>
                                        <td>{{ $itmXsC= isset($itmXs)? $itmXs->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? $itmS->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmMC=isset($itmM)? $itmM->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmLC=isset($itmL)? $itmL->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmXlC=isset($itmXl)? $itmXl->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmXxlC=isset($itmXxl)? $itmXxl->todayOpeningStock():0 }}</td>
                                        <td>{{  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @php
                                        $xsOpening=$xsOpening+$itmXsC;
                                        $sOpening=$sOpening +$itmSC;
                                        $mOpening=$mOpening+$itmMC;
                                        $lOpening=$lOpening+$itmLC;
                                        $xlOpening= $xlOpening+$itmXlC;
                                        $xxlOpening= $xxlOpening+$itmXxlC;
                                    @endphp
                                        <tr>
                                            <td><small>Sale</small></td>
                                            <td>{{ $itmXsC= isset($itmXs)? $itmXs->saleToday():0 }}</td>
                                            <td>{{ $itmSC =isset($itmS)? $itmS->saleToday():0 }}</td>
                                            <td>{{ $itmMC=isset($itmM)? $itmM->saleToday():0 }}</td>
                                            <td>{{ $itmLC=isset($itmL)? $itmL->saleToday():0 }}</td>
                                            <td>{{ $itmXlC=isset($itmXl)? $itmXl->saleToday():0 }}</td>
                                            <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->saleToday():0 }}</td>
                                            <td>{{  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC }}</td>
                                            <td></td>
                                        <td></td>
                                        <td></td>
                                        </tr>
                                    @php
                                        $xsSell=$xsSell+$itmXsC;
                                        $sSell=$sSell +$itmSC;
                                        $mSell=$mSell+$itmMC;
                                        $lSell=$lSell+$itmLC;
                                        $xlSell= $xlSell+$itmXlC;
                                        $xxlSell= $xxlSell+$itmXxlC;
                                    @endphp
                                    <tr>
                                        <td><small>Purchase</small></td>
                                        <td>{{$itmXsC= isset($itmXs)? $itmXs->purchaseToday():0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? $itmS->purchaseToday():0 }}</td>
                                        <td>{{$itmMC= isset($itmM)? $itmM->purchaseToday():0 }}</td>
                                        <td>{{$itmLC= isset($itmL)? $itmL->purchaseToday():0 }}</td>
                                        <td>{{$itmXlC= isset($itmXl)? $itmXl->purchaseToday():0 }}</td>
                                        <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->purchaseToday():0 }}</td>
                                        <td>{{  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @php
                                        $xsPurch=$xsPurch+$itmXsC;
                                        $sPurch=$sPurch +$itmSC;
                                        $mPurch=$mPurch+$itmMC;
                                        $lPurch=$lPurch+$itmLC;
                                        $xlPurch= $xlPurch+$itmXlC;
                                        $xxlPurch= $xxlPurch+$itmXxlC;
                                    @endphp
                                    <tr>
                                        <td><small>Current Stock</small></td>
                                        <td>{{$itmXsC= isset($itmXs)? $itmXs->itemStock():0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? $itmS->itemStock():0 }}</td>
                                        <td>{{$itmMC= isset($itmM)? $itmM->itemStock():0 }}</td>
                                        <td>{{ $itmLC=isset($itmL)? $itmL->itemStock():0 }}</td>
                                        <td>{{$itmXlC= isset($itmXl)? $itmXl->itemStock():0 }}</td>
                                        <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->itemStock():0 }}</td>
                                        <td>{{$qqttyy=  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC }}</td>
                                        @php
                                        $itmmmm= App\PurchaseDetail::where('item_id',isset($itmXs->id)? $itmXs->id:"null")
                                        ->orWhere('item_id',isset($itmS->id)? $itmS->id:"null")
                                        ->orWhere('item_id',isset($itmM->id)? $itmM->id:"null" )
                                        ->orWhere('item_id',isset($itmL->id)? $itmL->id:"null" )
                                        ->orWhere('item_id',isset($itmXl->id)? $itmXl->id:"null" )
                                        ->orWhere('item_id',isset($itmXxl->id)? $itmXxl->id:"null" )
                                        ->first();

                                        $itmmmmm= App\ItemList::where('id',isset($itmXs->id)? $itmXs->id:"null")
                                        ->orWhere('id',isset($itmS->id)? $itmS->id:"null")
                                        ->orWhere('id',isset($itmM->id)? $itmM->id:"null" )
                                        ->orWhere('id',isset($itmL->id)? $itmL->id:"null" )
                                        ->orWhere('id',isset($itmXl->id)? $itmXl->id:"null" )
                                        ->orWhere('id',isset($itmXxl->id)? $itmXxl->id:"null" )
                                        ->first();
                                        $ppppp=isset( $itmmmm)? $itmmmm->purchase_rate:0;
                                        $ttttt=isset( $itmmmmm)? $itmmmmm->total_amount:0
                                    @endphp
                                        <td>{{$ttttPU= number_format((float)($qqttyy*$ppppp),'2','.','')  }}</td>
                                        <td>{{$tttttSU=number_format((float)( $qqttyy*$ttttt ),'2','.','') }} </td>
                                        <td></td>
                                    </tr>
                                    @php
                                        $xsCurStock=$xsCurStock+$itmXsC;
                                        $sCurStock=$sCurStock +$itmSC;
                                        $mCurStock=$mCurStock+$itmMC;
                                        $lCurStock=$lCurStock+$itmLC;
                                        $xlCurStock= $xlCurStock+$itmXlC;
                                        $xxlCurStock= $xxlCurStock+$itmXxlC;
                                        $ttttP=$ttttP+$ttttPU;
                                        $tttttS=$tttttS+$tttttSU;
                                    @endphp
                                    @endif
                                @endforeach
                                <tr>
                                    <td><small>Opening Stock</small></td>
                                    <td>{{ $xsOpening }}</td>
                                    <td>{{ $sOpening }}</td>
                                    <td>{{ $mOpening }}</td>
                                    <td>{{ $lOpening }}</td>
                                    <td>{{ $xlOpening }}</td>
                                    <td>{{ $xxlOpening }}</td>
                                    <td>{{ $xsOpening + $sOpening + $mOpening + $lOpening + $xlOpening + $xxlOpening  }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td><small>Total Sale</small></td>
                                    <td>{{ $xsSell }}</td>
                                    <td>{{ $sSell }}</td>
                                    <td>{{ $mSell }}</td>
                                    <td>{{ $lSell }}</td>
                                    <td>{{ $xlSell }}</td>
                                    <td>{{ $xxlSell }}</td>
                                    <td>{{ $xsSell + $sSell + $mSell + $lSell + $xlSell + $xxlSell }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><small>Total Purchase</small></td>
                                    <td>{{  $xsPurch }}</td>
                                    <td>{{ $sPurch }}</td>
                                    <td>{{ $mPurch }}</td>
                                    <td>{{ $lPurch }}</td>
                                    <td>{{ $xlPurch }}</td>
                                    <td>{{ $xxlPurch }}</td>
                                    <td>{{ $xsPurch+$sPurch+$mPurch+$lPurch+$xlPurch+$xxlPurch }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><small>Total Current Stock</small></td>
                                    <td>{{ $xsCurStock }}</td>
                                    <td>{{ $sCurStock }}</td>
                                    <td>{{ $mCurStock }}</td>
                                    <td>{{ $lCurStock }}</td>
                                    <td>{{ $xlCurStock }}</td>
                                    <td>{{ $xxlCurStock }}</td>
                                    <td>{{ $xsCurStock + $sCurStock + $mCurStock + $lCurStock + $xlCurStock + $xxlCurStock  }}
                                    </td>
                                    <td>{{ number_format((float)($ttttP),'2','.','') }}</td>
                                    <td>{{  number_format((float)($tttttS),'2','.','') }}</td>
                                    <td></td>
                                </tr>
                                <tr style="height: 130px" class="text-center">
                                    <td>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th ><small>Prepared By</small> </th>
                                            <th><small>Checked By</small> </th>
                                            <th><small>Endorsed By</small> </th>
                                            <th><small>Authorized By</small> </th>
                                            <th><small>Authorized By</small> </th>
                                            <th><small>Approved By</small> </th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><small>Mahidul Islam Bappy</small> </td>
                                            <td><small>Ridwanuzzaman</small> </td>
                                            <td><small>Habibur Rahaman</small> </td>
                                            <td><small>Md. Akhter Hosain</small> </td>
                                            <td><small>S.M Arifen</small> </td>
                                            <td><small>Salim Osman</small> </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>


                                        </tr>

                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>


                </div>
            </div>
        </section>
    @endforeach
@endsection
