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
                                <h4>Receipt Voucher Revise</h4>
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
                                        <th>RV No</th>
                                        <th>Invoice NO</th>
                                        <th>Customer Name</th>
                                        <th>Comment</th>
                                        <th>View</th>
                                    </tr>
                                </thead>

                                <tbody class="user-table-body">
                                    @foreach ($rv_approval_list as $rv_list)
                                    @php
                                        $n = App\Notification::where("purchase_id", $rv_list->rv_no)->where("state", "Editor")->where("status", 99)->first();
                                    @endphp
                                        <tr>
                                            <td>{{$rv_list->rv_no}}</td>
                                            <td>{{$rv_list->tax_invoice->invoice_no}}</td>
                                            <td>{{$rv_list->partyInfo->pi_name}}</td>
                                            <td>{{$n->comment}}</td>
                                            <td>
                                                <a href="{{ route('rv-revise-update', $rv_list) }}"
                                                    class="btn btn-sm btn-warning"><i class="bx bx-edit"></i>
                                                </a>
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
