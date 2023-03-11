<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Country;
use App\Http\Controllers\Controller;
use App\ItemList;
use App\Models\AccountHead;
use Illuminate\Http\Request;
use League\CommonMark\Block\Element\ListItem;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('id', 'asc')->paginate(15);
        $countries = Country::all();
        return view('backend.brand.index', compact('brands', 'countries'));
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
            'brand_id' => 'required|unique:brands',
            'name' => 'required|unique:brands',
            'origin' => 'required',
        ]);
        Brand::create([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'origin'=> $request->origin
        ]);
        $notification= array(
            'message'       => 'Brand Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('brand')->with($notification);
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
        $brand_info = Brand::find($id);
        $countries = Country::all();
        $brands = Brand::orderBy('id', 'asc')->paginate(15);
        return view('backend.brand.edit', compact('brands', 'brand_info', 'countries'));
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
            'brand_id' => 'required',
            'name' => 'required',
            'origin' => 'required',
        ]);
        $brand = Brand::find($id);
        $brand->brand_id = $request->brand_id;
        $brand->name = $request->name;
        $brand->origin = $request->origin;
        $brand->save();
        $notification= array(
            'message'       => 'Brand updated successfully!',
            'alert-type'    => 'success'
        );
        return redirect('brand')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $search = ItemList::where('brand_id', $id)->count();
        if ($search > 0) {
            return back()->with('error', "It has Related with Item Table");
        }
        $brand = Brand::find($id);
        $brand->delete();
        $notification= array(
            'message'       => 'Brand Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('brand')->with($notification);
    }
}
