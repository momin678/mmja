@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        .table-bordered {
            border: 1px solid #f4f4f4;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
        table {
            background-color: transparent;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        .tarek-container {
            width: 85%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 88% 12%;
            background-color: #ffff;
        }
        .invoice-label {
            font-size: 10px !important
        }
    </style>
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row d-flex align-items-center">
                                <div class="col-6">
                                    <h4>Branch</h4>

                                </div>

                                <div class="col-6 text-right">
                                    <a href="{{ route('projectDetails') }}" class="btn btn-info">Back</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-5">
                                                    <strong>Branch No </strong>
                                                </div>
                                                <div class="col-7">
                                                  <strong>:</strong> {{ $proj->proj_no }}
                                                </div>

                                                <div class="col-5">
                                                    <strong>Branch Name</strong>
                                                </div>
                                                <div class="col-7">
                                                   <strong>:</strong> {{ $proj->proj_name }}
                                                </div>

                                                <div class="col-5">
                                                    <strong>Branch Type</strong>
                                                </div>
                                                <div class="col-7">
                                                   <strong>:</strong> {{ $proj->proj_type }}
                                                </div>

                                                <div class="col-5">
                                                   <strong>Manager</strong>
                                                </div>
                                                <div class="col-7">
                                                   <strong>:</strong> {{ $proj->owner_name }}
                                                </div>

                                                <div class="col-5">
                                                   <strong>Site Address</strong>
                                                </div>
                                                <div class="col-7">
                                                   <strong>:</strong> {{ $proj->address }}
                                                </div>

                                                <div class="col-5">
                                                    <strong>Office Phone No</strong>
                                                </div>
                                                <div class="col-7">
                                                   <strong>:</strong> {{ $proj->cons_agent }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-5">
                                                    <strong>Mobile Number</strong>
                                                </div>
                                                <div class="col-7">
                                                  <strong>:</strong> {{ $proj->cont_no }}
                                                </div>

                                                <div class="col-5">
                                                    <strong>Trade License Issue Date</strong>
                                                </div>
                                                <div class="col-7">
                                                   <strong>:</strong> {{ $proj->ord_date }}
                                                </div>

                                                <div class="col-5">
                                                    <strong>License Expiery</strong>
                                                </div>
                                                <div class="col-7">
                                                   <strong>:</strong> {{ $proj->hnd_over_date }}
                                                </div>

                                                <div class="col-5">
                                                   <strong>Profit Center</strong>
                                                </div>
                                                <div class="col-7">
                                                   <strong>:</strong> {{ $proj->profitCenter($proj->pc_code)->pc_name }}
                                                </div>


                                            </div>
                                        </div>

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

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>
        function refreshPage() {
            window.location.reload();
        }

    </script>
@endpush
