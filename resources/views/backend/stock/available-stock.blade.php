@extends('layouts.backend.app')
@section('title', 'Stock Position')
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
                            <h4> Available Stock</h4>
                        </div>

                    </div>



                    <div class="row pt-2">
                        <div class="col-md-12">
                            <a href="{{ route('printStockPosition') }}" class="btn btn-sm btn-info float-right"
                            target="_blank">Print</a>
                            <button class="btn  btn-info btn-sm float-right mr-1"
                        onclick="exportTableToCSV('stockPosition-{{ date('d M Y') }}.csv')">Export To CSV</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                @foreach (App\ItemList::where('group_no','>=', 11)->where('group_no','<=','17')->select('style_id')->distinct()->get() as $it)

                                    {{-- @foreach (App\ItemList::select('style_id')->distinct()->get() as $it) --}}
                                        @php
                                            $style=App\Style::where('id', $it->style_id)->first();
                                            $xsOpening=0;$xsSell=0;$xsCurStock=0;$sOpening=0; $sSell=0;$sCurStock=0;$mOpening=0;$mSell=0;$mCurStock=0;$lOpening=0;
                                            $lSell=0;$lCurStock=0;$xlOpening=0;$xlSell=0;$xlCurStock=0;$xxlOpening=0; $xxlSell=0;$xxlCurStock=0;
                                            $xxxlOpening=0;$xxxlSell=0;$xxxlCurStock=0;
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
                                        <td>{{ $itmXsC= isset($itmXs)? ($itmXs->avail_stock? $itmXs->avail_stock->quantity:0):0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? ($itmS->avail_stock?$itmS->avail_stock->quantity:0):0 }}</td>
                                        <td>{{ $itmMC=isset($itmM)? ($itmM->avail_stock? $itmM->avail_stock->quantity:0):0 }}</td>
                                        <td>{{ $itmLC=isset($itmL)? ($itmL->avail_stock?$itmL->avail_stock->quantity:0):0 }}</td>
                                        <td>{{ $itmXlC=isset($itmXl)? ($itmXl->avail_stock?$itmXl->avail_stock->quantity:0):0 }}</td>
                                        <td>{{ $itmXxlC=isset($itmXxl)? ($itmXxl->avail_stock?$itmXxl->avail_stock->quantity:0):0 }}</td>
                                        <td>{{ $itmXxxlC=isset($itmXxxl)? ($itmXxxl->avail_stock?$itmXxxl->avail_stock->quantity:0):0 }}</td>
                                        <td>{{  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC }}</td>

                                    </tr>



                                    @endif
                                        @endforeach


                                    @endif
                                @endforeach
                                @foreach (App\ItemList::where('group_no','>', 17)->where('group_no','<','24')->select('style_id')->distinct()->get() as $it)

                                    @php
                                        $style=App\Style::where('id', $it->style_id)->first();
                                        // dd($style);
                                        $xsOpening=0;$xsSell=0;$xsCurStock=0;$sOpening=0; $sSell=0;$sCurStock=0;$mOpening=0;$mSell=0;$mCurStock=0;$lOpening=0;
                                        $lSell=0;$lCurStock=0;$xlOpening=0;$xlSell=0;$xlCurStock=0;$xxlOpening=0; $xxlSell=0;$xxlCurStock=0;
                                        $xxxlOpening=0;$xxxlSell=0;$xxxlCurStock=0;
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
                                        <th class="text-center">{{ $clr->group_name }} </th>
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
                                    <td>{{ $itmXsC= isset($itmXs)? ($itmXs->avail_stock? $itmXs->avail_stock->quantity:0):0 }}</td>
                                    <td>{{ $itmSC =isset($itmS)? ($itmS->avail_stock?$itmS->avail_stock->quantity:0):0 }}</td>
                                    <td>{{ $itmMC=isset($itmM)? ($itmM->avail_stock? $itmM->avail_stock->quantity:0):0 }}</td>
                                    <td>{{ $itmLC=isset($itmL)? ($itmL->avail_stock?$itmL->avail_stock->quantity:0):0 }}</td>
                                    <td>{{ $itmXlC=isset($itmXl)? ($itmXl->avail_stock?$itmXl->avail_stock->quantity:0):0 }}</td>
                                    <td>{{ $itmXxlC=isset($itmXxl)? ($itmXxl->avail_stock?$itmXxl->avail_stock->quantity:0):0 }}</td>
                                    <td>{{  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC }}</td>
                                </tr>






                                @endif
                                    @endforeach
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
