@extends('layouts.backend.app')

@section('title', 'revise pv editor authorizer')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="table-responsive card">
                            <div class="card-header">
                                <h4 class="card-title">PV Revise Authorizer</h4>
                            </div>
                            <table class="table table-sm table-bordered">
                                <thead class="user-table-body">
                                    <tr>
                                        <th>PV NO</th>
                                        <th>IP NO</th>
                                        <th>GR NO</th>
                                        <th>Comment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($revise_pt_editor_authorizer as $item)
                                    @php
                                        $n = App\Notification::where("purchase_id", $item->payment_voucher_no)->where("status", 99)->first();
                                    @endphp
                                        <tr class="data-row">
                                            <td>{{$item->payment_voucher_no}}</td>
                                            <td>{{$item->ip_no}}</td>
                                            <td>{{$item->goods_received_no}}</td>
                                            <td>{{$n->comment}}</td>
                                            <td>
                                                <a href="{{route('payment-voucher.edit', $item->id)}}" class="btn btn-sm btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
@endpush