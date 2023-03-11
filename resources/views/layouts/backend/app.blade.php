<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
    $settings= \App\Setting::where('config_name', 'title_name')->first()
    @endphp
    <title>{{ $settings->config_value}} - @yield('title') </title>
    <link rel="apple-touch-icon" href="{{ asset('assets/backend')}}/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/backend')}}/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/vendors/css/forms/select/select2.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/app-assets/css/plugins/forms/validation/form-validation.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/')}}/app-assets/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/')}}/app-assets/css/plugins/extensions/toastr.css">

    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend')}}/assets/css/style.css">
    <!-- END: Custom CSS-->

    <!-- BEGIN: Page CSS-->
    @stack('css')
    <!-- END: Page CSS-->
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
        .tarek-container{
        width: 85%;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 88% 12%;
        background-color: #ffff;
        }
        .invoice-label{
            font-size: 10px !important
        }
        .content-padding{
            padding: 5px 10px 12px;
        }
        .content-title{
            padding: 10px 0 0 10px;
        }
        .bx-filter{
            font-size: 30px;
            line-height: 0px;
        }

        /* Tareq custom css */
        .active-button-sale{
        color: red;
        }
        .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 0.5rem !important;
        }

        .col-right-padding{
        padding-right: 0px !important;
        /* padding-left: 0px !important; */
        }
        .col-left-padding{
        padding-left: 0px !important;
        /* padding-left: 0px !important; */
        }
        /* Tareq custom css */
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>
    @include('layouts.backend.partial.nav')
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    @include('layouts.backend.partial.sidebar')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->

    <!-- demo chat-->
    <div class="widget-chat-demo">
        <!-- widget chat demo footer button start -->
        {{-- <button class="btn btn-primary chat-demo-button glow px-1"><i class="livicon-evo" data-options="name: comments.svg; style: lines; size: 24px; strokeColor: #fff; autoPlay: true; repeat: loop;"></i></button> --}}
        <!-- widget chat demo footer button ends -->
        <!-- widget chat demo start -->
        {{-- <div class="widget-chat widget-chat-demo d-none">
            <div class="card mb-0">
                <div class="card-header border-bottom p-0">
                    <div class="media m-75">
                        <a href="JavaScript:void(0);">
                            <div class="avatar mr-75">
                                <img src="{{ asset('assets/backend')}}/app-assets/images/portrait/small/avatar-s-2.jpg" alt="avtar images" width="32" height="32">
                                <span class="avatar-status-online"></span>
                            </div>
                        </a>
                        <div class="media-body">
                            <h6 class="media-heading mb-0 pt-25"><a href="javaScript:void(0);">Kiara Cruiser</a></h6>
                            <span class="text-muted font-small-3">Active</span>
                        </div>
                    </div>
                    <div class="heading-elements">
                        <i class="bx bx-x widget-chat-close float-right my-auto cursor-pointer"></i>
                    </div>
                </div>
                <div class="card-body widget-chat-container widget-chat-demo-scroll">
                    <div class="chat-content">
                        <div class="badge badge-pill badge-light-secondary my-1">today</div>
                        <div class="chat">
                            <div class="chat-body">
                                <div class="chat-message">
                                    <p>How can we help? 😄</p>
                                    <span class="chat-time">7:45 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="chat chat-left">
                            <div class="chat-body">
                                <div class="chat-message">
                                    <p>Hey John, I am looking for the best admin template.</p>
                                    <p>Could you please help me to find it out? 🤔</p>
                                    <span class="chat-time">7:50 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="chat">
                            <div class="chat-body">
                                <div class="chat-message">
                                    <p>Stack admin is the responsive bootstrap 4 admin template.</p>
                                    <span class="chat-time">8:01 AM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top p-1">
                    <form class="d-flex" onsubmit="widgetChatMessageDemo();" action="javascript:void(0);">
                        <input type="text" class="form-control chat-message-demo mr-75" placeholder="Type here...">
                        <button type="submit" class="btn btn-primary glow px-1"><i class="bx bx-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div> --}}
        <!-- widget chat demo ends -->

    </div>
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    @include('layouts.backend.partial.footer')
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('assets/backend')}}/app-assets/vendors/js/vendors.min.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('assets/backend/')}}/app-assets/vendors/js/extensions/toastr.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('assets/backend')}}/app-assets/js/core/app-menu.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/core/app.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/scripts/components.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/scripts/footer.js"></script>
    <!-- END: Theme JS-->

    <script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/select/form-select2.js"></script>

    <!-- BEGIN: Page JS-->
    @stack('js')
    <script>
        $(document).ready(function() {
                $('.common-select2').select2();
        })
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            console.log(type);
            toastr.options =
                {
                    "closeButton" : true,
                    "tapToDismiss": false,
                };
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}","Info");
                    break;

                case 'warning':
                    toastr.warning("{{ Session::get('message') }}","Warning");
                    break;

                case 'success':
                    toastr.success("{{ Session::get('message') }}", "Success");
                    break;

                case 'error':
                    toastr.error("{{ Session::get('message') }}", "Error");
                    break;
            }
        @endif
        </script>



<script>
    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV file
        csvFile = new Blob([csv], {
            type: "text/csv"
        });

        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename;

        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();
    }

    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("table tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [],
                cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++)
                row.push("\"" + cols[j].innerText + "\"");

            csv.push(row.join(","));
        }

        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
    }
</script>




<script>
    $(document).ready(function() {
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
    });
$(document).ready(function() {

    $(document).on('keypress', '.ajax-search', function(e) {
        if (e.which == 13) {
            e.preventDefault();
        }
    });


    /////////////////////////////////////

    var delay = (function() {
        var timer = 0;
        return function(callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $(document).on("keyup", ".ajax-search", function(e) {
        e.preventDefault();
        // alert('ok');
        var that = $(this);
        var q = e.target.value;
        var url = that.attr("data-url");
        var urls = url + '?q=' + q;
        // var datalist = $("#products");
        // datalist.empty();
        // alert(urls);


        delay(function() {
            $.ajax({
                url: urls,
                type: 'GET',
                cache: false,
                dataType: 'json',
                success: function(response) {
                    //   alert('ok');
                    // console.log(response);
                    // $(".pagination").remove();
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
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
