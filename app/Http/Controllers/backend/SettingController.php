<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings= Setting::all();
        return view('backend.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.settings.form');
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
            'config_name'   => 'required|unique:settings',
            'config_value'   => 'required'
        ]);


        // voucher scan upload
        if($request->hasFile('config_value')){
            $config_value= $request->file('config_value');
            $name= $config_value->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext= $config_value->getClientOriginalExtension();
            $settings_file_name= $name.time().'.'.$ext;
            $config_value->storeAs( 'public/upload/settings', $settings_file_name);

        }

        $settings= new Setting;
        $settings->config_name      = $request->config_name;
        $settings->config_type      = $request->config_type;
        $settings->config_value     = '';
        
        if($settings->config_type=='text'){
            $settings->config_value     = $request->config_value;
        }else{
            $settings->config_value     = $settings_file_name;
        }
        
        $settings->save();

        $notification= array(
            'message'       => 'Settings Saved!',
            'alert-type'    => 'success'
        );
        return redirect('settings')->with($notification);
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
        $edit_setting= Setting::find($id);
        return view('backend.settings.form', compact('edit_setting'));
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
            'config_name'   => 'required',
            'config_value'   => 'required'
        ]);

        // return $request;

        // voucher scan upload
        if($request->hasFile('config_value')){
            $config_value= $request->file('config_value');
            $name= $config_value->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext= $config_value->getClientOriginalExtension();
            $settings_file_name= $name.time().'.'.$ext;
            $config_value->storeAs( 'public/upload/settings', $settings_file_name);

        }

        $settings= Setting::find($id);
        $settings->config_name      = $request->config_name;
        $settings->config_type      = $request->config_type;
        $settings->config_value     = '';
        
        if($settings->config_type=='text'){
            $settings->config_value     = $request->config_value;
        }else{
            $settings->config_value     = $settings_file_name;
        }

        $settings->save();

        $notification= array(
            'message'       => 'Settings Updated!',
            'alert-type'    => 'success'
        );
        return redirect('settings')->with($notification);
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
