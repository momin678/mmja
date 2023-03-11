@extends('layouts.backend.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                {{-- <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="breadcrumbs-top">
                        <h5 class="content-header-title float-left pr-1 mb-0">Student Leave</h5>
                        <div class="breadcrumb-wrapper d-none d-sm-block">
                            <ol class="breadcrumb p-0 mb-0 pl-1">
                                <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active">Leave
                                </li>
                            </ol>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="content-body">
               
                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Documents</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form form-vertical" action="{{ route('document-search')}}" method="POST">
                                        @csrf
                                        <div class="form-body">
                                            <div class="row">
                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="employee_id">Document Name</label>
                                                        <input type="text" class="form-control" name="document_name" id="">
                                                        @error('document_name')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                                

                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    
                                                    <button type="submit" class="btn btn-primary mr-1">
                                                        Search
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->

                <!-- Bordered table start -->
                @isset($documents) 
                <div class="row" id="table-bordered">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Documents</h4>
                                {{-- <button class="btn btn-default" onclick="location.reload();">Reload</button> --}}
                                <a href="{{ route('document.create')}}" class="btn btn-primary">Add New</a>
                            </div>
                            <div class="card-body">
                                <!-- table bordered -->
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>SL No</th>
                                                <th>Name</th>
                                                <th>Download</th>
                                                {{-- <th>Actions</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($documents as $document)
                                            <tr>
                                            <td>{{ $document->id }}</td>
                                            <td>{{ $document->name }}</td>
                                            <td>
                                                @foreach ($document->document_items as $item)
                                                {{ $loop->index+1 }}. <a href="{{ asset('storage/upload/documents/'.$item->filename)}}" target="_blank">{{ $item->display_name }}</a> <br>
                                                @endforeach
                                                
                                            </td>
                                            {{-- <td>
                                                <a href="{{route('student.show', $document->id)}}" class="btn btn-icon btn-primary "><i class="bx bx-show"></i></a>
                                            </td> --}}
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>                            
                            </div>

                        </div>
                    </div>
                </div>
                @endisset
                <!-- Bordered table end -->



            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            // Page Script
            $('#class_id').change(function(){
                var class_id= $(this).val();
                var csrf_token= '{{ csrf_token()}}';
                $.ajax({
                url:  '',
                dataType: 'json',
                type: 'post',
                data: {class_id: class_id, _token: csrf_token },
                success:function(response){
                    
                    var optionHtml= '<option> Select Section </option>';

                    response.forEach(function(element, index) { 
                        console.log(element);
                        optionHtml += "<option value='"+element.id +"'> "+ element.name+"</option>";
                     });
                     $('#section_id').html(optionHtml);
                     console.log(optionHtml);
                    
                        
                }
                });
            });

            $('#section_id').change(function(){
                var class_id= $('#class_id').val();
                var section_id= $(this).val();
                var csrf_token= '{{ csrf_token()}}';
                $.ajax({
                url:  '',
                dataType: 'json',
                type: 'post',
                data: {class_id: class_id,section_id: section_id, _token: csrf_token },
                success:function(response){
                    
                    var optionHtml= '<option> Select Section </option>';

                    response.forEach(function(element, index) { 
                        console.log(element);
                        optionHtml += "<option value='"+element.id +"'> "+ element.fname + " " +element.mname+ " " +element.family_name + "("+element.sis_number+")" +"</option>";
                     });
                     $('#student-name').html(optionHtml);
                     console.log(optionHtml);
                        
                }
                });
            });

        });
    </script>
@endpush