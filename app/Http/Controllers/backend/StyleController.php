<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\ItemList;
use App\Style;
use Illuminate\Http\Request;

class StyleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $styles = Style::paginate(20);
        return view('backend.style.index', compact('styles'));
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
            'style_name' => 'required|unique:styles',
            'style_no' => 'required',
        ]);
        Style::create([
            'style_name' => $request->style_name,
            'style_no' => $request->style_no,
        ]);
        $notification= array(
            'message'       => 'Style Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('style')->with($notification);
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
        $style_info  = Style::find($id);
        $styles = Style::paginate(20);
        return view('backend.style.edit', compact('styles', 'style_info'));
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
            'style_name' => 'required|unique:styles',
            'style_no' => 'required',
        ]);
        Style::find($id)->update([
            'style_name' => $request->style_name,
            'style_no' => $request->style_no,
        ]);
        $notification= array(
            'message'       => 'Style Updated successfully!',
            'alert-type'    => 'success'
        );
        return redirect('style')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $style = Style::find($id);
        $search = ItemList::where('style_id', $style->style_no)->count();
        if ($search > 0) {
            return back()->with('error', "It has Related with Item Table");
        }
        $style->delete();
        $notification = array(
            'message'       => 'Style Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('style')->with($notification);
    }
    public function style_id(Request $request){
        $style = Style::find($request->style_id);
        return $style;
    }
}
