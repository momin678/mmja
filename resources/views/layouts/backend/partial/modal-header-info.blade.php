@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
$company_logo= \App\Setting::where('config_name', 'company_logo')->first();
$trn_no= \App\Setting::where('config_name', 'trn_no')->first();

@endphp
<style>
    .print-info{
        top: 0;
    }
    @media print{
        .print-info{
            top: 0;
        }
    }
</style>
<section id="widgets-Statistics border-bottom print-info">
    <div class="container pt-2 mb-3 top-0">
        <div class="row">
            <div class="col-md-2 pl-2 text-right">
                {{-- <img src="{{ asset('img/finallogo.jpeg') }}"  style="height: 100px" alt=""> --}}
                <img src="{{ asset('storage/upload/settings/'.$company_logo->config_value)}}"  style="height: 100px" alt="">

            </div>
            <div class="col-md-9 text-center">
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