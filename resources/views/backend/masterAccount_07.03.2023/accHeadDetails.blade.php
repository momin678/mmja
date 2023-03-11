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
                            <h4>Account Head Form</h4>
                            <hr>
                            {{-- @include('alerts.alerts') --}}
                    </div>
                    <div class="row user-table-body">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Account Head Details</h4>
                                </div>
                                <div class="card-body ">
                                    @isset($masterAcc)
                                        <form action="{{ route('masterDetailsPost', $masterAcc) }}" method="POST">
                                        @else
                                            <form action="{{ route('masterDetailsPost') }}" method="POST">
                                            @endisset
                                            @csrf
                                            <div class="row match-height ">



                                                <div class="col-md-6">
                                                    <h5>Account Details</h5>


                                                    <div class="form-body">
                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <label>A/C Code</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <div class="row">
                                                                    <input type="text" id="ma_code" class="form-control"
                                                                        name="ma_code"
                                                                        value="{{ isset($masterAcc) ? $masterAcc->MstACCode : '' }}"
                                                                        placeholder="A/C Code" readonly>


                                                                </div>

                                                                @error('ma_code')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label>A/C Head</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <div class="row">
                                                                    <input type="text" id="fld_ac_head" class="form-control"
                                                                        name="fld_ac_head"
                                                                        value="{{ isset($masterAcc) ? $masterAcc->MstACCode : '' }}"
                                                                        placeholder="A/C Head" readonly>
                                                                </div>
                                                                @error('fld_ac_head')
                                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>Mapped To Master Account</h5>
                                                    <div class="form-body">

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label>Master A/C Head</label>
                                                                </div>
                                                                <div class="col-md-8 form-group ">
                                                                    <input type="text" name="fld_ac_head"
                                                                        class="form-control"
                                                                        placeholder="Master A/C Head"
                                                                        value="{{ isset($masterAcc) ? $masterAcc->MstACHead : '' }}"
                                                                        id="" readonly>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>Definition</label>
                                                                </div>
                                                                <div class="col-md-8 form-group ">
                                                                    <input type="text" name="fld_ac_head"
                                                                        class="form-control"
                                                                        placeholder="Definition"
                                                                        value="{{ isset($masterAcc) ? $masterAcc->MstDefinition : '' }}"
                                                                        id="" readonly>
                                                                </div>



                                                                <div class="col-12 d-flex justify-content-end ">
                                                                    <button type="submit" class="btn btn-primary mr-1"
                                                                        disabled>Submit</button>
                                                                    <button type="reset"
                                                                        class="btn btn-light-secondary" disabled>Reset</button>
                                                                </div>
                                                            </div>
                                                    </div>

                                                </div>
                                        </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        <section>
                    <div class="row">
                        <ul>
                            @foreach ($masterDetails as $masterAcc)
                                <li class="btn findMasterAcc" data-target="{{ route('findMasterAcc', $masterAcc) }}">
                                    {{ $masterAcc->mst_ac_code }} - {{ $masterAcc->mst_ac_head }}</li>
                                    <ul>
                                       @foreach (App\Models\AccountHead::where('ma_code',$masterAcc->mst_ac_code)->get() as $item)

                                         <li><a href="#" class="bx bx-edit editAccHead" data-target="{{ route('editAccHead', $item) }}">{{ $item->fld_ac_code }} {{ $item->fld_ac_head }}</a> <a href="{{ route('deleteAcHead',$item) }}" class="bx bx-trash text-danger" onclick="return confirm('Delete Account Head. Confirm?')"></a></li>
                                       @endforeach
                                    </ul>
                                <br>
                            @endforeach
                        </ul>
                    </div>
                </section>
                <!-- Widgets Statistics End -->
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

    <script>

        $(document).ready(function() {




            /////////////////////////////////////

            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();

            $(document).on("click", ".findMasterAcc", function(e) {
                e.preventDefault();
                var that = $(this);

                var urls = that.attr("data-target");

                // alert(urls);


                delay(function() {
                    $.ajax({
                        url: urls,
                        type: 'GET',
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            //   alert('ok');
                            console.log(response);
                            $(".pagination").remove();
                            $(".user-table-body").empty().append(response.page);
                        },
                        error: function() {
                            //   alert('no');
                        }
                    });
                }, 999);
            });



            $(document).on("click", ".editAccHead", function(e) {
                e.preventDefault();
                var that = $(this);

                var urls = that.attr("data-target");

                // alert(urls);


                delay(function() {
                    $.ajax({
                        url: urls,
                        type: 'GET',
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            //   alert('ok');
                            console.log(response);
                            $(".pagination").remove();
                            $(".user-table-body").empty().append(response.page);
                        },
                        error: function() {
                            //   alert('no');
                        }
                    });
                }, 999);
            });


        });
    </script>
@endpush
