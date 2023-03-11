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
                                    </tr>
                                </thead>

                                <tbody class="user-table-body">
                                    @foreach ($rejectedRequisition as $requisition)
                                        <tr>
                                            @php
                                                $purchaseInfo = App\PurchaseRequisition::where('purchase_no', $requisition->purchase_id)->first();
                                                $projectInfo = App\ProjectDetail::where('id', $purchaseInfo->project_id)->first();
                                                $notification = App\Notification::where('purchase_id', $requisition->purchase_no)->where("state", "Editor")->where('status', 99)->first();
                                            @endphp
                                            <td>{{$requisition->purchase_id}}</td>
                                            <td>
                                                {{$projectInfo->proj_name}}
                                            </td>
                                            <td>
                                                {{$requisition->comment}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>


                            </table>

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
