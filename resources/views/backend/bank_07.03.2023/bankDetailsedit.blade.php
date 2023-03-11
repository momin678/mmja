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
                <section id="widgets-Statistics">
                    <div class="row">
                            <h4>Bank Details Form</h4>
                            <hr>

                    </div>
                  <div class="row">
                      <div class="col-12">
                          <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Bank Details</h4>
                            </div>
                              <div class="card-body">
                                  <div class="bank-form">
                                @isset($bank)
                                <form action="{{ route('bankDetailsUpdate', $bank) }}" method="POST">
                                @else
                                    <form action="{{ route('bankDetailsPost') }}" method="POST">
                                    @endisset
                                    @csrf
                                    <div class="row match-height">
                                        <div class="col-md-6">

                                                    <div class="form-body">
                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <label>Bank Code</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" id="" class="form-control" name=""
                                                                    value="{{ isset($bank) ? $bank->bank_code : '' }}"
                                                                    placeholder="Bank Name" disabled readonly>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Bank Name</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" id="bank_name" class="form-control" name="bank_name"
                                                                    value="{{ isset($bank) ? $bank->bank_name : '' }}"
                                                                    placeholder="Bank Name" required>

                                                                    @error('bank_name')

                                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Branch Name</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" id="branch" class="form-control"
                                                                    value="{{ isset($bank) ? $bank->branch : '' }}" name="branch"
                                                                    placeholder="Branch Name" required>

                                                                    @error('branch')

                                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                        </div>
                                        <div class="col-md-6">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>Account Title</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                    <input type="text" id="signatory" class="form-control"
                                                                        name="signatory"
                                                                        value="{{ isset($bank) ? $bank->signatory : '' }}"
                                                                        placeholder="Account Title" required>

                                                                        @error('signatory')

                                                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Account Number</label>
                                                            </div>
                                                            <div class="col-md-8 form-group ">
                                                                    <input type="number" id="ac_no" class="form-control"
                                                                        name="ac_no" value="{{ isset($bank) ? $bank->ac_no : '' }}"
                                                                        placeholder="Account Number" required>
                                                                        @error('ac_no')

                                                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>IBAN</label>
                                                            </div>
                                                            <div class="col-md-8 form-group ">
                                                                    <input type="text" id="" class="form-control"
                                                                        name="" value=""
                                                                        placeholder="IBAN" >

                                                            </div>


                                                            <div class="col-12 d-flex justify-content-end ">
                                                                <button class="btn btn-info bank-form-btn mr-1"
                                                                data_target="{{ route('bankForm') }}">New</button>
                                                                <button type="submit" class="btn btn-primary mr-1" >Submit</button>
                                                                <button type="reset" class="btn btn-light-secondary" >Reset</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                              </div>
                          </div>
                      </div>
                  </div>
                        <div class="row">
                            <div class="col-md-6">
                                <form >
                                            <input type="text" name="q" class="form-control input-xs pull-right ajax-search"
                                                placeholder="Search By Code, Name, Account Number"
                                                data-url="{{ route('admin.masterAccSearchAjax',$id="bankDetails") }}">

                                </form>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('pdf',$id="bankDetails") }}" class="btn btn-xs btn-info float-right" target="_blank">Print</a>
                                <button class="btn btn-xs btn-info float-right mr-1"
                            onclick="exportTableToCSV('bankdetails.csv')">Export To CSV</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Bank Code</th>
                                            <th>Bank Name</th>
                                            <th>Bank Branch</th>
                                            <th>Account Title</th>
                                            <th>Account Number</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="user-table-body">
                                        @foreach ($bankDetails as $bank)
                                            <tr>
                                                <td>{{ $bank->bank_code }}</td>
                                                <td>{{ $bank->bank_name }}</td>
                                                <td>{{ $bank->branch }}</td>
                                                <td>{{ $bank->ac_no }}</td>
                                                <td>{{ $bank->signatory }}</td>
                                                <td style="white-space: nowrap">
                                                    <a href="{{ route('bankEdit', $bank) }}"
                                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                                    <a href="{{ route('bankDelete', $bank) }}"
                                                        onclick="return confirm('about to delete Bank Information. Please, Confirm?')"
                                                        class="btn btn-sm btn-danger"><i class="bx bx-trash"
                                                            aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-right">
                                {{ $bankDetails->links() }}
                            </div>
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

                var delay = (function() {
                    var timer = 0;
                    return function(callback, ms) {
                        clearTimeout(timer);
                        timer = setTimeout(callback, ms);
                    };
                })();
                $(document).on("click", ".bank-form-btn", function(e) {
                    e.preventDefault();
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
                                $(".bank-form").empty().append(response.page);
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
