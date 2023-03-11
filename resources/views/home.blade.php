@extends('layouts.backend.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            {{-- <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="breadcrumbs-top">
                        <h5 class="content-header-title float-left pr-1 mb-0">Widgets</h5>
                        <div class="breadcrumb-wrapper d-none d-sm-block">
                            <ol class="breadcrumb p-0 mb-0 pl-1">
                                <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active">Widgets
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-12 mt-1 mb-2">
                            <h4>Dashboard</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                                        <i class="bx bx-edit-alt font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">Sales</p>
                                    <h2 class="mb-0">500+</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                                        <i class="bx bx-file font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">Purchases</p>
                                    <h2 class="mb-0">50+</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                                        <i class="bx bx-message font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">Transactions</p>
                                    <h2 class="mb-0">450+</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1">
                                        <i class="bx bx-money font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">Products+</p>
                                    <h2 class="mb-0">72</h2>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </section>
                <!-- Widgets Statistics End -->



            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        // $(document).ready(function() {
            // Page Script
            // alert("Alhamdulillah");
        // });
    </script>
@endpush