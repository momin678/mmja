@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content print-hidden">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="tab-content bg-white">
            <div>
                <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                    <div class="row">
                        <div class="col-md-6  mt-2 mb-2">
                            <h4>Estimate Information </h4>
                        </div>
                            {{-- @include('alerts.alerts') --}}
                    </div>
                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                        <div class="col-12">
                            <form action="{{ route('estimate-list.store') }}" method="POST">
                                @csrf
                                <div class="cardStyleChange">
                                    <div class="row">
                                        <div class="col-md-2 changeColStyle">
                                            <label>Customer Name</label>
                                            <select name="customer_id" class="common-select2" style="width: 100% !important" id="" required>
                                                <option value="">Select Name</option>
                                                @foreach ($partys as $party)
                                                    <option value="{{ $party->id }}"> {{ $party->pi_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 changeColStyle">
                                            <label>Estimate Date</label>
                                            <input type="date" class="form-control inputFieldHeight" name="estimate_date" required>
                                        </div>
                                        <div class="col-md-2 changeColStyle">
                                            <label>Expiry Date</label>
                                            <input type="date" class="form-control inputFieldHeight" name="expire_date" required>
                                        </div>
                                        <div class="col-md-2 changeColStyle">
                                            <label>Estimate Amount</label>
                                            <input type="number" class="form-control inputFieldHeight" name="estimate_amount" required>
                                        </div>
                                        <div class="col-md-2 changeColStyle">
                                            <label>Estimate Number</label>
                                            <input type="text" class="form-control inputFieldHeight" name="estimate_number" required>
                                        </div>
                                        <div class="col-md-2 changeColStyle">
                                            <label>Reference</label>
                                            <input type="text" class="form-control inputFieldHeight" name="reference" required>
                                        </div>
                                    
                                        <div class="col-12 d-flex justify-content-end changeColStyle">
                                            <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                    </div>
                                                    <div><span> Save</span></div>
                                                </div>
                                            </button>
                                            <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset">
                                                <div class="d-flex">
                                                    <div class="formRefreshIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                    </div>
                                                    <div><span> Reset</span></div>
                                                </div>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <hr>

                <section class="mr-1 ml-1">
                    <div class="mt-2">
                        <div class="cardStyleChange">
                            <table class="table mb-0 table-sm table-hover">
                                <thead  class="thead-light">
                                    <tr style="height: 50px;">
                                        <th>Estimate Date</th>
                                        <th>Expire date</th>
                                        <th>Estimate Number</th>
                                        <th>Reference</th>
                                        <th>Customer Name</th>
                                        <th>Estimated amount</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($estimats as $estimat)
                                    <tr class="trFontSize">
                                        <td>{{ $estimat->estimate_date }}</td>
                                        <td>{{ $estimat->expire_date }}</td>
                                        <td>{{ $estimat->estimate_number }}</td>
                                        <td>{{ $estimat->reference }}</td>
                                        <td>{{ $estimat->partyInfo->pi_name }}</td>
                                        <td>{{ $estimat->estimate_amount }}</td>
                                        <td style="padding-bottom: 11px; padding-top: 0px">
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ route('estimate-list.edit', $estimat->id) }}" class="btn" style="height: 30px; width: 30px;" title="Eidt"><img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;"></a>
                                            </div>
                                         </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="partyCenterPreviewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="partyCenterView">
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>
        $(document).on("click", ".partyCenterView", function(e) { 
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{URL('party-center-preview')}}",
                type: "post",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){				
                    document.getElementById("partyCenterView").innerHTML = response;
                    $('#partyCenterPreviewModal').modal('show')
                }
            });
        });
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
            $(document).on("click", ".party-info-form-btn", function(e) {
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
                            $(".party-info-form").empty().append(response.page);
                        },
                        error: function() {
                            //   alert('no');
                        }
                    });
                }, 999);
            });
        });
    </script>
    <script>
        function pagePrint(){
            document.getElementById("mPrintHidden").style.display = "none";
            window.print();
        }
        function partyListPrint(){
            // document.getElementById("mPrintHidden").style.display = "block";
            window.print();
        }
    </script>
@endpush

