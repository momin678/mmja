@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('title', 'approve pr list')
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <h4>Purchase Requisition Approval</h4>
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
                                        <th>View</th>
                                    </tr>
                                </thead>

                                <tbody class="user-table-body">
                                    @foreach ($approveRequisition as $requisition)
                                        <tr>
                                            <td>{{$requisition->purchase_no}}</td>
                                            <td>{{$requisition->projectInfo->proj_name}}</td>
                                            <td style="white-space: nowrap">
                                                <a href="{{ route('approve-requisition-details', $requisition) }}"
                                                    class="btn btn-sm btn-warning"><i class="bx bx-hide"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="sm">
                            {{$approveRequisition->links()}}
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
