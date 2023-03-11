@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
         th{
            text-transform: uppercase;
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
                            <h4>Monthly Stock Report</h4>
                           </div>
                           <div class="col-md-4 text-right">
                            <form action="{{ route('searchStockPosition') }}" method="GET">
                                {{-- @csrf --}}
                               <div class="row form-group">
                                <input type="month" class="form-control col-9" name="month" value="{{ $month }}" placeholder="Select Month" onfocus="(this.type='month')" id="month">
                                <button class="bx bx-search col-3 btn-warning btn-block" type="submit"></button>
                               </div>
                            </form>
                           </div>
                    </div>

                    <div class="row">
                        @foreach (App\ItemList::select('style_id')->distinct()
                          ->get() as $it)
                          <div class="col-12" style="background-color: gray; color:black">
                            <strong><tr>Style No:</tr> <tr>{{ App\Style::where('id',$it->style_id )->first()->style_name }}</tr></strong>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-sm table-sm table-sm table-bordered">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">Barcode</th>
                                <th scope="col">Size</th>
                                <th scope="col">Color</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Stock <small>(Opening)</small></th>

                                <th scope="col">  Purchase <small>(PCS)</small></th>
                                <th scope="col">Sale <small>(PCS)</small></th>
                                <th scope="col">Pur. Return</th>
                                <th scope="col">Sale Return</th>
                                <th scope="col">Stock Total</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach (app\ItemList::where('style_id',$it->style_id)->get() as $item)
                                <tr>
                                    <td>{{ $item->barcode }}</td>
                                    <td>{{ $item->group_name }}</td>

                                    <td>{{ $item->brand->name }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->itemOpenningStockMonth($month)!=null ? $item->itemOpenningStockMonth($month)->quantity:"0" }}</td>

                                    <td>{{  $item->MontItemPurch($item,$month) }}</td>
                                    <td>{{  $item->MonthItemSale($item,$month) }}</td>
                                    <td></td>
                                    <td>{{  $item->MonthItemSaleReturn($item,$month) }}</td>
                                    @php
                                        $openingQuantity=$item->itemOpenningStockMonth($month)!=null ? $item->itemOpenningStockMonth($month)->quantity:"0";
                                        // dd($openingQuantity);
                                    @endphp
                                    <td>{{ $item->MontItemPurch($item,$month) + $item->MonthItemSaleReturn($item,$month) - $item->MonthItemSale($item,$month) + $openingQuantity  }}</td>

                                </tr>

                                @endforeach


                            </tbody>
                        </table>
                        </div>
                        @endforeach
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
