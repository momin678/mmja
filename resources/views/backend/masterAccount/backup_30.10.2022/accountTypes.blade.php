@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

@endpush
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-6 mt-1 mb-2">
                            <h4>Master Account Category</h4>
                        </div>
                        <div class="col-md-6 mt-1 mb-2 text-right">
                            <a href="{{ route('masteAccDetails') }}" class="btn btn-info">Back</a>
                        </div>
                    </div>
                </section>
                <!-- Widgets Statistics End -->
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Master Account Category</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('masterCatPost') }}" method="POST">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="">Category Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" class="form-control" name="title" id="" placeholder="Category Name" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="">Value</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="number" name="value" class="form-control" id="" placeholder="Value" required>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-end form-group">
                                                        <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                                        <button type="reset" class="btn btn-light-secondary">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Master Account Type</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('masterAccType') }}" method="POST">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="">Type Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" class="form-control" name="title" id="" placeholder="Type Name" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="">Category</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select name="cat_type" class="form-control" id="" required>
                                                            <option value="">Select...</option>
                                                            @foreach ($cats as $item)
                                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-end form-group">
                                                        <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                                        <button type="reset" class="btn btn-light-secondary">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <ul>
                        @foreach ($cats as $item)
                        {{-- {{ dd($item->hasTypes()) }} --}}
                            <li class="btn btn-success">
                               {{ $item->value }} - {{ $item->title }}</li>
                                <ul>
                                    @foreach ($item->hasTypes as $cat)
                                    <li>{{ $cat->title }}</li>

                                    @endforeach
                                </ul>
                            <br>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        // $(document).ready(function() {
            // Page Script
            // alert("Alhamdulillah");
        // });
    </script>

@endpush
