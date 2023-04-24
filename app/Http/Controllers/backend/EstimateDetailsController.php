<?php

namespace App\Http\Controllers\backend;

use App\EstimateDetail;
use App\Http\Controllers\Controller;
use App\PartyInfo;
use Illuminate\Http\Request;

class EstimateDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estimats = EstimateDetail::all();
        $partys = PartyInfo::all();
        return view('backend.estimat.index', compact('estimats', 'partys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'=>'required',
            'estimate_date'=>'required',
            'expire_date'=>'required',
            'estimate_amount'=>'required',
            'estimate_number'=>'required',
            'reference'=>'required',
        ]);
        $data = new EstimateDetail;
        $data->customer_id = $request->customer_id;
        $data->estimate_date = $request->estimate_date;
        $data->expire_date = $request->expire_date;
        $data->estimate_amount = $request->estimate_amount;
        $data->estimate_number = $request->estimate_number;
        $data->reference = $request->reference;
        $data->save();
        $notification = array(
            'message'=> 'Estimate Data Create Successfull',
            'alert-type'=> 'success'
        );
        return back()->with($notification);
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
        $estimats = EstimateDetail::all();
        $partys = PartyInfo::all();
        $estimateInfo = EstimateDetail::find($id);
        return view('backend.estimat.edit', compact('estimats', 'partys', 'estimateInfo'));
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
            'customer_id'=>'required',
            'estimate_date'=>'required',
            'expire_date'=>'required',
            'estimate_amount'=>'required',
            'estimate_number'=>'required',
            'reference'=>'required',
        ]);
        $data = EstimateDetail::find($id);
        $data->customer_id = $request->customer_id;
        $data->estimate_date = $request->estimate_date;
        $data->expire_date = $request->expire_date;
        $data->estimate_amount = $request->estimate_amount;
        $data->estimate_number = $request->estimate_number;
        $data->reference = $request->reference;
        $data->save();
        $notification = array(
            'message'=> 'Estimate Data Update Successfull',
            'alert-type'=> 'success'
        );
        return redirect('estimate-list')->with($notification);
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
