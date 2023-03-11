@extends('layouts.backend.app')

@push('css')
    
@endpush

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="breadcrumbs-top">
                    <h5 class="content-header-title float-left pr-1 mb-0">Parent Profile</h5>
                    <div class="breadcrumb-wrapper d-none d-sm-block">
                        <ol class="breadcrumb p-0 mb-0 pl-1">
                            <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Profile</a>
                            </li>
                            <li class="breadcrumb-item active"><a href="#">Parent Profile</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
            </div>
          </div>
        <div class="content-body">
            <form class="form form-vertical" action="{{route('parent.store')}}" method="POST" enctype="multipart/form-data">
                @csrf 

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Father's Information: Personal Details</h4>
                                </div>

                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-12">
                                                    <h6 style="">Father's Name</h6>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <input type="text" id="first-name-vertical" class="form-control" name="f_fname" placeholder="First Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <input type="text" id="email-id-vertical" class="form-control" name="f_mname" placeholder="Middle Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Family Name</label>
                                                        <input type="text" id="contact-info-vertical" class="form-control" name="f_family_name" placeholder="Family Name">
                                                    </div>
                                                </div>


                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Date of Birth</label>
                                                    <input type="date" name="f_dob" class="form-control" placeholder="dd-mm-yyy">
                                                    </div>
                                                </div>
                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Nationality</label>
                                                    <select name="f_nationality" class="form-control" id="">
                                                        <option value="Bangladeshi"> Bangladeshi</option>
                                                        <option value="Indian"> Indian</option>
                                                        <option value="Pakistani"> Pakistani</option>
                                                    </select>
                                                    </div>
                                                </div>
                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Emirates ID Number</label>
                                                    <input type="text" name="f_emirates_id_num" class="form-control" placeholder="000-0000-0000000-0">
                                                    </div>
                                                </div>
                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Emirates Expiry Date</label>
                                                    <input type="date" name="f_emirates_id_exp" class="form-control" placeholder="dd/mm/yyyy">
                                                    </div>
                                                </div>
                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Emirates ID Upload</label>
                                                    <input type="file" name="f_emirates_id_upload" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>First Language</label>
                                                        <select name="f_first_lang" class="form-control" id="">
                                                            <option value="Bangla"> Bangla</option>
                                                            <option value="English"> English</option>
                                                            <option value="Urdu"> Urdu</option>
                                                            <option value="Arabic"> Arabic</option>
                                                            <option value="Hindi"> Hindi</option>
                                                        </select>
                                                    </div>
                                                </div>
                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Second Language</label>
                                                        <select name="f_second_lang" class="form-control" id="">
                                                            <option value="Bangla"> Bangla</option>
                                                            <option value="English"> English</option>
                                                            <option value="Urdu"> Urdu</option>
                                                            <option value="Arabic"> Arabic</option>
                                                            <option value="Hindi"> Hindi</option>
                                                        </select>
                                                    </div>
                                                </div> 
                                                
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="d-block">Prefered Mode Of Communication</label>
                                                        <div class="custom-control custom-radio my-50">
                                                            <input type="radio" id="validationRadiojq1" name="f_mode_of_communication" class="custom-control-input" value="phone">
                                                            <label class="custom-control-label" for="validationRadiojq1">Phone</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="validationRadiojq2" name="f_mode_of_communication" class="custom-control-input" value="email">
                                                            <label class="custom-control-label" for="validationRadiojq2">Email</label>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>



                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->


                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Passport & Visa Information</h4>
                                </div>
                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">
                                            <div class="row">
                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="passport-number">Passport Number</label>
                                                        <input type="text" id="passport-number" class="form-control" name="f_passport_num" placeholder="Passport Number">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="passport-country">Passport Country</label>
                                                        <select id="passport-country" class="form-control" name="f_passport_country">
                                                            <option value="Bangladeshi"> Bangladeshi</option>
                                                            <option value="Indian"> Indian</option>
                                                            <option value="Pakistani"> Pakistani</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="visa-number">Visa Number</label>
                                                        <input type="number" id="visa-number" class="form-control" name="f_visa_number" placeholder="Visa Number">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                    <label for="visa-type">Visa Type</label>
                                                    <select id="visa-type" class="form-control" name="f_visa_type">
                                                        <option value="Residence"> Residence</option>
                                                        <option value="NonResidence"> Non Residence</option>
                                                    </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="visa-issue-place">Visa Issue Place</label>
                                                        <select id="visa-issue-place" class="form-control" name="f_visa_issue_place">
                                                            <option value="Bangladesh"> Bangladesh</option>
                                                            <option value="India"> India</option>
                                                            <option value="Pakistan"> Pakistan</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="visa-expire-date">Visa Expire Date</label>
                                                        <input type="date" id="visa-expire-date" class="form-control" name="f_visa_exp" placeholder="dd/mm/yyyy">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Education & Profession</h4>
                                </div>
                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">
                                            <div class="row">
                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Qualification">Qualification</label>
                                                        <select id="Qualification" class="form-control" name="f_qualification">
                                                            <option value="SSC"> SSC</option>
                                                            <option value="HSC"> HSC</option>
                                                            <option value="BSC"> BSC</option>
                                                            <option value="MSC"> MSC</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="year-of-passing">Year of passing</label>
                                                        <select id="year-of-passing" class="form-control" name="f_year_of_passing">
                                                            <option value="2001"> 2001</option>
                                                            <option value="2002"> 2002</option>
                                                            <option value="2003"> 2003</option>
                                                            <option value="2004"> 2004</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="institution">Institution Name</label>
                                                        <input type="text" id="institution" class="form-control" name="f_institution" placeholder="Institution Name">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="qualification-country">Qualification Country</label>
                                                        <select id="qualification-country" class="form-control" name="f_qualification_country">
                                                            <option value="Bangladesh"> Bangladesh</option>
                                                            <option value="India"> India</option>
                                                            <option value="Pakistan"> Pakistan</option>
                                                            <option value="Saudi Arabia"> Saudi Arabia</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="occupation">Occupation</label>
                                                        <select id="occupation" class="form-control" name="f_occupation">
                                                            <option value="Doctor"> Doctor</option>
                                                            <option value="Engineer"> Engineer</option>
                                                            <option value="Laywer"> Laywer</option>
                                                        </select>
                                                    </div>
                                                </div>                                            

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="company-name">Company Name</label>
                                                        <input type="text" id="company-name" class="form-control" name="f_company_name" placeholder="Company Name">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Company Contact Details">Company Contact Details</label>
                                                        <input type="number" id="Company Contact Details" class="form-control" name="f_company_contact_details" placeholder="Company Contact Details">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="monthly-income">Monthly Income</label>
                                                        <input type="number" id="monthly-income" class="form-control" name="f_monthly_income" placeholder="Monthly Income">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Address Details</h4>
                                </div>
                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">
                                            <div class="row">
                                                
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label for="local-address">Local Address</label>
                                                        <textarea name="f_local_address" id="local-address" class="form-control" cols="30" rows="3"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Emirates">Emirates</label>
                                                        <select id="Emirates" class="form-control" name="f_emirate_name">
                                                            <option>Ras Al Khaimah</option> 
                                                            <option>Umm Al Quwain</option>
                                                            <option>Abu Dhabi</option>
                                                            <option>Dubai</option>
                                                            <option>Sharjah</option>
                                                            <option>Ajman</option>
                                                            <option>Sharjah</option>
                                                            <option>Fujairah</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="local-telephone">Local telephone</label>
                                                        <input type="text" id="local-telephone" class="form-control" name="f_telephone" placeholder="Local Telephone">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="permanent-address">Permanent Address</label>
                                                        <input type="text" id="permanent-address" class="form-control" name="f_permanent_address" placeholder="Permanent Address">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="permanent-telephone">Permanent telephone</label>
                                                        <input type="number" id="permanent-telephone" class="form-control" name="f_permanent_telephone" placeholder="Company Contact Details">
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->

                            <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Mother's Information: Personal Details</h4>
                                </div>

                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-12">
                                                    <h6 style="">Mother's Name</h6>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <input type="text" id="first-name-vertical" class="form-control" name="m_fname" placeholder="First Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <input type="text" id="email-id-vertical" class="form-control" name="m_mname" placeholder="Middle Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Family Name</label>
                                                        <input type="text" id="contact-info-vertical" class="form-control" name="m_family_name" placeholder="Family Name">
                                                    </div>
                                                </div>


                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Date of Birth</label>
                                                    <input type="date" name="m_dob" class="form-control" placeholder="dd-mm-yyy">
                                                    </div>
                                                </div>
                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Nationality</label>
                                                    <select name="m_nationality" class="form-control" id="">
                                                        <option value="Bangladeshi"> Bangladeshi</option>
                                                        <option value="Indian"> Indian</option>
                                                        <option value="Pakistani"> Pakistani</option>
                                                    </select>
                                                    </div>
                                                </div>
                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Emirates ID Number</label>
                                                    <input type="text" name="m_emirates_id_num" class="form-control" placeholder="000-0000-0000000-0">
                                                    </div>
                                                </div>
                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Emirates Expiry Date</label>
                                                    <input type="date" name="m_emirates_id_exp" class="form-control" placeholder="dd/mm/yyyy">
                                                    </div>
                                                </div>
                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Emirates ID Upload</label>
                                                    <input type="file" name="m_emirates_id_upload" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>First Language</label>
                                                        <select name="m_first_lang" class="form-control" id="">
                                                            <option value="Bangla"> Bangla</option>
                                                            <option value="English"> English</option>
                                                            <option value="Urdu"> Urdu</option>
                                                            <option value="Arabic"> Arabic</option>
                                                            <option value="Hindi"> Hindi</option>
                                                        </select>
                                                    </div>
                                                </div>
                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Second Language</label>
                                                        <select name="m_second_lang" class="form-control" id="">
                                                            <option value="Bangla"> Bangla</option>
                                                            <option value="English"> English</option>
                                                            <option value="Urdu"> Urdu</option>
                                                            <option value="Arabic"> Arabic</option>
                                                            <option value="Hindi"> Hindi</option>
                                                        </select>
                                                    </div>
                                                </div> 
                                                
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="d-block">Prefered Mode Of Communication</label>
                                                        <div class="custom-control custom-radio my-50">
                                                            <input type="radio" id="validationRadiojq1" name="m_mode_of_communication" class="custom-control-input" value="phone">
                                                            <label class="custom-control-label" for="validationRadiojq1">Phone</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="validationRadiojq2" name="m_mode_of_communication" class="custom-control-input" value="email">
                                                            <label class="custom-control-label" for="validationRadiojq2">Email</label>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>



                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->


                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Passport & Visa Information</h4>
                                </div>
                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">
                                            <div class="row">
                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="passport-number">Passport Number</label>
                                                        <input type="text" id="passport-number" class="form-control" name="m_passport_num" placeholder="Passport Number">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="passport-country">Passport Country</label>
                                                        <select id="passport-country" class="form-control" name="m_passport_country">
                                                            <option value="Bangladeshi"> Bangladeshi</option>
                                                            <option value="Indian"> Indian</option>
                                                            <option value="Pakistani"> Pakistani</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="visa-number">Visa Number</label>
                                                        <input type="number" id="visa-number" class="form-control" name="m_visa_number" placeholder="Visa Number">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                    <label for="visa-type">Visa Type</label>
                                                    <select id="visa-type" class="form-control" name="m_visa_type">
                                                        <option value="Residence"> Residence</option>
                                                        <option value="NonResidence"> Non Residence</option>
                                                    </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="visa-issue-place">Visa Issue Place</label>
                                                        <select id="visa-issue-place" class="form-control" name="m_visa_issue_place">
                                                            <option value="Bangladesh"> Bangladesh</option>
                                                            <option value="India"> India</option>
                                                            <option value="Pakistan"> Pakistan</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="visa-expire-date">Visa Expire Date</label>
                                                        <input type="date" id="visa-expire-date" class="form-control" name="m_visa_exp" placeholder="dd/mm/yyyy">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Education & Profession</h4>
                                </div>
                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">
                                            <div class="row">
                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Qualification">Qualification</label>
                                                        <select id="Qualification" class="form-control" name="m_qualification">
                                                            <option value="SSC"> SSC</option>
                                                            <option value="HSC"> HSC</option>
                                                            <option value="BSC"> BSC</option>
                                                            <option value="MSC"> MSC</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="year-of-passing">Year of passing</label>
                                                        <select id="year-of-passing" class="form-control" name="m_year_of_passing">
                                                            <option value="2001"> 2001</option>
                                                            <option value="2002"> 2002</option>
                                                            <option value="2003"> 2003</option>
                                                            <option value="2004"> 2004</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="institution">Institution Name</label>
                                                        <input type="text" id="institution" class="form-control" name="m_institution" placeholder="Institution Name">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="qualification-country">Qualification Country</label>
                                                        <select id="qualification-country" class="form-control" name="m_qualification_country">
                                                            <option value="Bangladesh"> Bangladesh</option>
                                                            <option value="India"> India</option>
                                                            <option value="Pakistan"> Pakistan</option>
                                                            <option value="Saudi Arabia"> Saudi Arabia</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="occupation">Occupation</label>
                                                        <select id="occupation" class="form-control" name="m_occupation">
                                                            <option value="Doctor"> Doctor</option>
                                                            <option value="Engineer"> Engineer</option>
                                                            <option value="Laywer"> Laywer</option>
                                                        </select>
                                                    </div>
                                                </div>                                            

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="company-name">Company Name</label>
                                                        <input type="text" id="company-name" class="form-control" name="m_company_name" placeholder="Company Name">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Company Contact Details">Company Contact Details</label>
                                                        <input type="number" id="Company Contact Details" class="form-control" name="m_company_contact_details" placeholder="Company Contact Details">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="monthly-income">Monthly Income</label>
                                                        <input type="number" id="monthly-income" class="form-control" name="m_monthly_income" placeholder="Monthly Income">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Address Details</h4>
                                </div>
                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">
                                            <div class="row">
                                                
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label for="local-address">Local Address</label>
                                                        <textarea name="m_local_address" id="local-address" class="form-control" cols="30" rows="3"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Emirates">Emirates</label>
                                                        <select id="Emirates" class="form-control" name="m_emirate_name">
                                                            <option>Ras Al Khaimah</option> 
                                                            <option>Umm Al Quwain</option>
                                                            <option>Abu Dhabi</option>
                                                            <option>Dubai</option>
                                                            <option>Sharjah</option>
                                                            <option>Ajman</option>
                                                            <option>Sharjah</option>
                                                            <option>Fujairah</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="local-telephone">Local telephone</label>
                                                        <input type="text" id="local-telephone" class="form-control" name="m_telephone" placeholder="Local Telephone">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="permanent-address">Permanent Address</label>
                                                        <input type="text" id="permanent-address" class="form-control" name="m_permanent_address" placeholder="Permanent Address">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="permanent-telephone">Permanent telephone</label>
                                                        <input type="number" id="permanent-telephone" class="form-control" name="m_permanent_telephone" placeholder="Company Contact Details">
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                                    <button type="reset" class="btn btn-light-secondary">Reset</button>
                                                </div>


                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->

            </form>
        </div>
    </div>
</div>
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