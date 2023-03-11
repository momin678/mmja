<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\ProfitCenter;
use App\ProjectDetail;
use App\ProjectDetailsType;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function projectDetails()
    {
        // dd(1);
        $profit_centers=ProfitCenter::get();
        $projectTypes=ProjectDetailsType::get();
        $projDetails=ProjectDetail::where('proj_type','!=',"Draft")->latest()->paginate(25);
        return view('backend.project.projectDetails',compact('projDetails','projectTypes','profit_centers'));
    }

    public function projectDetailsPost(Request $request)
    {
        $request->validate([
            // 'proj_no' => 'required',
            'proj_name'        => 'required',
            'proj_type'        => 'required',
            'cont_no'         =>  'required',
            'cons_agent'         =>  'required',
            'address'         =>  'required',
            'owner_name'         =>  'required',
            'ord_date'         =>  'required',
            'hnd_over_date' => 'required',
            'profit_pc_code' => 'required'

        ],
        [
            'proj_name.required' => 'Project Name is required',
            'proj_type.required' => 'Project Type is required',
            'cont_no.required' => 'Phone Number is required',
            'cons_agent.required' => 'Consulting Agent is required',
            'address.required' => 'Site Location is required',
            'owner_name.required' => 'Owner Name is required',
            'ord_date.required' => 'Order Date is required',
            'hnd_over_date.required' => 'Handover Date is required',
            'profit_pc_code.required' => 'Select Profit Center',
        ]
    );

        // $profDraft=ProjectDetail::where('proj_type','Draft')->latest()->first();



            $latest = ProjectDetail::withTrashed()->latest()->first();

            $profDraft = new ProjectDetail();
            if ($latest) {
                $profDraft->code = $latest->code + 1;
            } else {
                $profDraft->code = 1;
            }

            if($profDraft->code<10)
            {
                $profDraft->proj_no="PN-00".$profDraft->code;
            }

            elseif($profDraft->code<100)
            {
                $profDraft->proj_no="PN-0".$profDraft->code;
            }

            else
            {
                $profDraft->proj_no="PN-".$profDraft->code;
            }



        $profDraft->proj_name=$request->proj_name;

        $profDraft->proj_type=$request->proj_type;

        $profDraft->cons_agent=$request->cons_agent;

        $profDraft->address=$request->address;

        $profDraft->owner_name=$request->owner_name;

        $profDraft->cont_no=$request->cont_no;

        $profDraft->ord_date=$request->ord_date;

        $profDraft->hnd_over_date=$request->hnd_over_date;
        $profDraft->pc_code=$request->profit_pc_code;

        $save=$profDraft->save();


        return redirect()->route('projectDetails')->with('success','Added Successfully');
    }

    public function projectEdit($proj)
    {

        $proj=ProjectDetail::find($proj);
        if(!$proj)
        {
            return back()->with('error', "Not Found");
        }
        $profit_centers=ProfitCenter::get();

        $projectTypes=ProjectDetailsType::get();
        $projDetails=ProjectDetail::where('proj_type','!=',"Draft")->latest()->paginate(25);

        return view('backend.project.projectDetailsEdit',compact('projDetails','proj','projectTypes','profit_centers'));
    }

    public function projectDetailsUpdate($proj, Request $request)
    {

        $request->validate([
            // 'proj_no' => 'required',
            'proj_name'        => 'required',
            'proj_type'        => 'required',
            'cont_no'         =>  'required',
            'cons_agent'         =>  'required',
            'address'         =>  'required',
            'owner_name'         =>  'required',
            'ord_date'         =>  'required',
            'hnd_over_date' => 'required',
            'profit_pc_code' => 'required'


        ],
        [
            'proj_name.required' => 'Project Name is required',
            'proj_type.required' => 'Project Type is required',
            'cont_no.required' => 'Phone Number is required',
            'cons_agent.required' => 'Consulting Agent is required',
            'address.required' => 'Site Location is required',
            'owner_name.required' => 'Owner Name is required',
            'ord_date.required' => 'Order Date is required',
            'hnd_over_date.required' => 'Handover Date is required',
            'profit_pc_code.required' => 'Select Profit Center',

        ]
    );

        $proj=ProjectDetail::find($proj);
        if(!$proj)
        {
            return back()->with('error', "Not Found");
        }

        $proj->proj_name=$request->proj_name;

        $proj->proj_type=$request->proj_type;

        $proj->cons_agent=$request->cons_agent;

        $proj->address=$request->address;

        $proj->owner_name=$request->owner_name;

        $proj->cont_no=$request->cont_no;

        $proj->ord_date=$request->ord_date;

        $proj->hnd_over_date=$request->hnd_over_date;
        $proj->pc_code=$request->profit_pc_code;

        $proj->save();
        return back()->with('success','Updated Successfully');

    }


    public function projectDelete($proj)
    {
        $proj=ProjectDetail::find($proj);
        if(!$proj)
        {
            return back()->with('error', "Not Found");
        }
// dd(1);
        $proj->delete();
        return redirect()->route('projectDetails')->with('success', "Deleted Successfully");
    }


    public function projectForm(Request $request)
    {
        $latest = ProjectDetail::withTrashed()->latest()->first();

        if ($latest) {
            $code = $latest->code + 1;
        } else {
            $code = 1;
        }

        if($code<10)
        {
            $p_code="PN-00".$code;
        }

        elseif($code<100)
        {
            $p_code="PN-0".$code;
        }

        else
        {
            $p_code="PN-".$code;
        }

        $projectTypes=ProjectDetailsType::get();
        $profit_centers=ProfitCenter::get();

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.form.projectForm', ['p_code' => $p_code,'projectTypes' => $projectTypes, 'profit_centers'=>$profit_centers])->render()]);
        }

    }
}
