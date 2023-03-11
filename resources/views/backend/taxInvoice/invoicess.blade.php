@extends('layouts.backend.app')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">

        <div class="content-body">
            <!-- Widgets Statistics start -->
            <section id="widgets-Statistics">
                <div class="row">
                    <div class="col-12 mt-1 mb-2">
                        <h4>Invoice</h4>
                        <hr>

                    </div>
                </div>






                <div class="row">
                    {{-- <div class="col-md-6">
                        <form>
                            <input type="text" name="q" class="form-control input-xs pull-right ajax-search"
                                placeholder="Search By Project No, Project Name, Mobile Number"
                                data-url="{{ route('admin.masterAccSearchAjax', $id = 'projectDetails') }}">

                        </form>
                    </div> --}}
                    {{-- <div class="col-md-6 text-right">
                        <a href="{{ route('pdf', $id = 'invoicess') }}" class="btn btn-xs btn-info float-right"
                            target="_blank">Print</a>
                        <button class="btn btn-xs btn-info float-right"
                            onclick="exportTableToCSV('projectdetails.csv')">Export To CSV</button>
                    </div> --}}
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Customer Name</th>

                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="user-table-body">
                                @foreach ($invoicess as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_no }}</td>
                                        <td>{{ $invoice->customer_name }}</td>

                                        <td style="white-space: nowrap">
                                            <a href="{{ route('invoicePrint', $invoice) }}"
                                                class="btn btn-sm btn-warning" target="_blank">Print</a>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>


                        </table>

                    </div>

                </div>
                {{-- <div class="row">
                    <div class="col-12 text-right">
                        {{ $invoicess->links() }}
                    </div>
                </div> --}}
            </section>
            <!-- Widgets Statistics End -->



        </div>
    </div>
</div>
@endsection
