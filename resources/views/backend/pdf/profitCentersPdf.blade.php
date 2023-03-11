
@extends('layouts.pdf.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
         <section id="widgets-Statistics">
             <div class="row">
                 <div class="col-12 mt-1 mb-2">
                     <h4>Profit Center</h4>
                     <hr>
                 </div>
             </div>

                 <div class="row">
                        <table id="customers">
                            <tr>
                                <th>Profit Center Code</th>
                                <th>Profit Center Name</th>
                                <th>Activity</th>
                                <th>Person Resposible</th>
                            </tr>

                            @foreach ($profitDetails as $pCenter)
                            <tr>
                                <td>{{ $pCenter->pc_code }}</td>
                                <td>{{ $pCenter->pc_name }}</td>
                                <td>{{ $pCenter->activity }}</td>
                                <td>{{ $pCenter->prsn_responsible }}</td>

                            </tr>

                            @endforeach


                        </table>
                 </div>
         </section>
        </div>
    </div>
</div>

@endsection
