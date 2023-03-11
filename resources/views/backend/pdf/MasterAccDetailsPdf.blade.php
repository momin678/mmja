
@extends('layouts.pdf.app')
@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
         <section id="widgets-Statistics">
             <div class="row">
                 <div class="col-12 mt-1 mb-2">
                     <h4>Master Account Details</h4>
                     <hr>
                 </div>
             </div>

                 <div class="row">
                        <table id="customers">
                            <tr>
                                <th>Master A/C Code</th>
                                <th>Master A/C Head</th>
                                <th>Desfinition</th>
                                <th>Master A/C Type</th>
                                <th>VAT Type</th>
                            </tr>

                            @foreach ($masterDetails as $masterAcc)
                            <tr>
                                <td>{{ $masterAcc->mst_ac_code }}</td>
                                <td>{{ $masterAcc->mst_ac_head }}</td>
                                <td>{{ $masterAcc->mst_definition }}</td>
                                <td>{{ $masterAcc->mst_ac_type }}</td>
                                <td>{{ $masterAcc->vat_type }}</td>


                            </tr>

                            @endforeach



                        </table>
                 </div>
         </section>
        </div>
    </div>
</div>

@endsection
