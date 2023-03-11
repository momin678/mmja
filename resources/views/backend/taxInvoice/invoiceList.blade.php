@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>

    </style>
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
                            <div class="col-md-6">
                                <h4>Tax Invoices</h4>

                            </div>
                            <div class="col-md-6 text-right">

                            </div>
                            <hr>
                    </div>

                    <div class="row">
                       @foreach ($invoicess as $item)
                       <a href="{{ route('invoiceView',$item) }}" class="col-md-2 col-6 btn btn-light mx-1 mb-1 text-center">{{ $item->invoice_no }}</a>


                       @endforeach
                    </div>
                    <div class="row d-flex justify-content-end">
                            {{ $invoicess->links() }}
                    </div>


                </section>
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

            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();
            $(document).on("click", "#sale-order-details", function(e) {
                e.preventDefault();
                $(this).addClass('active-button-sale').siblings('div').removeClass('active-button-sale');
                var that = $(this);
                var urls = that.attr("data_target");
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
                            $(".details-view").empty().append(response.page);

                        },
                        error: function() {
                              alert('Problem Found');
                        }
                    });
                }, 999);
            });
        });

    </script>
@endpush
