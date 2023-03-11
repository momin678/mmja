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
                                <h4>Journal View</h4>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                    {{-- <th>Action</th> --}}
                                                </tr>
                                            </thead>
            
                                            <tbody class="user-table-body">
                                                    @php
                                                        $rowcount=$journal->records->count(); 
                                                    @endphp
                                                    @foreach ($journal->records as $record)
                                                    <tr>
                                                        @if ($loop->index==0)
                                                            <td rowspan="{{$rowcount+1}}">{{ \Carbon\Carbon::parse($record->created_at)->format('d.m.Y')}}</td>
                                                        @endif
                                                        
                                                        <td style="border-bottom: none;">{{ $record->account_head }}</td>
                                                        <td style="border-bottom: none;">{{ $retVal = ($record->transaction_type=='DR') ? $record->amount : ''  }}</td>
                                                        <td style="border-bottom: none;">{{ $retVal = ($record->transaction_type=='CR') ? $record->amount : ''  }}</td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td>( {{$journal->narration}} ) </td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                            </tbody>
            
            
                                        </table>
            
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            @if(auth()->user()->hasPermission('app.journal_authorize'))
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex align-items-center justify-content-center">
                                        <div class="col-md-6">
                                            <a href="{{ $journal->state=="Authorization"? route('journalMakeAuthorize',$journal): route('journalMakeApprove',$journal) }}" onclick="return confirm('about to {{  $journal->state=="Authorization"? "authorize":"Approve" }} journal. Please, Confirm?')" class="btn btn-primary btn-block"> {{  $journal->state=="Authorization"? "authorize":"Approve" }}</a>
                                        </div>

                                        <div class="col-md-6">
                                            <form action="{{ $journal->state=="Authorization"? route('journaAuthDecline', $journal): route('journaApproveDecline', $journal) }}" method="POST">
                                                 @csrf
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="comment" placeholder="Comment" name="comment">
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger btn-block">Decline</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            @elseif (auth()->user()->hasPermission('app.journal_approval'))
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex align-items-center justify-content-center">
                                        <div class="col-md-6">
                                            <a href="{{ $journal->state=="Authorization"? route('journalMakeAuthorize',$journal): route('journalMakeApprove',$journal) }}" onclick="return confirm('about to {{  $journal->state=="Authorization"? "authorize":"Approve" }} journal. Please, Confirm?')" class="btn btn-primary btn-block">Authorized</a>
                                        </div>
                                        <div class="col-md-6">
                                            <form action="{{ $journal->state=="Authorization"? route('journaAuthDecline', $journal): route('journaApproveDecline', $journal) }}" method="POST">
                                                 @csrf
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="comment" placeholder="Comment" name="comment">
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger btn-block">Decline</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endif
                             @if(auth()->user()->hasPermission('app.journal_entry'))
                            <div class="row d-flex justify-content-center">
                                @if($journal->comment!=null)
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Comment :</h6>
                                            <p>{{ $journal->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-4">
                                    <a href="{{ route('journalEdit', $journal) }}" class="btn btn-warning btn-block">Edit</a>
                                </div>
                            </div>
                            @endif
                        </div>

                    </div>

                </section>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>
        function refreshPage() {
            window.location.reload();
        }

    </script>
@endpush
