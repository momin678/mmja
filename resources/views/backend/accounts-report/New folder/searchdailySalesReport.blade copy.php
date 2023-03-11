@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        td{
            text-align: center !important;
        }
    </style>
@endpush
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>{{ $date }} Sales Report</h4>
                           </div>
                           <div class="col-md-4 text-right">
                            <form action="{{ route('searchDailySale') }}" method="GET">
                               <div class="row form-group">
                                <input type="text" class="form-control col-9" name="date" value="{{ $date }}" placeholder="Select Date" onfocus="(this.type='date')" id="date" required>
                                <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                               </div>
                            </form>
                           </div>
                    </div>

                    <div class="row pt-2">
                        <div class="col-md-12">
                            <a href="{{ route('printDailySaleDate',$date) }}" class="btn btn-sm btn-info float-right"
                            target="_blank">Print</a>
                            <button class="btn  btn-info btn-sm float-right mr-1"
                        onclick="exportTableToCSV('stockPosition-{{ date('d M Y') }}.csv')">Export To CSV</button>
                        </div>
                        <table   class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center" colspan="14">Sales of {{ $date }}</th>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2">Item</td>
                                <td class="text-center">COLOR</td>
                            <td class="text-center">Xs</td>
                            <td class="text-center">S</td>
                            <td class="text-center">M</td>
                            <td class="text-center">L</td>
                            <td class="text-center">XL</td>
                            <td class="text-center">Xxl</td>
                            <td class="text-center">Xxxl</td>
                            <td class="text-center">Total Pcs</td>
                            <td class="text-center">Rate per Pcs</td>
                            <td class="text-center">Total Value</td>
                            </tr>
                            @foreach (App\ItemList::select('style_id')->distinct()->get() as $it)
                            @php
                                $style=App\Style::where('id', $it->style_id)->first();
                                $row=0;
                                $styleQty=0;
                                $styleAmount=0;
                                $colorCount=App\ItemList::select('brand_id')->where('style_id',$it->style_id)->distinct()->get();

                            @endphp
                            <tr>
                                <td rowspan="{{ $colorCount->count() }}" colspan="2">{{ $style->style_name }}</td>
                                @foreach (App\ItemList::select('brand_id')->where('style_id',$it->style_id)->distinct()->get()
                                    as $color)
                                       @php
                                       $itmXs= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_name','Xs')->first();
                                       $itmS= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_name','S')->first();
                                       $itmM= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_name','M')->first();
                                       $itmL= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_name','L')->first();
                                       $itmXl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_name','Xl')->first();
                                       $itmXxl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_name','Xxl')->first();
                                       $itmXxxl= App\ItemList::where('style_id', $it->style_id)->where('brand_id',$color->brand_id)->where('group_name','Xxxl')->first();
                                       $brand=App\Brand::where('id',$color->brand_id)->first();
                                       $itmXsC= isset($itmXs)? $itmXs->dateSale($date):0;
                                        $itmSC =isset($itmS)? $itmS->dateSale($date):0;
                                        $itmMC=isset($itmM)? $itmM->dateSale($date):0;
                                        $itmLC=isset($itmL)? $itmL->dateSale($date):0;
                                        $itmXlC=isset($itmXl)? $itmXl->dateSale($date):0;
                                        $itmXxlC= isset($itmXxl)? $itmXxl->dateSale($date):0;
                                        $itmXxxlC=isset($itmXxxl)? $itmXxxl->dateSale($date):0;
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
                                    <td>{{ $colorQty }}</td>
                                    <td>{{number_format((float)$brand->colorItemSaleRateDate($style,$brand,$date), 3,'.','') }}</td>
                                    <td>{{$colorAmount = $brand->colorItemSaleAmountDate($style,$brand,$date) }}</td>
                                    @php
                                        $row=1;
                                    @endphp

                                @else
                                <tr>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $itmXsC= isset($itmXs)? $itmXs->dateSale($date):0 }}</td>
                                    <td>{{ $itmSC =isset($itmS)? $itmS->dateSale($date):0 }}</td>
                                    <td>{{ $itmMC=isset($itmM)? $itmM->dateSale($date):0 }}</td>
                                    <td>{{ $itmLC=isset($itmL)? $itmL->dateSale($date):0 }}</td>
                                    <td>{{ $itmXlC=isset($itmXl)? $itmXl->dateSale($date):0 }}</td>
                                    <td>{{$itmXxlC= isset($itmXxl)? $itmXxl->dateSale($date):0 }}</td>
                                    <td>{{ $itmXxxlC=isset($itmXxxl)? $itmXxxl->dateSale($date):0 }}</td>
                                    <td>{{$colorQty=  $itmXsC+$itmSC+$itmMC+$itmLC+$itmXlC+$itmXxlC+$itmXxxlC }}</td>
                                    <td>{{number_format((float)$brand->colorItemSaleRateDate($style,$brand,$date), 3,'.','') }}</td>
                                    <td>{{$colorAmount= $brand->colorItemSaleAmountDate($style,$brand,$date) }}</td>
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
                                    <td style="font-weight: bold;">{{ $styleAmount }}</td>
                                </tr>
                            </tr>
                            @endforeach

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
