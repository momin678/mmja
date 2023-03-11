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

       td,
        th {
            border: 1px solid #ddd;
            padding-right: 4px;
            font-size: 8px;
        }


        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

         th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
            text-transform: uppercase;

        }
        .container{
            width: 1200px !important;
        }

        .container, .container-fluid, .container-sm, .container-md, .container-lg, .container-xl {
    width: 100%;
    padding-right: 0px !important;
    padding-left: 0px !important;
    margin-right: auto;
    margin-left: auto;
}

        .graph-7 {
            background: url(../img/graphs/graph-7.jpg) no-repeat;
        }

        .graph-image img {
            display: none;
        }



        @media print {
            div.divFooter {
                display: none;
            }
            div.divFooter {
                position: fixed;
                bottom: 0;
            }

            .print-hide{
                display: none !important;
            }
            .td-border-print{
                /* border-bottom: 0px !important; */
                border-bottom: 0px !important;
                border-top: 0px !important;
            }

            body {
                    page-break-before: avoid;
                    width:100%;
                    height:100%;
                    -webkit-transform: rotate(-90deg) scale(.88,.88);
                    -moz-transform:rotate(-90deg) scale(.58,.58);
                    -webkit-print-color-adjust: exact !important;
                    zoom: 200%
                }

                td{
                white-space: nowrap !important;
            }


        }

        th {
            text-transform: uppercase;

        }
        .transparent-bg{
    background: rgba(255, 165, 0, 0.73);
    padding: 20px;
    color: #fff;
    text-align: center;
    font-size: 26px;
}
    .rotation{
        transform: rotate(90deg);
  }

  div#myDiv {
  transform: rotate(270deg);
}

.card-grid-main{
    width: 100%;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 25% 75%;
}
html p {
    line-height: .8rem;
    padding-bottom: 0px;
    color: black;
}
hr.blackgrn {
  border: 1px solid black;
  width: 85%;
}

hr.narrow {
  border: .5px solid black;
  width: 85%;
}

.height {
    line-height: 1rem;
    /* padding-bottom: 4px; */
}
.id-card{
    width:204px;
    height:324px;
    background-color:#fff;
    clip-path: polygon(30% 0, 100% 0, 100% 78%, 43% 95%, 0 83%, 0 12%, 13% 6%);

}

.card-grid-main{
    width: 100%;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 20% 80%;
}

.card-grid-main2{
    width: 100%;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 40% 30% 30%;
}

.id-card-land{
    width:130px;
    height:75px;
    background-color:rgb(122, 82, 82);
    clip-path: polygon(0 0, 68% 0, 100% 100%, 0 100%);

}

.card-top{
    height: 75px !important;
    background-image: url("img/carrrrrrrrrrd3.jpg");
}

.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 0px !important;
    padding-left: 0px !important;
}
    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body >
    <div class="content-wrapper pb-4">
        <div class="content-body">
            <section id="widgets-Statistics">
                <div class="container pt-2">
                    <button class="btn btn-xs btn-info float-right mr-1"
                    onclick="exportTableToCSV('tax.csv')">Export To CSV</button>
                    <div class="row d-flex justify-content-center">
@php
    $taxable=0;
    $vat=0;
    $total=0;
@endphp
                        <table class="table-bordered">
                            <tr>
                                <th>Customer</th>
                                <th>TRN NUMBER</th>
                                <th>DATE</th>
                                <th>INVOICE NUMBER</th>
                                <th>DESCRIPTION</th>
                                <th>TAXABLE AMOUNT</th>
                                <th>VAT AMOUNT</th>
                                <th>TOTAL AMOUNT</th>
                            </tr>
                                @foreach($invoicess as $invoice)
                                <tr>
                                    <th>{{ $invoice->partyInfo($invoice->customer_name)==null?"":$invoice->partyInfo($invoice->customer_name)->pi_name }}</th>
                                    <th>{{ $invoice->partyInfo($invoice->customer_name)==null?"":$invoice->partyInfo($invoice->customer_name)->trn_no }}</th>
                                    <th>{{ $invoice->date }}</th>
                                    <th>{{ $invoice->invoice_no }}</th>
                                    <th></th>
                                    <th>{{number_format((float)(  $invoice->taxableAmount()), 2,'.','')   }}</th>
                                    <th>{{number_format((float)(  $invoice->vatAmount()), 2,'.','')   }}</th>
                                    <th>{{number_format((float)(  $invoice->TotalAmount()), 2,'.','')   }}</th>
                                </tr>
                                @php
                                    $taxable=$taxable+$invoice->taxableAmount();
                                    $vat=$vat+$invoice->vatAmount();
                                    $total=$total+$invoice->TotalAmount();
                                @endphp
                                @endforeach
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th>{{ $taxable }}</th>
                                    <th>{{ $vat }}</th>
                                    <th>{{ $total }}</th>

                                </tr>
                        </table>
                    </div>
                </div>
            </section>
        </div>
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

</body>
<!-- END: Body-->

</html>
