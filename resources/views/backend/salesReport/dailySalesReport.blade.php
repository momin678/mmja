@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        td{
            text-align: center !important;
        }
    </style>
@endpush
@php
    $grand_total_value=0;
    $grand_total_pcs=0;
@endphp
@section('title', 'Sales Report')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>{{ date('d M Y') }}  Sales Report</h4>
                           </div>
                           <div class="col-md-2 text-right">
                            <form action="{{ route('searchDailySale') }}" method="GET">
                               <div class="row form-group">
                                <input type="text" class="form-control col-9" name="date"  placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                               </div>
                            </form>
                           </div>
                           <div class="col-md-4  col-left-padding">
                            <form action="{{ route('searchDailySaleRange') }}" method="GET">
                                {{-- @csrf --}}
                                <div class="row form-group">
                                    <div class="col-5 col-right-padding">
                                        <input type="text" class="form-control" name="from"
                                        placeholder="From"  value="{{ isset($searchDatefrom)? $searchDatefrom:"" }}"  onfocus="(this.type='date')"  id="from" required>

                                    </div>
                                    <div class="col-5  col-left-padding col-right-padding">
                                        <input type="text" class="form-control" name="to"
                                        placeholder="To" value="{{ isset($searchDateto)? $searchDateto:"" }}" onfocus="(this.type='date')" id="to" required>
                                    </div>
                                    <button class="bx bx-search col-2 btn-warning btn-block" type="submit"></button>
                                </div>
                            </form>

                            <input type="hidden" name="hidden_date_from" value="{{ isset($from)? $from:"" }}" id="hidden_date_from">
                            <input type="hidden" name="hidden_date_to" value="{{ isset($to)? $to:"" }}" id="hidden_date_to">
                        </div>
                    </div>

                    <div class="row pt-2">
                        <div class="col-md-12">
                            <a href="{{ route('printDailySale') }}" class="btn btn-sm btn-info float-right"
                            target="_blank">Print</a>
                            <button class="btn  btn-info btn-sm float-right mr-1"
                        onclick="exportTableToCSV('stockPosition-{{ date('d M Y') }}.csv')">Export To CSV</button>
                        </div>
                        <table   class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center" colspan="14">Sales of {{ date('d M Y') }}</th>
                            </tr>
                            <tr>
                                <th class="text-center"  colspan="2">Item</th>
                                <th class="text-center">COLOR</th>
                                @foreach (App\Group::where('group_no','>', 10)->where('group_no','<', 18)->get() as $clr)
                                <th class="text-center">{{ $clr->group_name }} </th>
                                @endforeach
                            <th class="text-center">Total Pcs</th>
                            <th class="text-center">Rate per Pcs</th>
                            <th class="text-center">Total Value</th>
                            </tr>
                            @foreach (App\ItemList::where('group_no','>=', 11)->where('group_no','<=','17')->select('style_id')->distinct()->get() as $it)
                                @php
                                    $style=App\Style::where('id', $it->style_id)->first();
                                    $row=0;
                                    $styleQty=0;
                                    $styleAmount=0;
                                    $colorCount=App\ItemList::where('group_no','>', 10)->where('group_no','<',18)->select('brand_id')->where('style_id',$it->style_id)->distinct()->get();

                                @endphp
                                @if($style->colorSaleCountToday($style->id)>0)
                                <tr>
                                    <td rowspan="{{ $style->colorSaleCountToday($style->id) }}" colspan="2">{{ $style->style_name }}</td>
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
                                        $itmXsC= isset($itmXs)? $itmXs->saleToday():0;
                                            $itmSC =isset($itmS)? $itmS->saleToday():0;
                                            $itmMC=isset($itmM)? $itmM->saleToday():0;
                                            $itmLC=isset($itmL)? $itmL->saleToday():0;
                                            $itmXlC=isset($itmXl)? $itmXl->saleToday():0;
                                            $itmXxlC= isset($itmXxl)? $itmXxl->saleToday():0;
                                            $itmXxxlC=isset($itmXxxl)? $itmXxxl->saleToday():0;
                                            $colorQtycheck= $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC;
                                    @endphp
                                    {{-- @if($brand->colorItemSaleAmount($style,$brand)>0) --}}
                                    @if($colorQtycheck >0)
                                    @if($row==0)

                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $itmXsC= isset($itmXs)? $itmXs->saleToday():0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? $itmS->saleToday():0 }}</td>
                                        <td>{{ $itmMC=isset($itmM)? $itmM->saleToday():0 }}</td>
                                        <td>{{ $itmLC=isset($itmL)? $itmL->saleToday():0 }}</td>
                                        <td>{{ $itmXlC=isset($itmXl)? $itmXl->saleToday():0 }}</td>
                                        <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->saleToday():0 }}</td>
                                        <td>{{ $itmXxxlC=isset($itmXxxl)? $itmXxxl->saleToday():0 }}</td>
                                        <td>{{ $colorQty= $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC }}</td>
                                        <td>{{number_format((float)$brand->colorItemSaleRate($style,$brand), 3,'.','') }}</td>
                                        <td>{{$colorAmount= number_format((float)$brand->colorItemSaleAmount($style,$brand),'2','.','') }}</td>
                                        @php
                                            $row=1;
                                        @endphp

                                    @else
                                    <tr>
                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $itmXsC= isset($itmXs)? $itmXs->saleToday():0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? $itmS->saleToday():0 }}</td>
                                        <td>{{ $itmMC=isset($itmM)? $itmM->saleToday():0 }}</td>
                                        <td>{{ $itmLC=isset($itmL)? $itmL->saleToday():0 }}</td>
                                        <td>{{ $itmXlC=isset($itmXl)? $itmXl->saleToday():0 }}</td>
                                        <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->saleToday():0 }}</td>
                                        <td>{{ $itmXxxlC=isset($itmXxxl)? $itmXxxl->saleToday():0 }}</td>
                                        <td>{{$colorQty=  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC }}</td>
                                        <td>{{number_format((float)$brand->colorItemSaleRate($style,$brand), 3,'.','') }}</td>

                                        <td>{{$colorAmount= number_format((float)$brand->colorItemSaleAmount($style,$brand),'2','.','') }}</td>
                                    </tr>
                                    @endif
                                    {{-- @endif --}}

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
                                        <td style="font-weight: bold;">{{$stylAmnt=number_format((float) $styleAmount,'2','.','') }}</td>
                                    </tr>
                                </tr>
                                @php

                                $grand_total_value=$grand_total_value+$stylAmnt;
                                $grand_total_pcs=$grand_total_pcs+$styleQty;
                            @endphp
                                @endif
                            @endforeach

                            <tr>
                                <th class="text-center"  colspan="3">Item</th>
                                <th class="text-center">COLOR</th>
                                @foreach (App\Group::where('group_no','>', 17)->where('group_no','<', 24)->get() as $clr)
                                <th class="text-center">{{ $clr->group_name }} </th>
                                @endforeach
                            <th class="text-center">Total Pcs</th>
                            <th class="text-center">Rate per Pcs</th>
                            <th class="text-center">Total Value</th>
                            </tr>
                            @foreach (App\ItemList::where('group_no','>', 17)->where('group_no','<',24)->select('style_id')->distinct()->get() as $it)
                                @php
                                    $style=App\Style::where('id', $it->style_id)->first();
                                    $row=0;
                                    $styleQty=0;
                                    $styleAmount=0;
                                    $colorCount=App\ItemList::where('group_no','>', 17)->where('group_no','<',24)->select('brand_id')->where('style_id',$it->style_id)->distinct()->get();

                                @endphp
                                @if($style->colorSaleCountToday($style->id)>0)
                                <tr>
                                    <td rowspan="{{ $style->colorSaleCountToday($style->id) }}" colspan="3">{{ $style->style_name }}</td>
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
                                        $itmXsC= isset($itmXs)? $itmXs->saleToday():0;
                                            $itmSC =isset($itmS)? $itmS->saleToday():0;
                                            $itmMC=isset($itmM)? $itmM->saleToday():0;
                                            $itmLC=isset($itmL)? $itmL->saleToday():0;
                                            $itmXlC=isset($itmXl)? $itmXl->saleToday():0;
                                            $itmXxlC= isset($itmXxl)? $itmXxl->saleToday():0;
                                            $colorQtycheck= $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC;
                                    @endphp
                                    {{-- @if($brand->colorItemSaleAmount($style,$brand)>0) --}}
                                    @if($colorQtycheck >0)
                                    @if($row==0)

                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $itmXsC= isset($itmXs)? $itmXs->saleToday():0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? $itmS->saleToday():0 }}</td>
                                        <td>{{ $itmMC=isset($itmM)? $itmM->saleToday():0 }}</td>
                                        <td>{{ $itmLC=isset($itmL)? $itmL->saleToday():0 }}</td>
                                        <td>{{ $itmXlC=isset($itmXl)? $itmXl->saleToday():0 }}</td>
                                        <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->saleToday():0 }}</td>
                                        <td>{{ $colorQty= $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC }}</td>
                                        <td>{{number_format((float)$brand->colorItemSaleRate($style,$brand), 3,'.','') }}</td>
                                        <td>{{$colorAmount= number_format((float)$brand->colorItemSaleAmount($style,$brand),'2','.','') }}</td>
                                        @php
                                            $row=1;
                                        @endphp

                                    @else
                                    <tr>
                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $itmXsC= isset($itmXs)? $itmXs->saleToday():0 }}</td>
                                        <td>{{ $itmSC =isset($itmS)? $itmS->saleToday():0 }}</td>
                                        <td>{{ $itmMC=isset($itmM)? $itmM->saleToday():0 }}</td>
                                        <td>{{ $itmLC=isset($itmL)? $itmL->saleToday():0 }}</td>
                                        <td>{{ $itmXlC=isset($itmXl)? $itmXl->saleToday():0 }}</td>
                                        <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->saleToday():0 }}</td>
                                        <td>{{$colorQty=  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC}}</td>
                                        <td>{{number_format((float)$brand->colorItemSaleRate($style,$brand), 3,'.','') }}</td>

                                        <td>{{$colorAmount= number_format((float)$brand->colorItemSaleAmount($style,$brand),'2','.','') }}</td>
                                    </tr>
                                    @endif
                                    {{-- @endif --}}

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
                                        <td style="font-weight: bold;">{{$stylAmnt=number_format((float) $styleAmount,'2','.','') }}</td>
                                    </tr>
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
