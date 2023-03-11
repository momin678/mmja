
@extends('layouts.pdf.app')
@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
         <section id="widgets-Statistics">
             <div class="row">
                 <div class="col-12 mt-1 mb-2">
                     <h4>Party Info Details</h4>
                     <hr>
                 </div>
             </div>

                 <div class="row ">
                        <table id="customers">
                            <tr>
                                <th>Party Code</th>
                                <th>Party Name</th>
                                <th>Type</th>
                                <th>TRN Number</th>
                                <th>Contact Person</th>
                                <th>Contact Number</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Email</th>
                            </tr>

                            @foreach ($partyInfos as $pInfo)
                            <tr>
                                <td>{{ $pInfo->pi_code }}</td>
                                <td>{{ $pInfo->pi_name }}</td>
                                <td>{{ $pInfo->pi_type }}</td>
                                <td>{{ $pInfo->trn_no }}</td>
                                <td>{{ $pInfo->con_person }}</td>
                                <td>{{ $pInfo->con_no }}</td>
                                <td>{{ $pInfo->phone_no }}</td>
                                <td>{{ $pInfo->address }}</td>
                                <td>{{ $pInfo->email }}</td>

                            </tr>
                        @endforeach



                        </table>
                 </div>
         </section>
        </div>
    </div>
</div>

@endsection
