
@extends('layouts.pdf.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
         <section id="widgets-Statistics">
             <div class="row">
                 <div class="col-12 mt-1 mb-2">
                     <h4>Cost Center</h4>
                     <hr>
                 </div>
             </div>

                 <div class="row">
                        <table id="customers">
                            <tr>
                                <th>Cost Center Code</th>
                                        <th>Cost Center Name</th>
                                        <th>Activity</th>
                                        <th>Person Resposible</th>
                                        <th>Branch Name</th>
                            </tr>

                            @foreach ($costCenters as $cCenter)
                            <tr>
                                <td>{{ $cCenter->cc_code }}</td>
                                <td>{{ $cCenter->cc_name }}</td>
                                <td>{{ $cCenter->activity }}</td>
                                <td>{{ $cCenter->prsn_responsible }}</td>
                                <td>{{ isset($cCenter->project)? $cCenter->project->proj_name :"" }}</td>


                            </tr>

                            @endforeach


                        </table>
                 </div>
         </section>
        </div>
    </div>
</div>

@endsection
