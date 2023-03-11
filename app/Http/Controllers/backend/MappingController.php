<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\AccountHead;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class MappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.mapping.index');
        $mapping = Mapping::orderBy('id', 'desc')->paginate(15);
        $accoutHeads = AccountHead::all();
        return view('backend.mapping.index', compact('mapping', 'accoutHeads'));
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
            'fld_txn_type' => 'required',
            'fld_txn_mode' => 'required',
            'fld_ac_code' => 'required',
            'fld_ac_name' => 'required',
        ]);
        Mapping::create([
            'fld_txn_type' => $request->fld_txn_type,
            'fld_txn_mode' => $request->fld_txn_mode,
            'fld_ac_code'=> $request->fld_ac_code,
            'fld_ac_name'=> $request->fld_ac_name
        ]);
        $notification= array(
            'message'       => 'Mapping Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('mapping')->with($notification);
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
        $mapping_info = Mapping::find($id);
        $mapping = Mapping::orderBy('id', 'desc')->paginate(15);
        $accoutHeads = AccountHead::all();
        return view('backend.mapping.edit', compact('mapping', 'accoutHeads', 'mapping_info'));
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
            'fld_txn_type' => 'required',
            'fld_txn_mode' => 'required',
            'fld_ac_code' => 'required',
            'fld_ac_name' => 'required',
        ]);
        Mapping::find($id)->update([
            'fld_txn_type' => $request->fld_txn_type,
            'fld_txn_mode' => $request->fld_txn_mode,
            'fld_ac_code'=> $request->fld_ac_code,
            'fld_ac_name'=> $request->fld_ac_name
        ]);
        $notification= array(
            'message'       => 'Mapping Update successfully!',
            'alert-type'    => 'success'
        );
        return redirect('mapping')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mapping = Mapping::find($id);
        $mapping->delete();
        $notification = array(
            'message'       => 'Mapping Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('mapping')->with($notification);
    }
    public function account_head(Request $request){
        $fld_ac_head = $request->account_head_id;
        $fld_ac_code = AccountHead::where('id', $fld_ac_head)->first();
        return $fld_ac_code->fld_ac_code;
    }
    public function account_code(Request $request){
        $fld_ac_code = $request->fld_ac_code;
        $account_head = AccountHead::all();
        return response()->json($account_head);
    }
}
