@extends('layouts.backend.app')

@section('title', 'invoice-posting')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                        <div class="table-responsive card">
                            <div class="card-header">
                                <h4 class="card-title">Pending Post</h4>
                            </div>
                            <table class="table table-bordered mb-0 table-sm">
                                <thead>
                                    <tr>
                                        <th>Goods Received NO</th>
                                        <th>PO NO</th>
                                        <th>Branch Name</th>
                                        <th>SUPPLIER NAME</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($goods_received as $item)
                                        <tr>
                                            <td>{{$item->goods_received_no}}</td>
                                            <td>{{$item->po_no}}</td>
                                            <td>{{$item->projectInfo->proj_name}}</td>
                                            <td>{{$item->partInfo->pi_name}}</td>
                                            <td>
                                                <a href="{{route('invoice_post_form', $item->id)}}" class="btn btn-sm btn-success">Process</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>{{$goods_received->links()}}</div>
                    </div>
                    <div class="table-responsive col-md-2 col-sm-2 col-12 col-lg-2">
                        <div><h5>IP No</h5></div>
                        <div class="purchase-items">
                            <ul>
                                @foreach ($invoice_posted as $each_item)
                                    <li><a href="{{route('ip_details', $each_item->id)}}">{{$each_item->invoice_posting_no}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div>{{$invoice_posted->links()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
@endpush