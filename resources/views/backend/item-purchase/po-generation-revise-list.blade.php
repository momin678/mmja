@extends('layouts.backend.app')

@section('content')
@section('title', 'po generation revise list')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="table-responsive card">
                            <div class="card-header">
                                <h4 class="card-title">PO Generation Revise</h4>
                            </div>
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>PURCHASE Order NO</th>
                                        <th>Branch NAME</th>
                                        <th>SUPPLIER NAME</th>
                                        <th>Comment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchases as $item)
                                        <tr >
                                            <td>{{$item->purchase_no}}</td>
                                            <td>{{$item->projectInfo->proj_name}}</td>
                                            <td>{{$item->partInfo->pi_name}}</td>
                                            <td>
                                                @php
                                                    $comment = App\Notification::where('purchase_id', $item->purchase_no)->where('state', "Editor")->where("status", 99)->first();
                                                @endphp
                                                {{$comment->comment}}
                                            </td>
                                            <td>
                                                <a href="{{route('purchase-temp.edit', $item->id)}}" class="btn btn-sm btn-warning">Edite</a>
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