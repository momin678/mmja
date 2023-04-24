@extends('layouts.backend.app')
@php
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
@endphp
@section('title', 'Inventory Valuation Summery')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content print-hidden">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="tab-content bg-white">
            <div>
                <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                    <div class="row">
                        <div class="col-md-12  mt-2 text-center">
                            <h4>{{ $company_name->config_value}}</h4>
                            <h5>Product Sales Cost</h5>
                            @php
                                $startDate= '2023-03-01';
                                $endDate= '2023-03-31';
                            @endphp
                            <h6>From {{$startDate}} To {{$endDate}}</h6>
                        </div>
                        {{-- <div class="col-md-6  mt-2 text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                Fitter
                              </button>
                        </div> --}}
                    </div>
                </section>

                <section class="mr-1 ml-1">
                    <div class="mt-2">
                        <div class="cardStyleChange">
                            <table class="table mb-0 table-sm table-hover exprortTable">
                                <thead  class="thead-light">
                                    <tr style="height: 50px;">
                                        <th>Item name</th>
                                        <th>SKU</th>
                                        <th>Sold QTY</th>
                                        <th>Selling Price Per Unit</th>
                                        <th>Cost Price Per Unit</th>
                                        <th>Total Selling Price</th>
                                        <th>Total Cost Price</th>
                                        <th>Average Margin Per Unit</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @php
                                        
                                    @endphp
                                    @foreach ($items as $key => $item)
                                            @php
                                                $unit_sale_price= number_format($item->avg_sales_price(),2);
                                                $avg_cost_price= number_format($item->inventory_value_avg(),2);
                                                $sales_qty= $item->sales_qty();
                                                $total_sales_value= $sales_qty * $unit_sale_price;
                                                $total_cost_value= $sales_qty * $avg_cost_price;
                                                $margin= $unit_sale_price-$avg_cost_price;
                                            @endphp
                                        
                                        <tr class="trFontSize">
                                            <td>{{ $item->item_name}}</td>
                                            <td>{{ $item->sku}}</td>
                                            <td>{{ $item->stockOutDate($startDate,$endDate)}}</td>
                                            <td>{{ $unit_sale_price }}</td>
                                            <td>{{ $avg_cost_price }}</td>
                                            <td>{{ $item->total_sales()}}</td>
                                            <td>{{ $total_cost_value }}</td>
                                            <td>{{ $margin}}</td>
                                        </tr>
                                        

                                    @endforeach
                                    {{-- <tr>
                                        <td>Total</td>
                                        <td></td>
                                        <td>0</td>
                                        <td class="text-right pr-2"><small>(AED)</small> {{$total_amount}}</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="purchase-order-modal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="min-width: 90% !important;">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                </div>
            </section>
            <div id="purchase-order-by-vendor-details-content">
                
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Customize Report</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="">
                    {{-- <div class="form-group">
                        <label for="">Date Range</label>
                        <select name="date_range" id="" class="form-control">
                            <option value="">Select Option</option>
                            <option value="{{date('Y-m-d')}}">Today</option>
                            <option value="{{date('m')}}">This Week</option>
                            <option value="this_month">This Month</option>
                            <option value="{{date('Y')}}">This Yesr</option>
                        </select>
                    </div> --}}
                    <div class="form-group">
                        <label for="">Single Date</label>
                        <input type="date" name="date" class="form-control">
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="">Date From</label>
                            <input type="date" class="form-control" name="date_from">
                        </div>
                        <div class="col-md-6">
                            <label for="">Date To</label>
                            <input type="date" class="form-control" name="date_to">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>
        $(document).on("click", ".purchase-order-by-vendor-details", function(e) {
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{URL('purchase-order-by-vendor-details')}}",
                method: "POST",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){
                    document.getElementById("purchase-order-by-vendor-details-content").innerHTML = response;
                    $('#purchase-order-modal').modal('show');
                }
            });
        });
    </script>
@endpush