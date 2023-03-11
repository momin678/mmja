@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        .table-bordered {
            border: 1px solid #f4f4f4;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        table {
            background-color: transparent;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        .tarek-container {
            width: 85%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 88% 12%;
            background-color: #ffff;
        }

        .invoice-label {
            font-size: 10px !important
        }
    </style>
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <h4>Journal</h4>
                                <hr>
                            </div>

                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            {{-- <form>
                                <input type="text" name="q" class="form-control input-xs pull-right ajax-search"
                                    placeholder="Search By Project No, Project Name, Mobile Number"
                                    data-url="{{ route('admin.masterAccSearchAjax', $id = 'projectDetails') }}">

                            </form> --}}
                        </div>
                        <div class="col-md-6 text-right">
                            {{-- <a href="{{ route('pdf', $id = 'projDetails') }}" class="btn btn-xs btn-info float-right"
                                target="_blank">Print</a> --}}
                            <button class="btn btn-xs btn-info float-right" onclick="exportTableToCSV('journal.csv')">Export
                                To CSV</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Project</th>
                                        <th>Owner</th>
                                        <th>Location</th>
                                        <th>Mobile</th>
                                        <th>Journal No</th>
                                        <th>Date</th>
                                        <th>Invoice No</th>
                                        <th>Cost Center</th>
                                        <th>Party Info</th>
                                        <th>TXN Type</th>
                                        <th>Pay Mode</th>
                                        <th>Account Head</th>
                                        <th>Amount</th>
                                        <th>Tax Rate</th>
                                        <th>Vat Amount</th>
                                        <th>Total Amount</th>
                                        <th>Narration</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody class="user-table-body">
                                    @foreach ($journals as $journal)
                                        <tr>
                                            <td>{{ $journal->project->proj_name }}</td>
                                            <td>{{ $journal->project->owner_name }}</td>
                                            <td>{{ $journal->project->address }}</td>
                                            <td>{{ $journal->project->cont_no }}</td>
                                            <td>{{ $journal->journal_no }}</td>
                                            <td>{{ $journal->date }}</td>
                                            <td>{{ $journal->invoice_no }}</td>
                                            <td>{{ $journal->costCenter->cc_name }}</td>
                                            <td>{{ $journal->PartyInfo->pi_name }}</td>
                                            <td>{{ $journal->txn_type }}</td>
                                            <td>{{ $journal->txn_mode }}</td>
                                            <td>{{ $journal->accHead->fld_ac_code }},
                                                {{ $journal->accHead->fld_ac_head }}</td>
                                            <td>{{ $journal->amount }}</td>
                                            <td>{{ $journal->taxRate->name }}</td>
                                            <td>{{ $journal->vat_amount }}</td>
                                            <td>{{ $journal->total_amount }}</td>
                                            <td>{{ $journal->narration }}</td>
                                            <td style="white-space: nowrap">
                                                <a href="{{ route('journalView', $journal) }}"
                                                    class="btn btn-sm btn-warning" target="_blank"><i class="bx bx-hide"></i></a>
                                                <a href="{{ route('journalDelete', $journal) }}"
                                                    onclick="return confirm('about to delete journal. Please, Confirm?')"
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
                            {{ $journals->links() }}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        function refreshPage() {
            window.location.reload();
        }



    </script>
@endpush
