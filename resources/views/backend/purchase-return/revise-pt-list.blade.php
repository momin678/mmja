@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'purchase return revise list')
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
                                <h4 class="card-title">Purchase Return Revise</h4>
                            </div>
                            <table  class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>PT No</th>
                                        <th>GR No</th>
                                        <th>Branch Name</th>
                                        <th>Comment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody  id="tempLists"  class="user-table-body">
                                    @foreach ($revise_pt as $item)
                                    @php
                                        $notification = App\Notification::where('state', "PT Editor")->where('status', 99)->first();
                                    @endphp
                                        <tr  class="data-row">
                                            <td>{{$item->purchase_return_no}}</td>
                                            <td>{{$item->gr_no}}</td>
                                            <td>{{$item->projectInfo->proj_name}}</td>
                                            <td>{{$notification->comment}}</td>
                                            <td>
                                                <a href="{{route('purchase-return.edit', $item->id)}}" class="btn btn-sm btn-warning">Edit</a>
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