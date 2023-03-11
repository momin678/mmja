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
    <title>Form Layouts - Frest - Bootstrap HTML admin template</title>
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
        @media print
        {
          table { page-break-after:auto }
          tr    { page-break-inside:avoid; page-break-after:auto }
          td    { page-break-inside:avoid; page-break-after:auto }
          thead { display:table-header-group }
          tfoot { display:table-footer-group }
        }
        tr td{
            text-align: center;
        }
        tbody tr{
            border: 1px solid gray;
            text-align: center !important;
        }
        th{
            text-transform: uppercase;
        }
        tfoot tr{
            border: none;
        }
        @media print {
    @page { margin: 0; }
    .page-break { page-break-after: always; }
    tr{page-break-inside: auto;}
    }


        </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
$trn_no= \App\Setting::where('config_name', 'trn_no')->first();

@endphp
<body onload="window.print();">
    <div class="content-wrapper">
            <div class="content-body mt-4">
                <section id="widgets-Statistics">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-1">
                                <img src="{{ asset('img/finallogo.jpeg') }}" class="img-fluid" style="max-height: 80px" alt="">

                            </div>
                            <div class="col-md-10 text-center">
                                <h2>{{ $company_name->config_value }}</h2>
                                <h6>{{ $company_address->config_value }}</h6>
                                <div class="row">
                                    <div class="col-6 text-right">
                                        <h6>Mobile {{ $company_tele->config_value }}</h6>
                                    </div>
                                    <div class="col-6 text-left">
                                        <h6>TRN {{ $trn_no->config_value }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">

                            </div>
                        </div>
                    </div>
                </section>
            </div>
    </div>
    @yield('content')

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


    <!-- BEGIN: Page JS-->
    @stack('js')
    <script>
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
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
