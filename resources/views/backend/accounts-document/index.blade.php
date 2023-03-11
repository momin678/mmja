@extends('layouts.backend.app')

@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
               
                <div class="row" id="table-bordered">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body m-1">
                                <div class="d-flex mb-2">
                                    <h4 class="flex-grow-1">Documents</h4>
                                    <div>
                                        <button type="button" class="btn btn-primary btn_create formButton" title="Add" data-toggle="modal" data-target="#createModel">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                </div>
                                                <div><span>Add</span></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-7">
                                        <form method="get">
                                            <div class="form-group">
                                                <input type="text" class="inputFieldHeight form-control" name="document_name" placeholder="Docuement searche by name" value="{{$search_value}}">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-5 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary formButton mSearchingBotton mb-1" title="Searching" >
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset="" width="20">
                                                </div>
                                                <div><span> Search</span></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead class="thead-light">
                                            <tr style="height: 50px;">
                                                <th>SL No</th>
                                                <th>Name</th>
                                                <th>Download</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($documents as $document)
                                            <tr class="trFontSize">
                                            <td>{{ $document->id }}</td>
                                            <td>{{ $document->name }}</td>
                                                <td>
                                                    @foreach ($document->document_items as $item)
                                                    {{-- {{asset('storage/upload/documents')}}/{{$voucher->journal->voucher_scan}} --}}
                                                    {{ $loop->index+1 }}. <a href="{{ asset('storage/upload/documents')}}/{{$item->filename}}" target="_blank">{{ $item->display_name }}</a> <br>
                                                    @endforeach
                                                    
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>                            
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="createModel" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="content-body">
                <section class="print-hideen border-bottom">
                    <div class="d-flex flex-row-reverse">
                        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                        <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                        <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                        <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div>
                    </div>
                </section>
                @include('layouts.backend.partial.modal-header-info')

                <form class="form form-vertical p-2" 
                action="{{ route('document.store')}}"  method="POST"  enctype="multipart/form-data">
                    @csrf 
                    <section id="basic-vertical-layouts">
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="cardStyleChange">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <h4 class="card-title">Add Documents</h4>
                                            <div class="row">
                                                <div class="col-md-5 col-12">
                                                    <div class="form-group">
                                                        <label for="document_name">Document Name</label>
                                                        <input type="text" class="inputFieldHeight form-control @error('document_name') error @enderror"  name="document_name" id="">
                                                        @error('document_name')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-12">
                                                    <div class="form-group">
                                                        <label for="files">Files</label>
                                                        <input type="file" id="files" class="inputFieldHeight form-control @error('files') error @enderror" name="files[]" multiple required>
                                                        @error('numofdays')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary formButton mt-2 mb-2" title="Form Save">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                            </div>
                                                            <div><span> Save</span></div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>       
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
                @include('layouts.backend.partial.modal-footer-info')

            </div>
          </div>
        </div>
    </div>
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