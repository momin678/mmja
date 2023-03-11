<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function bankDetails()
    {
        $latest = BankDetail::withTrashed()->latest()->first();

        if($latest)
        {
            $cc=$latest->bank_code+1;
        }
        else
        {
            $cc=100;
        }
        $bankDetails=BankDetail::latest()->paginate(25);
        return view('backend.bank.bankDetails',compact('bankDetails','cc'));
    }

    public function bankDetailsPost(Request $request)
    {
        // return $request;

        $request->validate([
            // 'proj_no' => 'required',
            'bank_name'        => 'required',
            'branch'        => 'required',
            'ac_no'         =>  'required',
            'signatory'         =>  'required',
            'bank_iban'         =>  'required',


        ],
        [
            'bank_name.required' => 'Bank Name is required',
            'branch.required' => 'Branch is required',
            'ac_no.required' => 'Account Number is required',
            'signatory.required' => 'Signatory is required',
            'bank_iban.required' => 'IBAN is required',

        ]
    );


       $latest=BankDetail::withTrashed()->latest()->first();
       if($latest)
       {
           $cc=$latest->bank_code+1;
       }
       else
       {
           $cc=100;
       }

        $bankDetails=new BankDetail;
        $bankDetails->bank_code=$cc;
        $bankDetails->bank_name=$request->bank_name;

        $bankDetails->branch=$request->branch;

        $bankDetails->ac_no=$request->ac_no;

        $bankDetails->signatory=$request->signatory;
        $bankDetails->iban=$request->bank_iban;


        $bankDetails->save();
        return redirect()->route('bankDetails')->with('success','Added Successfully');
    }


    public function bankEdit($bank)
    {
        $bank=BankDetail::find($bank);
        if(!$bank)
        {
            return back()->with('error', "Not Found");
        }

        $bankDetails=BankDetail::latest()->paginate(25);

        return view('backend.bank.bankDetailsedit',compact('bankDetails','bank'));
    }

    public function bankDetailsUpdate($bank, Request $request)
    {
        // return $request;

        $request->validate([
            // 'proj_no' => 'required',
            'bank_name'        => 'required',
            'branch'        => 'required',
            'ac_no'         =>  'required',
            'signatory'         =>  'required',


        ],
        [
            'bank_name.required' => 'Bank Name is required',
            'branch.required' => 'Branch is required',
            'ac_no.required' => 'Account Number is required',
            'signatory.required' => 'Signatory is required',

        ]
    );

        $bank=BankDetail::find($bank);
        if(!$bank)
        {
            return back()->with('error', "Not Found");
        }

        $bank->bank_name=$request->bank_name;

        $bank->branch=$request->branch;

        $bank->ac_no=$request->ac_no;

        $bank->signatory=$request->signatory;
        $bank->iban=$request->bank_iban;


        $bank->save();
        return redirect()->route('bankDetails')->with('success','Updated Successfully');
    }

    public function bankDelete ($bank)
    {


        $bank=BankDetail::find($bank);
        if(!$bank)
        {
            return back()->with('error', "Not Found");
        }
       $bank->forceDelete();
       return redirect()->route('bankDetails')->with('success', "Deleted Successfully");
    }



    public function bankForm(Request $request)
    {
        $latest = BankDetail::withTrashed()->latest()->first();

        if($latest)
        {
            $cc=$latest->bank_code+1;
        }
        else
        {
            $cc=100;
        }


        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.form.bankForm', ['cc' => $cc,])->render()]);
        }

    }


    public function bank_lint_print(Request $request){
        $bankDetails = BankDetail::latest()->get();
        return view('backend/pdf/bankDetailsPdf', compact('bankDetails'));
    }


}
