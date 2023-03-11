@extends('layouts.pdf.app')
@section('css')
    <style>
    .form-control {
        border: 0;
    }
    </style>
@endsection
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1>Goods Received</h1>
                        </div>
                    </div>
                    <form action="{{route('purchase-temp-trasfer')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="">
                                <div class="card-body content-padding">
                                    <div class="row">
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">GR No</label>
                                            <p>{{$gr_info->goods_received_no}}</p>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">PO No</label>
                                            <p>{{$gr_info->po_no}}</p>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">PR No</label>
                                            <p>{{$gr_info->pr_no}}</p>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="project_id">Branch Name</label>
                                            <p>{{$gr_info->projectInfo->proj_name}}</p>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">Supplier Name</label>
                                            <p>{{$gr_info->partInfo->pi_name}}</p>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="mode">Delivery Note No</label>
                                            <p>{{$gr_info->challan_number}}</p>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <label for="">GR Date:</label>
                                            <p>{{date('d-m-Y', strtotime($gr_info->date))}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">PO Qty</th>
                                    <th scope="col">Received Qty</th>
                                    <th scope="col">Pending Qty</th>
                                </tr>
                            </thead>
                            <tbody id="tempLists"  class="user-table-body">
                                @foreach ($goods_received_details as $item)
                                <tr class="data-row">
                                    <td>
                                        {{$item->itemName->barcode}}
                                    </td>
                                    <td>
                                        {{$item->itemName->item_name}}
                                    </td>
                                    <td>
                                        {{$item->itemName->brandName->name}}
                                    </td>
                                    <td>
                                        {{$item->itemName->group_name}}
                                    </td>
                                    <td>
                                        {{$item->received_qty + $item->pandding_qty}}
                                    </td>
                                    <td>
                                        {{$item->received_qty}}
                                    </td>
                                    <td>
                                        {{$item->pandding_qty}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                    <div class="row mt-5 pt-5">
                        <div class="col-12">
                            <div class="mt-5">
                                <div class="d-flex text-center" style="justify-content: space-between">
                                    <div>
                                        <h6>Prepared By:</h5>
                                        <h5>Mahidul Islam Bappi</h5>
                                    </div>
                                    <div>
                                        <h5>Endorsed By:</h5>
                                        <h5>Mohammad Habibur Rahman</h5>
                                    </div>
                                    <div>
                                        <h5>Authorized By:</h5>
                                        <h5>Md. Akhter Hossain</h5>
                                    </div>
                                    <div>
                                        <h5>Approved By:</h5>
                                        <h5>Salim Osman</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
