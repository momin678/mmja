@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('title', 'rejected purchase requisition notification')
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <h4>Rejected Purchase Requisition</h4>
                                <hr>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6 text-right">
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>PR No</th>
                                        <th>Branch Name</th>
                                        <th>Comment</th>
                                        <td>Action</td>
                                    </tr>
                                </thead>

                                <tbody class="user-table-body">
                                    @foreach ($rejectedRequisition as $requisition)
                                        <tr>
                                            @php
                                                $notification = App\Notification::where('purchase_id', $requisition->purchase_no)->first();
                                                $projectInfo = App\ProjectDetail::where('id', $requisition->project_id)->first();
                                            @endphp
                                            <td>{{$requisition->purchase_no}}</td>
                                            <td>
                                                {{$projectInfo->proj_name}}
                                            </td>
                                            <td>
                                                {{$notification->comment}}
                                            </td>
                                            <td><a href="{{route('purchase-requisition.edit', $requisition->id)}}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="sm">
                            {{$rejectedRequisition->links()}}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        function refreshPage() {
            window.location.reload();
        }
    </script>
@endpush
