<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description"
        content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Layouts - Frest - Bootstrap HTML admin template</title>
    <link rel="apple-touch-icon" href="{{ asset('assets/backend') }}/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ asset('assets/backend') }}/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend') }}/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/backend') }}/app-assets/vendors/css/forms/select/select2.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend') }}/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend') }}/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend') }}/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend') }}/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend') }}/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/backend') }}/app-assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/backend') }}/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/backend') }}/app-assets/css/plugins/forms/validation/form-validation.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/backend/') }}/app-assets/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/backend/') }}/app-assets/css/plugins/extensions/toastr.css">

    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend') }}/assets/css/style.css">
    <!-- END: Custom CSS-->

    <!-- BEGIN: Page CSS-->
    @stack('css')
    <!-- END: Page CSS-->

    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .graph-7 {
            background: url({{ asset('img/finallogo.jpeg') }});
        }

        .graph-image img {
            display: none;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 40% 35% 25%;
        }

        .grid-container2 {
            display: grid;
            grid-template-columns: 25% 40% 35%;
        }

        .grid-container3 {
            display: grid;
            grid-template-columns: 28% 55% 18%;
        }

        @media print {
            .graph-image img {
                display: inline;
            }

        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
            text-transform: uppercase;

        }

        .widgets-Statistics2 {
            background-image: url(http://zinith-accounting-inventory-main.test/img/finallogo.jpeg);
            opacity: 0.5;
        }

        @media screen {
            div.divFooter {
                display: none;
            }
        }

        @media print {
            div.divFooter {
                position: fixed;
                bottom: 0;
            }

            tr {
                background-color: red;
            }

            .widgets-Statistics2 {
                background-image: url(http://zinith-accounting-inventory-main.test/img/finallogo.jpeg);
                opacity: 0.5;
            }


        }

        td {
            text-align: center !important;
        }

        .th-border {
            border: 1px solid #000 !important;
            width:22% !important;
            margin-top: 100px !important;
        }

        .th-border2 {
            width:12% !important;
            border-top: 0px solid #fff !important;
        }

        .th-border3 {
            border: 1px solid #000 !important;
            width:78% !important;
            margin-top: 100px !important;
        }



        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #000;
        }

        p {
            color: black !important;
        }

        h3 {
            /* font-family: cursive !important; */
            font-style: italic !important;
            color: black !important;
            font-weight: 600 !important;
        }


        span{
            /* font-family: cursive !important; */
            /* font-style: italic !important; */
            color: black !important;
            font-weight: 600 !important;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
            font-family: cursive !important;
            font-style: italic !important;
            color: black !important;
            font-weight: 600 !important;
        }

        small,
        .small {
            font-size: 80%;
            padding: 0.3rem;
            font-family: cursive !important;
            font-style: italic !important;
            color: black !important;
            font-weight: 600 !important;
        }

        b,
        strong {
            font-weight: bolder;
            font-size: 120%;
            padding: 0.3rem;
            font-family: cursive !important;
            font-style: italic !important;
            color: black !important;
        }

        .col-1,
        .col-2,
        .col-3,
        .col-4,
        .col-5,
        .col-6,
        .col-7,
        .col-8,
        .col-9,
        .col-10,
        .col-11,
        .col-12,
        .col,
        .col-auto,
        .col-sm-1,
        .col-sm-2,
        .col-sm-3,
        .col-sm-4,
        .col-sm-5,
        .col-sm-6,
        .col-sm-7,
        .col-sm-8,
        .col-sm-9,
        .col-sm-10,
        .col-sm-11,
        .col-sm-12,
        .col-sm,
        .col-sm-auto,
        .col-md-1,
        .col-md-2,
        .col-md-3,
        .col-md-4,
        .col-md-5,
        .col-md-6,
        .col-md-7,
        .col-md-8,
        .col-md-9,
        .col-md-10,
        .col-md-11,
        .col-md-12,
        .col-md,
        .col-md-auto,
        .col-lg-1,
        .col-lg-2,
        .col-lg-3,
        .col-lg-4,
        .col-lg-5,
        .col-lg-6,
        .col-lg-7,
        .col-lg-8,
        .col-lg-9,
        .col-lg-10,
        .col-lg-11,
        .col-lg-12,
        .col-lg,
        .col-lg-auto,
        .col-xl-1,
        .col-xl-2,
        .col-xl-3,
        .col-xl-4,
        .col-xl-5,
        .col-xl-6,
        .col-xl-7,
        .col-xl-8,
        .col-xl-9,
        .col-xl-10,
        .col-xl-11,
        .col-xl-12,
        .col-xl,
        .col-xl-auto {
            position: relative;
            width: 100%;
            padding-right: 0px !important;
            padding-left: 0px !important;
        }
        label {
            font-family: cursive !important;
            font-style: italic !important;
            color: black !important;
            font-weight: 600 !important;
        }

        tr.spaceUnder {
            padding-bottom: 1em;
        }


    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
@php
$company_name = \App\Setting::where('config_name', 'company_name')->first();
$company_address = \App\Setting::where('config_name', 'company_address')->first();
$company_tele = \App\Setting::where('config_name', 'company_tele')->first();
$company_email = \App\Setting::where('config_name', 'company_email')->first();
$trn_no = \App\Setting::where('config_name', 'trn_no')->first();
$logo = \App\Setting::where('config_name', 'company_logo')->first();
@endphp

<body onload="window.print();">

    <div class="content-wrapper">
        <div class="content-body">
            <section id="widgets-Statistics">
                <div class="container">

                    <div class="row">
                        <div class="col-md-1">
                            <img src="{{ asset('assets/backend/app-assets/settings/' . $logo->config_value) }}"
                                style="height: 100px" alt="Company Logo">

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
    <div class="container pt-2">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>
                    <span> {{ $voucher->type=='DR' ? 'DEBIT' : ($voucher->type=='CR' ? 'CREDIT' : 'JOURNAL') }} VOUCHER </span>
                    
                </h2>
            </div>
        </div>

        <div class="row pt-3">
            <div class="col-12">
                <table class="table table-sm">
                    <tr>
                        <th class="th-border">Serial No</th>
                        <th class="th-border">{{ $voucher->journal->journal_no}}</th>
                        <th class="th-border2"></th>
                        <th class="th-border">Date</th>
                        <th class="th-border">{{$voucher->date}}</th>
                    </tr>
                    <tr>
                        <th class="th-border align-middle">Amount</th>
                        <th class="th-border align-middle">{{$voucher->amount}}</th>
                        <th class="th-border2"></th>
                        <th class="th-border align-middle">Pay Mode</th>
                        <th class="th-border align-middle">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                 {{$voucher->pay_mode}}
                                </label>
                              </div>
                        </th>
                    </tr>

                </table>

                <table class="table table-sm mt-1">

                    <tr>
                        <th class="th-border align-middle" >RECEIVED FROM </th>
                        <th class="th-border3 align-middle" >{{ $voucher->party->pi_name}}</th>
                        
                    </tr>
                    <tr>
                        <th class="th-border align-middle" >AMOUNT IN WORD </th>
                        <th class="th-border3 align-middle" >{{ $voucher->amount_word($voucher->amount)}}</th>
                        
                    </tr>
                    <tr>
                        <th class="th-border align-middle" >ACCOUNT HEAD</th>
                        <th class="th-border3 align-middle" >
                            {{ isset($voucher->ac_head) ? $voucher->ac_head->fld_ac_head : ''}}
                        </th>
                    </tr>

                    <tr style="height: 80px">
                        <th class="th-border align-middle" >DESCRIPTION</th>
                        <th class="th-border3 align-middle" >{{ $voucher->narration}}</th>
                    </tr>

                </table>
            </div>
        </div>

        <div class="row pt-5 mt-5">
            <div class="col-md-6">
                <span>RECEIVED BY</span>
            </div>
            <div class="col-md-6 text-right">
                <span>APPROVED BY</span>
            </div>
        </div>
<hr>
        <div class="row pt-4">
            <div class="col-12 text-center">
                <h3>Voucher scan copy</h3>
                <img src="{{ asset('assets/backend/app-assets/beps-logo.png') }}" class="img-fluid" style="height: 700px" alt="">
            </div>

        </div>
    </div>
    <div class="divFooter">
        Business Software Solutions by
        <span style="color: #0005"><img src="{{ asset('img/zisprink.png') }}" style="max-height: 90px"
                class="img-fluid" alt=""></span>
    </div>


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('assets/backend') }}/app-assets/vendors/js/vendors.min.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('assets/backend/') }}/app-assets/vendors/js/extensions/toastr.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('assets/backend') }}/app-assets/js/core/app-menu.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/js/core/app.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/js/scripts/components.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/js/scripts/footer.js"></script>
    <!-- END: Theme JS-->


    <!-- BEGIN: Page JS-->
    @stack('js')
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            console.log(type);
            toastr.options = {
                "closeButton": true,
                "tapToDismiss": false,
            };
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('message') }}", "Info");
                    break;

                case 'warning':
                    toastr.warning("{{ Session::get('message') }}", "Warning");
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
