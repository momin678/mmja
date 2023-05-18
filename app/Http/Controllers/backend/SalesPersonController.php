<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\SalesPerson;
use Illuminate\Http\Request;

class SalesPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salesPersons=SalesPerson::all();
        // return $salesPerson;
        return view('backend.salesPerson.index', compact('salesPersons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.salesPerson.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
                'name'          => 'required',
                'email'         => 'required',
            ],
            [
                'name.required'     => 'Name is required',
                'email.required'    => 'Email is required',
            ]
        );

        $salesPerson= New SalesPerson();
        $salesPerson->name      = $request->name;
        $salesPerson->email     = $request->email;
        $salesPerson->save();
        return redirect()->route('sales-person.index')->with('success','Added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $person= SalesPerson::find($id);
        return view('backend.salesPerson.edit',compact('person'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required',
        ],
        [
            'name.required'     => 'Name is required',
            'email.required'    => 'Email is required',
        ]
    );

    $salesPerson= SalesPerson::find($id);
    $salesPerson->name      = $request->name;
    $salesPerson->email     = $request->email;
    $salesPerson->save();
    return redirect()->route('sales-person.index')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
