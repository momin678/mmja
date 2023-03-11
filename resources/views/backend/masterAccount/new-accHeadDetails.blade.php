@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

@endpush
@section('content')
@include('layouts.backend.partial.style')
<style>
    .accordion .pluseMinuseIcon.collapsed::before{
        content: "\f067";;
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .accordion .pluseMinuseIcon::before {
        font-family: 'FontAwesome';  
        content: "\f068";
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .rowStyle{
        cursor: pointer;
        border-left: dotted;
        padding: 3px;
        margin-bottom: 2px;
    }
    .findMasterAcc{
        cursor: pointer;
    }
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route('new-chart-of-account')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/master-account.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Master Account</div>
                </a>
                <a href="{{route('new-account-head')}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/account-heads.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Account Head</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <section id="widgets-Statistics"  class="mr-1 ml-1 mb-2 accountHeadStyle HeadStyle">
                        <div class="row">
                            <div class="col-12 mt-2 user-table-body">
                                <h4>Account Head Details</h4>
                                @isset($masterAcc)
                                <form action="{{ route('masterDetailsPost', $masterAcc) }}" method="POST">
                                @else
                                <form action="{{ route('masterDetailsPost') }}" method="POST">
                                    @endisset
                                    @csrf
                                    <div class="row p-1">
                                        <div class="col-md-2 changeColStyle">
                                            <label>A/C Code</label>
                                            <input type="text" id="ma_code" class="form-control inputFieldHeight" name="ma_code" value="{{ isset($masterAcc) ? $masterAcc->MstACCode : '' }}" placeholder="A/C Code" readonly>
                                            @error('ma_code')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 changeColStyle">
                                            <label>A/C Head</label>
                                            <input type="text" id="fld_ac_head" class="form-control inputFieldHeight" name="fld_ac_head" value="{{ isset($masterAcc) ? $masterAcc->MstACCode : '' }}" placeholder="A/C Head" readonly>
                                            @error('fld_ac_head')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 changeColStyle">
                                            <label>Master A/C Head</label>
                                            <input type="text" name="fld_ac_head" class="form-control inputFieldHeight" placeholder="Master A/C Head" value="{{ isset($masterAcc) ? $masterAcc->MstACHead : '' }}" readonly>
                                        </div>
                                        <div class="col-md-3 changeColStyle">
                                            <label>Definition</label>
                                            <input type="text" name="fld_ac_head" class="form-control inputFieldHeight" placeholder="Definition" value="{{ isset($masterAcc) ? $masterAcc->MstDefinition : '' }}" readonly>
                                        </div>
                                        <div class="col-md-3 d-flex justify-content-end mt-2">
                                            <button type="submit" class="btn btn-primary mr-1 formButton" disabled title="Form Save">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                    </div>
                                                    <div><span> Save</span></div>
                                                </div>
                                            </button>
                                            <button type="reset" class="btn btn-light-secondary formButton" disabled title="Form Reset">
                                                <div class="d-flex">
                                                    <div class="formRefreshIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                    </div>
                                                    <div><span> Reset</span></div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                    <hr>
                    <section class="accountHeadDetails">
                        <div class="container">
                            <div id="accordion" class="accordion">
                                <div class="card mb-0">
                                    @foreach ($master_details as $masterAcc)
                                        <div class="pluseMinuseIcon collapsed" data-toggle="collapse" href="#collapse{{$masterAcc->id}}" aria-controls="collapse{{$masterAcc->id}}" aria-expanded="false">
                                            <li class="btn findMasterAcc" data-target="{{ route('findMasterAcc', $masterAcc) }}">{{ $masterAcc->mst_ac_code }} - {{ $masterAcc->mst_ac_head }}</li>
                                        </div>
                                        <div id="collapse{{$masterAcc->id}}" class="collapse multi-collapse">
                                            @foreach (App\Models\AccountHead::where('ma_code',$masterAcc->mst_ac_code)->get() as $item)
                                            <div class="rowStyle d-flex ml-2">
                                                <div style="line-height: 20px;">.....</div>
                                                <div>
                                                    
                                                    <a href="#" class="editAccHead" data-target="{{ route('editAccHead', $item) }}">{{ $item->fld_ac_code }}-{{ $item->fld_ac_head }}
                                                    </a>
                                                    <a href="{{ route('deleteAcHead',$item) }}" class="text-danger" onclick="return confirm('Delete Account Head. Confirm?')">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px;">
                                                    </a>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $('#category').change(function() {
                // alert(1);
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('findMastedCode') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            $("#mst_ac_code").val(response);
                        }

                    })
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

        $(document).on("click", ".findMasterAcc", function(e) {
            e.preventDefault();
            var that = $(this);

            var urls = that.attr("data-target");
            delay(function() {
                $.ajax({
                    url: urls,
                    type: 'GET',
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        //   alert('ok');
                        // console.log(response);
                        $(".pagination").remove();
                        $(".user-table-body").empty().append(response.page);
                    },
                    error: function() {
                        //   alert('no');
                    }
                });
            }, 999);
        });
        $(document).on("click", ".editAccHead", function(e) {
            e.preventDefault();
            var that = $(this);

            var urls = that.attr("data-target");
            delay(function() {
                $.ajax({
                    url: urls,
                    type: 'GET',
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        //   alert('ok');
                        // console.log(response);
                        $(".pagination").remove();
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
@endpush
