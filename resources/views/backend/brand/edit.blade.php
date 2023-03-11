@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

@endpush
@section('title', 'color edit')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                  <div class="row">
                      <div class="col-12">
                          <div class="card">
                            <div class="card-header content-title">
                                <h4>Color Edit Information</h4>
                            </div>
                              <div class="card-body content-padding">
                                <form action="{{ route('brand.update',$brand_info->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row match-height">
                                        <div class="col-md-6">
                                            <label for="">Color ID</label>
                                            <input type="text" name="brand_id" class="form-control" value="{{$brand_info->brand_id}}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Color</label>
                                            <input type="text" name="name" class="form-control" value="{{$brand_info->name}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Origin</label>
                                            <select name="origin" id="selectElement" class="form-control common-select2">
                                                <option value=""></option>
                                                @foreach ($countries as $country)
                                                <option value="{{$country->name}}" {{$country->name == $brand_info->origin ? "selected": ""}}>{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 d-flex justify-content-end mt-1">
                                            <button type="submit" class="btn btn-primary btn-sm mr-1">Update</button>
                                            <button type="reset" class="btn mr-1 btn-sm" id="reset">Reset</button>
                                        </div>
                                    </div>
                                </form>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="table-responsive card">
                      <table class="table table-sm table-bordered">
                          <thead class="user-table-body">
                          <tr>
                              <th>Color ID</th>
                              <th>Color</th>
                              <th>Origin</th>
                              <th>Action</th>
                          </tr>
                          </thead>
  
                          <tbody class="user-table-body">
                              @foreach ($brands as $brand)
                              <tr  class="data-row">
                                  <td>{{ $brand->brand_id }}</td>
                                  <td>{{ $brand->name }}</td>
                                  <td>{{ $brand->origin }}</td>
  
                                  <td style="white-space: nowrap">
                                      <a href="{{route('brand.edit', $brand->id)}}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>                                    
                                      <a href="">
                                          <form action="{{ route('brand.destroy', $brand->id) }}" method="POST">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirm?')" ><i class="bx bx-trash"></i></button>
                                          </form>
                                      </a>
                                  </td>
                              </tr>
  
                              @endforeach
                          </tbody>
  
  
                      </table>
  
                  </div>
                  <div class="row">
                      <div class="col-12 text-right">
                          {{$brands->links()}}
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

<script>
    $(document).ready(function() {
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
    });
 $(document).ready(function() {

    $(document).on('keypress', '.user-search', function(e) {
        if (e.which == 13) {
            e.preventDefault();
        }
    });
    var delay = (function() {
        var timer = 0;
        return function(callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $(document).on("keyup", ".user-search", function(e) {
        e.preventDefault();
        // alert('ok');
        var that = $(this);
        var q = e.target.value;
        var url = that.attr("data-url");
        var urls = url + '?q=' + q;

        delay(function() {
            $.ajax({
                url: urls,
                type: 'GET',
                cache: false,
                dataType: 'json',
                success: function(response) {
                    //   alert('ok');
                    console.log(response);
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
