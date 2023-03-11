<?php

namespace App\Http\Controllers\backend;

use App\Brand;
use App\Expense;
use App\Http\Controllers\Controller;
use App\Models\AccountHead;
use App\Models\MasterAccount;
use App\PartyInfo;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function business_summary_report(){
        $brands=Brand::latest()->get();
        return view('backend.business-summary-report.summary-report', compact('brands'));
    }

    public function business_summary_report_print(){
        return view('backend.business-summary-report.business-summary-print');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expenses= Expense::paginate(15);
        
        $master_accounts=MasterAccount::all();
        $parties= PartyInfo::whereIn('pi_type', ['Supplier','Employee','Government Body'])->get();
        return view('backend.expense.create', compact('master_accounts', 'parties','expenses'));
    }

    public function get_account_heads(Request $request){
        $account_head= AccountHead::where('ma_code', $request->ac_code)->get();
        return response()->json($account_head);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
                'master_acount'     => 'required',
                'account_head'      => 'required',
                'party_name'        => 'required',
                'date'     => 'required',
                'taxable_amount'    => 'required',
                'vat_amount'        => 'required',
                'total_amount'      => 'required',
                'voucher_copy'      => 'required',
                'voucher_copy.*'    => 'mimes:doc,pdf,docx,jpg,png,jpeg'
        ]);

            
        $name= $request->voucher_copy->getClientOriginalName();
        $name = pathinfo($name, PATHINFO_FILENAME);
        $ext= $request->voucher_copy->getClientOriginalExtension();
        $voucher_file_name= $name.time().'.'.$ext;
        
        $file_transfer= $request->voucher_copy->storeAs( 'public/upload/expense_voucher', $voucher_file_name);

        if($file_transfer){
            $expense= new Expense();
            $expense->master_acount_id      = $request->master_acount;
            $expense->account_head_id       = $request->account_head;
            $expense->party_info_id         = $request->party_name;
            $expense->taxable_amount        = $request->taxable_amount;
            $expense->vat_amount            = $request->vat_amount;
            $expense->total_amount          = $request->total_amount;
            $expense->date                  = $request->date;
            $expense->voucher_copy          = $voucher_file_name;
            $expense->status                =1;
            $expense->save();

        }

        

        $notification= array(
            'message'       => 'Expense saved successfully!',
            'alert-type'    => 'success'
        );

        return redirect('expense/create')->with($notification);
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
        $edit_expense= Expense::find($id);
        $expenses= Expense::paginate(15);
        $account_heads= AccountHead::where('ma_code', $edit_expense->master_acount_id)->get();
        $master_accounts=MasterAccount::all();
        $parties= PartyInfo::where('pi_type', 'Supplier')->get();
        return view('backend.expense.edit', compact('master_accounts', 'parties','expenses','edit_expense','account_heads'));
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
        //
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
