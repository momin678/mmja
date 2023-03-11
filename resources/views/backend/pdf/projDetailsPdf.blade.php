
@extends('layouts.pdf.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
         <section id="widgets-Statistics">
             <div class="row">
                 <div class="col-12 mt-1 mb-2">
                     <h4>Project Details</h4>
                     <hr>
                 </div>
             </div>

                 <div class="row">
                        <table id="customers">
                            <tr>
                                <th>Branch No</th>
                                <th>Branch Name</th>
                                <th>Branch Type</th>
                                <th>Manager</th>
                                <th>Site Address</th>

                                <th>Office Phone No</th>
                                <th>Mobile Number</th>
                                <th>Trade License Issue Date</th>
                                <th>License Expiery</th>
                                <th>Profit Center</th>

                            </tr>

                            @foreach ($projDetails as $proj)
                            <tr>
                                <td>{{ $proj->proj_no }}</td>
                                            <td>{{ $proj->proj_name }}</td>
                                            <td>{{ $proj->proj_type }}</td>
                                            <td>{{ $proj->owner_name }}</td>

                                            <td>{{ $proj->address }}</td>
                                            <td>{{ $proj->cons_agent }}</td>
                                            <td>{{ $proj->cont_no }}</td>
                                            <td>{{ $proj->ord_date }}</td>
                                            <td>{{ $proj->hnd_over_date }}</td>
                                            <td>{{ $proj->profitCenter($proj->pc_code)->pc_name }}</td>

                            </tr>

                            @endforeach


                        </table>
                 </div>
         </section>
        </div>
    </div>
</div>

@endsection
