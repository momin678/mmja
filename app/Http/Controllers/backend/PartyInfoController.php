<?php

namespace App\Http\Controllers\backend;

use App\CostCenterType;
use App\Http\Controllers\Controller;
use App\PartyInfo;
use Illuminate\Http\Request;

class PartyInfoController extends Controller
{
    public function partyInfoDetails()
    {
        $latest = PartyInfo::withTrashed()->orderBy('id','DESC')->first();

        if ($latest) {
            $pi_code=preg_replace('/^PI-/', '', $latest->pi_code );
            ++$pi_code;
        } else {
            $pi_code = 1;
        }
        if($pi_code<10)
        {
            $cc="PI-000".$pi_code;
        }
        elseif($pi_code<100)
        {
            $cc="PI-00".$pi_code;
        }
        elseif($pi_code<1000)
        {
            $cc="PI-0".$pi_code;
        }
        else
        {
            $cc="PI-".$pi_code;
        }
        $costTypes=CostCenterType::get();
        $partyInfos = PartyInfo::where('pi_type','!=', "Draft")->orderBy('id','DESC')->paginate(25);
        $partyInfosPDF = PartyInfo::where('pi_type','!=', "Draft")->orderBy('id','DESC')->get();
        return view('backend.partyInfo.partyCenterDetails', compact('partyInfos','costTypes','cc','partyInfosPDF'));
    }

    public function partyInfoPost(Request $request)
    {
        $request->validate([
            'pi_name' => 'required',
            'pi_type'        => 'required',

        ],
        [
            'pi_name.required' => 'Cost Center is required',
            'pi_type.required' => 'Type is required',
        ]
    );

            $latest = PartyInfo::withTrashed()->orderBy('id','DESC')->first();

            if ($latest) {
                $pi_code=preg_replace('/^PI-/', '', $latest->pi_code );
                ++$pi_code;
            } else {
                $pi_code = 1;
            }
            if($pi_code<10)
            {
                $c_code="PI-000".$pi_code;
            }
            elseif($pi_code<100)
            {
                $c_code="PI-00".$pi_code;
            }
            elseif($pi_code<1000)
            {
                $c_code="PI-0".$pi_code;
            }
            else
            {
                $c_code="PI-".$pi_code;
            }

            $draftCost = new PartyInfo();
            $draftCost->pi_code = $c_code;
        $draftCost->pi_name = $request->pi_name;
        $draftCost->pi_type = $request->pi_type;
        $draftCost->trn_no = $request->trn_no;
        $draftCost->address = $request->address;
        $draftCost->con_person = $request->con_person;
        $draftCost->con_no = $request->con_no;
        $draftCost->phone_no = $request->phone_no;
        $draftCost->email = $request->email;
        if($request->credit_limit){
            $draftCost->credit_limit = $request->credit_limit;
        }else{
            $draftCost->credit_limit = 0;
        }
        $sv=$draftCost->save();

        return redirect()->route('partyInfoDetails')->with('success', 'Added Successfully');
    }


    public function partyInfoEdit($pInfo)
    {
        $partyInfo=PartyInfo::find($pInfo);
        if(!$partyInfo)
        {
            return back()->with('error', "Not Found");

        }
        $costTypes=CostCenterType::get();

        $partyInfos = PartyInfo::where('pi_type','!=', "Draft")->orderBy('id','DESC')->paginate(25);
        $partyInfosPDF = PartyInfo::where('pi_type','!=', "Draft")->orderBy('id','DESC')->get();
        return view('backend.partyInfo.partyCenterDetailsEdit', compact('partyInfos', 'partyInfo','costTypes','partyInfosPDF'));
    }

    public function partyInfoUpdate(Request $request, $costCenter)
    {
        $request->validate([
            'pi_name' => 'required',
            'pi_type'        => 'required',

        ],
        [
            'pi_name.required' => 'Cost Center is required',
            'pi_type.required' => 'Type is required',
        ]
    );

    $partyInfo=PartyInfo::find($costCenter);
        if(!$partyInfo)
        {
            return back()->with('error', "Not Found");

        }
        $partyInfo->pi_name = $request->pi_name;
        $partyInfo->pi_type = $request->pi_type;
        $partyInfo->trn_no = $request->trn_no;
        $partyInfo->address = $request->address;
        $partyInfo->con_person = $request->con_person;
        $partyInfo->con_no = $request->con_no;
        $partyInfo->phone_no = $request->phone_no;
        $partyInfo->email = $request->email;
        if($request->credit_limit){
            $partyInfo->credit_limit = $request->credit_limit;
        }else{
            $partyInfo->credit_limit = 0;
        }
        $partyInfo->save();
        return back()->with('success', 'Updated Successfully');
    }


    public function partyInfoDelete($pInfo)
    {
        $partyInfo=PartyInfo::find($pInfo);
        if(!$partyInfo)
        {
            return back()->with('error', "Not Found");

        }

        if($partyInfo->journals()->count()>0)
        {
            return back()->with('error','It has journals entry');
        }
        $partyInfo->forceDelete();
        return redirect()->route('partyInfoDetails')->with('success', "Deleted Successfully");
    }



    public function partyInfoForm(Request $request)
    {
        $latest = PartyInfo::withTrashed()->orderBy('id','DESC')->first();

        if ($latest) {
            $pi_code=preg_replace('/^PI-/', '', $latest->pi_code );
            ++$pi_code;
        } else {
            $pi_code = 1;
        }
        if($pi_code<10)
        {
            $c_code="PI-000".$pi_code;
        }
        elseif($pi_code<100)
        {
            $c_code="PI-00".$pi_code;
        }
        elseif($pi_code<1000)
        {
            $c_code="PI-0".$pi_code;
        }
        else
        {
            $c_code="PI-".$pi_code;
        }
        $costTypes=CostCenterType::get();


        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.form.partyInfoForm', ['cc' => $c_code,'costTypes' => $costTypes,])->render()]);
        }
    }

    public function partyView($pInfo)
    {
        $pInfo=PartyInfo::find($pInfo);
        if(!$pInfo)
        {
            return back()->with('error', "Not Found");
        }
        return view('backend.partyInfo.partyCenterView', compact('pInfo'));

    }

    // work by mominul
    public function party_center_preview(Request $request){
        $pInfo=PartyInfo::find($request->id);
        if(!$pInfo)
        {
            return back()->with('error', "Not Found");
        }
        return view('backend.partyInfo.party-center-view', compact('pInfo'));
    }
    public function get_party_info(Request $request, $id){
        $pInfo=PartyInfo::find($id);
        // return view('backend.partyInfo.party-center-view-pdf', compact('pInfo'));
        $pdf = PDF::loadView('backend.partyInfo.party-center-view-pdf', compact('pInfo'));
        return $pdf->download('profile-'.$pInfo->pi_name.'.pdf');
    }

}
