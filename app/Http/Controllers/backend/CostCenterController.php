<?php

namespace App\Http\Controllers\backend;

use App\CostCenterType;
use App\Http\Controllers\Controller;
use App\Models\CostCenter;
use App\ProjectDetail;
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    public function costCenterDetails()
    {
        $latest = CostCenter::withTrashed()->latest()->first();

        if ($latest) {
            $cc_code=preg_replace('/^CC-/', '', $latest->cc_code );
            ++$cc_code;
        } else {
            $cc_code = 1;
        }
        if($cc_code<10)
        {
            $cc="CC-000".$cc_code;
        }
        elseif($cc_code<100)
        {
            $cc="CC-00".$cc_code;
        }
        elseif($cc_code<1000)
        {
            $cc="CC-0".$cc_code;
        }
        else
        {
            $cc="CC-".$cc_code;
        }
        $costCenterDetails = CostCenter::where('activity', '!=', 'Draft')->latest()->paginate(25);
        $costCenterDetailsPDF = CostCenter::where('activity', '!=', 'Draft')->latest()->get();
        $projects=ProjectDetail::all();
        return view('backend.costCenter.costCenterDetails', compact('costCenterDetails','projects','cc','costCenterDetailsPDF'));
    }

    public function costCenterPost(Request $request)
    {
        $request->validate([
            'cc_name' => 'required',
            'activity'  => 'required',
            'prsn_responsible' => 'required',
            'project_id' => 'required',
        ],
        [
            'cc_name.required' => 'Profit Center is required',
            'activity.required' => 'Activity is required',
            'prsn_responsible.required' => 'Person responsible is required',
            'project_id' => 'Select Project'
        ]
    );
        $latest = CostCenter::withTrashed()->latest()->first();
        if ($latest) {
            $cc_code=preg_replace('/^CC-/', '', $latest->cc_code );
            ++$cc_code;
        } else {
            $cc_code = 1;
        }
        if($cc_code<10)
        {
            $c_code="CC-000".$cc_code;
        }
        elseif($cc_code<100)
        {
            $c_code="CC-00".$cc_code;
        }
        elseif($cc_code<1000)
        {
            $c_code="CC-0".$cc_code;
        }
        else
        {
            $c_code="CC-".$cc_code;
        }
        $draftProfit = new CostCenter();
        $draftProfit->cc_code = $c_code;
        $draftProfit->cc_name = $request->cc_name;
        $draftProfit->activity = $request->activity;
        $draftProfit->prsn_responsible = $request->prsn_responsible;
        $draftProfit->project_id = $request->project_id;
        $sv=$draftProfit->save();
        return redirect()->route('costCenterDetails')->with('success', 'Added Successfully');
    }


    public function costCenEdit($costCenter)
    {
        $costCenter=CostCenter::find($costCenter);
        if(!$costCenter)
        {
            return back()->with('error', "Not Found");
        }
        $costTypes=CostCenterType::get();
        $costCenterDetails = CostCenter::latest()->paginate(25);
        $projects=ProjectDetail::all();
        return view('backend.costCenter.costCenterDetailsEdit', compact('costCenter', 'costCenterDetails','costTypes','projects'));
    }

    public function costCentersUpdate(Request $request, $costCenter)
    {
        $request->validate([
            'cc_name' => 'required',
            'activity'  => 'required',
            'prsn_responsible' => 'required',
            'project_id' => 'required',
        ],
        [
            'cc_name.required' => 'Profit Center is required',
            'activity.required' => 'Activity is required',
            'prsn_responsible.required' => 'Person responsible is required',
            'project_id' => 'Select Project'
        ]
    );
        $costCenter=CostCenter::find($costCenter);
        if(!$costCenter)
        {
            return back()->with('error', "Not Found");
        }
        $costCenter->cc_name = $request->cc_name;
        $costCenter->activity = $request->activity;
        $costCenter->prsn_responsible = $request->prsn_responsible;
        $costCenter->project_id = $request->project_id;
        $sv=$costCenter->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function costCenDelete($costCenter)
    {
        $costCenter=CostCenter::find($costCenter);
        if(!$costCenter)
        {
            return back()->with('error', "Not Found");
        }
        if($costCenter->journals()->count()>0)
            {
                return back()->with('error','It has journals entry');
            }
        $costCenter->forceDelete();
        return redirect()->route('costCenterDetails')->with('success', "Deleted Successfully");
    }

    public function costCenterForm(Request $request)
    {
        $latest = CostCenter::withTrashed()->latest()->first();

        if ($latest) {
            $cc_code=preg_replace('/^CC-/', '', $latest->cc_code );
            ++$cc_code;
        } else {
            $cc_code = 1;
        }
        if($cc_code<10)
        {
            $c_code="CC-000".$cc_code;
        }
        elseif($cc_code<100)
        {
            $c_code="CC-00".$cc_code;
        }
        elseif($cc_code<1000)
        {
            $c_code="CC-0".$cc_code;
        }
        else
        {
            $c_code="CC-".$cc_code;
        }


            $projects=ProjectDetail::all();


        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.form.costCenterForm', ['cc' => $c_code,'projects' => $projects])->render()]);
        }

    }
}
