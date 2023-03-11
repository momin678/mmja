<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\ProfitCenter;
use Illuminate\Http\Request;

class ProfitCenterController extends Controller
{
    public function profitCenterDetails()
    {
        $profitDetails = ProfitCenter::where('activity', '!=', 'Draft')->latest()->paginate(25);
        $profitDetailsPrint = ProfitCenter::where('activity', '!=', 'Draft')->latest()->get();
        return view('backend.profitCenter.profitCenterDetails', compact('profitDetails','profitDetailsPrint'));
    }

    public function profitCenterPost(Request $request)
    {
        $request->validate([
            'pc_name' => 'required',
            'activity'  => 'required',
            'prsn_responsible' => 'required',

        ],
        [
            'pc_name.required' => 'Profit Center is required',
            'activity.required' => 'Activity is required',
            'prsn_responsible.required' => 'Person responsible is required',
        ]

    );

            $latest = ProfitCenter::withTrashed()->latest()->first();

            if ($latest) {
                $pc_code=preg_replace('/^PC-/', '', $latest->pc_code );
                ++$pc_code;
            } else {
                $pc_code = 1;
            }
            if($pc_code<10)
            {
                $p_code="PC-000".$pc_code;
            }
            elseif($pc_code<100)
            {
                $p_code="PC-00".$pc_code;
            }
            elseif($pc_code<1000)
            {
                $p_code="PC-0".$pc_code;
            }
            else
            {
                $p_code="PC-".$pc_code;
            }


            $draftProfit = new ProfitCenter();
            $draftProfit->pc_code = $p_code;
        $draftProfit->pc_name = $request->pc_name;
        $draftProfit->activity = $request->activity;
        $draftProfit->prsn_responsible = $request->prsn_responsible;
        $sv=$draftProfit->save();


        return redirect()->route('profitCenterDetails')->with('success', 'Added Successfully');
    }


    public function profitCenEdit($profitCenter)
    {
        $profitCenter=ProfitCenter::find($profitCenter);
        if(!$profitCenter)
        {
            return back()->with('error', "Not Found");

        }
        $profitDetails = ProfitCenter::where('activity', '!=', 'Draft')->latest()->paginate(25);
        return view('backend.profitCenter.profitCenterDetailsEdit', compact('profitDetails','profitCenter'));
    }

    public function profitCentersUpdate(Request $request,$profitCenter)
    {
        $request->validate([
            'pc_name' => 'required',
            'activity'  => 'required',
            'prsn_responsible' => 'required',

        ],
        [
            'pc_name.required' => 'Profit Center is required',
            'activity.required' => 'Activity is required',
            'prsn_responsible.required' => 'Person responsible is required',
        ]

    );

    $profitCenter=ProfitCenter::find($profitCenter);
        if(!$profitCenter)
        {
            return back()->with('error', "Not Found");

        }
        $profitCenter->pc_name = $request->pc_name;
        $profitCenter->activity = $request->activity;
        $profitCenter->prsn_responsible = $request->prsn_responsible;
        $profitCenter->save();
        return back()->with('success', 'Updated Successfully');

    }


    public function profitCenDelete($profitCenter)
    {
        $profitCenter=ProfitCenter::find($profitCenter);
        if(!$profitCenter)
        {
            return back()->with('error', "Not Found");

        }
        $count=$profitCenter->projects($profitCenter->pc_code)->count();
        // dd($count);
        if($count>0)
        {
            return back()->with('error', "It has Branch");

        }
        $profitCenter->forceDelete();
        return redirect()->route('profitCenterDetails')->with('success', "Deleted Successfully");
    }



    public function profitCenterForm(Request $request)
    {
        $latest = ProfitCenter::withTrashed()->latest()->first();

        if ($latest) {
            $pc_code=preg_replace('/^PC-/', '', $latest->pc_code );
            ++$pc_code;
        } else {
            $pc_code = 1;
        }
        if($pc_code<10)
        {
            $p_code="PC-000".$pc_code;
        }
        elseif($pc_code<100)
        {
            $p_code="PC-00".$pc_code;
        }
        elseif($pc_code<1000)
        {
            $p_code="PC-0".$pc_code;
        }
        else
        {
            $p_code="PC-".$pc_code;
        }

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.form.profitCenterForm', ['pc' => $p_code,])->render()]);
        }

    }



}
