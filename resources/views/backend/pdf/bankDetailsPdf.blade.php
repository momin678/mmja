
@extends('layouts.pdf.app')
@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
         <section id="widgets-Statistics">
             <div class="row">
                 <div class="col-12 mt-1 mb-2">
                     <h4>Bank Details</h4>
                     <hr>
                 </div>
             </div>

                 <div class="row">
                         <table id="customers">
                                 <tr>
                                    <th>Bank Code</th>
                                    <th>Bank Name</th>
                                    <th>Bank Branch</th>
                                    <th>Account Title</th>
                                    <th>Account Number</th>

                                 </tr>
                                 @foreach ($bankDetails as $bank)
                                            <tr>
                                                <td>{{ $bank->bank_code }}</td>
                                                <td>{{ $bank->bank_name }}</td>
                                                <td>{{ $bank->branch }}</td>
                                                <td>{{ $bank->signatory }}</td>
                                                <td>{{ $bank->ac_no }}</td>

                                            </tr>
                                        @endforeach
                         </table>
                 </div>
         </section>
        </div>
    </div>
</div>

@endsection
