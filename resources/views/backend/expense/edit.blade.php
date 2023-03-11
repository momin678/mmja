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
                            <h4>Expense Form</h4>
                            <hr>
                    </div>
                  <div class="row">
                      <div class="col-12">
                          <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Expense</h4>
                            </div>
                              <div class="card-body">
                                  <div class="bank-form">
                                    @isset($edit_expense)
                                    <form action="{{ route('expense.update', $edit_expense) }}" method="POST">
                                    @else
                                        <form action="{{ route('expense.store') }}" method="POST" enctype="multipart/form-data">
                                        @endisset
                                        @csrf
                                        <div class="row match-height">
                                            <div class="col-md-6">

                                                        <div class="form-body">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label>Master Accountdd</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <select name="master_acount" class="common-select2" style="width: 100% !important" id="master_acount" required>
                                                                        <option value="">Select...</option>
                                                                        @foreach ($master_accounts as $item)
                                                                            <option value="{{ $item->mst_ac_code }}"
                                                                                {{ isset($edit_expense) && $edit_expense->master_acount_id == $item->mst_ac_code ? 'selected': ''}}
                                                                                >
                                                                                {{ $item->mst_ac_head }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('master_acount')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Account Head</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <select name="account_head" class="common-select2" style="width: 100% !important" id="account_head"
                                                                        required>
                                                                        <option value="">Select...</option>
                                                                        @foreach ($account_heads as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ isset($edit_expense) && $edit_expense->account_head_id == $item->id ? 'selected': ''}}>
                                                                                {{ $item->fld_ac_head }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('account_head')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Party</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <select name="party_name" class="common-select2" style="width: 100% !important" id=""
                                                                        required>
                                                                        <option value="">Select...</option>
                                                                        @foreach ($parties as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ isset($edit_expense) && $edit_expense->party_info_id == $item->id ? 'selected': ''}}>
                                                                                {{ $item->pi_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('party_name')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Date</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                        <input type="date" id="date" class="form-control"
                                                                            name="date" value="{{ $edit_expense->date}}"
                                                                            placeholder="date" required>

                                                                        @error('date')
                                                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                        @enderror
                                                                </div>
                                                                

                                                                <div class="col-md-4">
                                                                    <label>Voucher Upload</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                    <input type="file" class="form-control" name="voucher_copy" required>

                                                                    @error('bank_name')
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
                                                                    <label>Taxable Amount</label>
                                                                </div>
                                                                <div class="col-md-8 form-group">
                                                                        <input type="text" id="signatory" class="form-control"
                                                                            name="taxable_amount"
                                                                            value="{{ isset($edit_expense) ? $edit_expense->taxable_amount : '' }}"
                                                                            placeholder="Taxable Account" required>

                                                                        @error('taxable_amount')
                                                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                        @enderror
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>Vat Amount</label>
                                                                </div>
                                                                <div class="col-md-8 form-group ">
                                                                        <input type="number" id="vat_amount" class="form-control"
                                                                            name="vat_amount" value="{{ isset($edit_expense) ? $edit_expense->vat_amount : '' }}"
                                                                            placeholder="Vat Amount" required>
                                                                        @error('vat_amount')
                                                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                        @enderror
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Total Amount</label>
                                                                </div>
                                                                <div class="col-md-8 form-group ">
                                                                        <input type="text" class="form-control"
                                                                            name="total_amount" 
                                                                            value="{{ $edit_expense->total_amount}}"
                                                                            placeholder="Total Amount" >
                                                                        @error('total_amount')
                                                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                        @enderror

                                                                </div>

                                                                <div class="col-12 d-flex justify-content-end ">
                                                                    <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                                                    <button type="reset" class="btn btn-light-secondary">Reset</button>

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
                                            <th>Master Acc</th>
                                            <th>Acc Head</th>
                                            <th>Taxable Amount</th>
                                            <th>Vat Amount</th>
                                            <th>Total</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="user-table-body">
                                        @isset($expenses)                                            
                                        
                                        @foreach ($expenses as $expense)
                                            <tr>
                                                <td>{{ $expense->master_account->mst_ac_head }} </td>
                                                <td>{{ $expense->account_head->fld_ac_head }}</td>
                                                <td>{{ $expense->taxable_amount }}</td>
                                                <td>{{ $expense->vat_amount }}</td>
                                                <td>{{ $expense->total_amount }}</td>

                                                <td style="white-space: nowrap">
                                                    <a href="{{route('expense.edit', $expense->id)}}"
                                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                                    <a href="{{ route('bankDelete', $expense) }}"
                                                        onclick="return confirm('about to delete Bank Information. Please, Confirm?')"
                                                        class="btn btn-sm btn-danger"><i class="bx bx-trash"
                                                            aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @isset($expenses)
                        <div class="row">
                            <div class="col-12 text-right">
                                {{ $expenses->links() }}
                            </div>
                        </div>
                        @endisset
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

                $('#master_acount').change(function(){
                var ac_code= $(this).val();
                var csrf_token= '{{ csrf_token()}}';
                $.ajax({
                url:  '{{route("expense_get_account_head")}}',
                dataType: 'json',
                type: 'post',
                data: {ac_code: ac_code, _token: csrf_token },
                success:function(response){
                    
                    var optionHtml= '<option value=""> Select Section </option>';

                    response.forEach(function(element, index) { 
                        console.log(element);
                        optionHtml += "<option value='"+element.id +"'> "+ element.fld_ac_head+"</option>";
                     });
                     $('#account_head').html(optionHtml);
                     $('#account_head').select2();
                     console.log(optionHtml);
                    
                        
                }
                });
            });
            });
</script>


@endpush
