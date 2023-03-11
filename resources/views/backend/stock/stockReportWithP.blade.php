@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        td{
            text-align: right !important;
        }
        th{
            text-transform: uppercase;
        }
    </style>
@endpush

@section('content')
@php
@endphp
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-4">
                            <h4>{{ date('d M Y') }} Stock Report</h4>
                        </div>
                        <div class="col-md-2 text-right col-right-padding">
                            <form action="{{ route('searchStockPositionDateP') }}" method="GET">
                                {{-- @csrf --}}
                                <div class="row form-group col-right-padding">
                                    <input type="text" class="form-control col-9" name="date"
                                        placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                    <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 col-right-padding">
                            <form action="{{ route('searchStockPositionRangeP') }}" method="GET">
                                {{-- @csrf --}}
                                <div class="row form-group">
                                    <div class="col-5 col-right-padding">
                                        <input type="text" class="form-control" name="from"
                                        placeholder="From" onfocus="(this.type='date')" id="from" required>
                                    </div>
                                    <div class="col-5 col-left-padding col-right-padding">
                                        <input type="text" class="form-control" name="to"
                                        placeholder="To" onfocus="(this.type='date')" id="to" required>
                                    </div>
                                    <button class="bx bx-search col-2 btn-warning btn-block" type="submit"></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('stockPosition' ) }}" class="btn btn-info"><small>Without Purchase</small></a>
                        </div>
                    </div>



                    <div class="row pt-2">
                        <div class="col-md-12">
                            <a href="{{ route('printStockPositionP') }}" class="btn btn-sm btn-info float-right"
                            target="_blank">Print</a>
                            <button class="btn  btn-info btn-sm float-right mr-1"
                        onclick="exportTableToCSV('stockPosition-{{ date('d M Y') }}.csv')">Export To CSV</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                @foreach (App\ItemList::where('group_no','>=', 11)->where('group_no','<=','17')->select('style_id')->distinct()->get() as $it)
                            @php
                                $style=App\Style::where('id', $it->style_id)->first();
                                $xsOpening=0;$xsSell=0;$xsCurStock=0;$sOpening=0; $sSell=0;$sCurStock=0;$mOpening=0;$mSell=0;$mCurStock=0;$lOpening=0;
                                $lSell=0;$lCurStock=0;$xlOpening=0;$xlSell=0;$xlCurStock=0;$xxlOpening=0; $xxlSell=0;$xxlCurStock=0;
                                $xxxlOpening=0;$xxxlSell=0;$xxxlCurStock=0; $xsPurch=0;$sPurch=0;$mPurch=0;$lPurch=0;$xlPurch=0;$xxlPurch=0;$xxxlPurch=0;
                                $ttttP=0;
                                            $tttttS=0;
                            @endphp
                            {{-- $style->styleSTockPositionCheck($style) --}}
                                @if(1==1)

                                    <tr>
                                        <th class="text-center" colspan="12">
                                            {{ $style->style_name }}  </th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="width: 130px">COLOR</th>
                                        @foreach (App\Group::where('group_no','>=', 11)->where('group_no','<=', 17)->get() as $clr)
                                        <th class="text-center">{{ $clr->group_name }}</th>
                                        @endforeach
                                        <th class="text-center">Total</th>
                                        <th><small><strong>Cost Price</strong></small></th>
                                            <th><small><strong>Sale Price</strong></small></th>
                                    </tr>
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
                                    @endphp
                                    {{-- $brand->stockPositionCheck($brand,$style) --}}
                                   @if( 1==1)
                                    <tr>
                                        <td><strong>{{ $brand->name }}</strong></td>
                                        <td>{{ $itmXsC= isset($itmXs)? $itmXs->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? $itmS->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmMC=isset($itmM)? $itmM->todayOpeningStock():0 }} </td>
                                        <td>{{ $itmLC=isset($itmL)? $itmL->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmXlC=isset($itmXl)? $itmXl->todayOpeningStock():0 }} </td>
                                        <td>{{ $itmXxlC=isset($itmXxl)? $itmXxl->todayOpeningStock():0 }}</td>
                                        <td>{{ $itmXxxlC=isset($itmXxxl)? $itmXxxl->todayOpeningStock():0 }}</td>
                                        <td>{{  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC }}</td>
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
                                        <td>{{ $xsOpening+$sOpening+$mOpening+$lOpening+$xlOpening+$xxlOpening+$xxxlOpening }}</td>
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
                                        <td>{{ $xsSell+$sSell+$mSell+$lSell+$xlSell+$xxlSell+$xxxlSell }}</td>
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
                                    </tr>

                                    <tr>
                                        <td><small>Total Current Stock</small></td>
                                        <td>{{  $xsCurStock }}</td>
                                        <td>{{ $sCurStock }}</td>
                                        <td>{{ $mCurStock }}</td>
                                        <td>{{ $lCurStock }}</td>
                                        <td>{{ $xlCurStock }}</td>
                                        <td>{{ $xxlCurStock }}</td>
                                        <td>{{ $xxxlCurStock }}</td>
                                        <td>{{ $xsCurStock+$sCurStock+$mCurStock+$lCurStock+$xlCurStock+$xxlCurStock+$xxxlCurStock }}</td>
                                        <td>{{ number_format((float)($ttttP),'2','.','') }}</td>
                                        <td>{{  number_format((float)($tttttS),'2','.','') }}</td>
                                    </tr>
                            @endif
                        @endforeach




                        @foreach (App\ItemList::where('group_no','>', 17)->where('group_no','<','24')->select('style_id')->distinct()->get() as $it)
                        @php
                            $style=App\Style::where('id', $it->style_id)->first();
                            $xsOpening=0;$xsSell=0;$xsCurStock=0;$sOpening=0; $sSell=0;$sCurStock=0;$mOpening=0;$mSell=0;$mCurStock=0;$lOpening=0;
                            $lSell=0;$lCurStock=0;$xlOpening=0;$xlSell=0;$xlCurStock=0;$xxlOpening=0; $xxlSell=0;$xxlCurStock=0;
                            $xxxlOpening=0;$xxxlSell=0;$xxxlCurStock=0; $xsPurch=0;$sPurch=0;$mPurch=0;$lPurch=0;$xlPurch=0;$xxlPurch=0;$xxxlPurch=0;
                            $ttttP=0;
                                        $tttttS=0;
                        @endphp
                        {{-- $style->styleSTockPositionCheck($style) --}}
                            @if(1==1)

                                <tr>
                                    <th class="text-center" colspan="12">
                                        {{ $style->style_name }}  </th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="width: 130px">COLOR</th>
                                    @foreach (App\Group::where('group_no','>', 17)->where('group_no','<', 24)->get() as $clr)
                                    <th class="text-center">{{ $clr->group_name }}</th>

                                    @endforeach
                                    <th class="text-center">Total</th>
                                    <th><small><strong>Cost Price</strong></small></th>
                                        <th><small><strong>Sale Price</strong></small></th>
                                </tr>
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
                                @endphp
                                {{-- $brand->stockPositionCheck($brand,$style) --}}
                               @if( 1==1)
                                <tr>
                                    <td><strong>{{ $brand->name }}</strong></td>
                                    <td>{{ $itmXsC= isset($itmXs)? $itmXs->todayOpeningStock():0 }}</td>
                                    <td>{{ $itmSC =isset($itmS)? $itmS->todayOpeningStock():0 }}</td>
                                    <td>{{ $itmMC=isset($itmM)? $itmM->todayOpeningStock():0 }} </td>
                                    <td>{{ $itmLC=isset($itmL)? $itmL->todayOpeningStock():0 }}</td>
                                    <td>{{ $itmXlC=isset($itmXl)? $itmXl->todayOpeningStock():0 }} </td>
                                    <td>{{ $itmXxlC=isset($itmXxl)? $itmXxl->todayOpeningStock():0 }}</td>
                                    <td>{{  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC}}</td>
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
                                    <td>{{  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC }}</td>
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
                                    <td>{{  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC }}</td>
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
                                    <td>{{ $xsOpening+$sOpening+$mOpening+$lOpening+$xlOpening+$xxlOpening}}</td>
                                </tr>

                                <tr>
                                    <td><small>Total Sale</small></td>
                                    <td>{{ $xsSell }}</td>
                                    <td>{{ $sSell }}</td>
                                    <td>{{ $mSell }}</td>
                                    <td>{{ $lSell }}</td>
                                    <td>{{ $xlSell }}</td>
                                    <td>{{ $xxlSell }}</td>
                                    <td>{{ $xsSell+$sSell+$mSell+$lSell+$xlSell+$xxlSell }}</td>
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
                                </tr>

                                <tr>
                                    <td><small>Total Current Stock</small></td>
                                    <td>{{  $xsCurStock }}</td>
                                    <td>{{ $sCurStock }}</td>
                                    <td>{{ $mCurStock }}</td>
                                    <td>{{ $lCurStock }}</td>
                                    <td>{{ $xlCurStock }}</td>
                                    <td>{{ $xxlCurStock }}</td>
                                    <td>{{ $xsCurStock+$sCurStock+$mCurStock+$lCurStock+$xlCurStock+$xxlCurStock }}</td>
                                    <td>{{ number_format((float)($ttttP),'2','.','') }}</td>
                                    <td>{{  number_format((float)($tttttS),'2','.','') }}</td>
                                </tr>
                        @endif
                    @endforeach

                    </table>
                </div>
                    </div>

                </section>
                <!-- Widgets Statistics End -->



            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        // $(document).ready(function() {
        // Page Script
        // alert("Alhamdulillah");
        // });
    </script>
@endpush
