<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Journal;
use App\Models\AccountHead;
use App\Models\CostCenter;
use App\PartyInfo;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\TxnType;
use App\VatRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class JournalEntryController extends Controller
{
    public function journalEntry()
    {
        Gate::authorize('app.journal_entry');
        $projects = ProjectDetail::all();
        $modes = PayMode::all();
        $terms = PayTerm::all();
        $sub_invoice = Carbon::now()->format('Ymd');
        $cCenters = CostCenter::all();
        $txnTypes = TxnType::all();
        $acHeads = AccountHead::all();
        $pInfos = PartyInfo::all();
        $vats = VatRate::all();
        $journals=Journal::latest()->paginate(50);
        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest()->first();
        // dd($latest_invoice_no);
        if ($latest_journal_no) {
            // $journal_no = preg_replace('/^j/', '', $latest_journal_no->journal_no);
            $journal_no = substr($latest_journal_no->journal_no,0,-1);

            // dd($journal_no);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }

        return view('backend.journal.journalEntry', compact('projects', 'journal_no', 'modes', 'terms', 'cCenters', 'txnTypes', 'acHeads', 'vats', 'pInfos','journals'));
    }

    public function findProject(Request $request)
    {
        $project = ProjectDetail::where('id', $request->value)->first();
        return $project;
    }


    public function findCostCenter(Request $request)
    {
        $cc = CostCenter::where('cc_code', $request->value)->first();
        return $cc;
    }

    public function findCostCenterId(Request $request)
    {
        $cc_id = CostCenter::where('id', $request->value)->first();
        return $cc_id;
    }

    public function partyInfoInvoice2(Request $request)
    {
        // return $request->all();
        $info = PartyInfo::where('id', $request->value)->first();
        return $info;
    }

    public function findAccHead(Request $request)
    {
        $accHead = AccountHead::where('fld_ac_code', $request->value)->first();
        return $accHead;
    }

    public function findAccHeadId(Request $request)
    {
        $accHeadId = AccountHead::where('id', $request->value)->first();
        return $accHeadId;
    }


    public function findTaxRate(Request $request)
    {
        if($request->value!=null)
        {
            $vat = VatRate::where('id', $request->value)->first();
        $vatRate = 100 - $vat->value;
        $total_amount = $request->amount / 100 * $vatRate;
        $vat_amount = $request->amount / 100 * $vat->value;
        }
        else
        {
            $total_amount = $request->amount;
            $vat_amount = 0;
        }

        if ($request->ajax()) {
            return Response()->json([
                'vat_amount' => $vat_amount,
                'total_amount' => $total_amount,
            ]);
        }
        // return $vat_amount;
    }


    public function findamount(Request $request)
    {
        // return $request->all();

        if( $request->tax_rate!==null)
        {
        $vat = VatRate::where('id', $request->tax_rate)->first();
        $vatRate = 100 - $vat->value;
        $total_amount = $request->amount / 100 * $vatRate;
        $vat_amount = $request->amount / 100 * $vat->value;
      }
      else
      {
        $total_amount = $request->amount;
        $vat_amount =  0;
      }

      if ($request->ajax()) {
        return Response()->json([
            'vat_amount' => $vat_amount,
            'total_amount' => $total_amount,
        ]);
    }
        // return $vat_amount;
    }

    public function journalEntryPost(Request $request)
    {

        $request->validate(
            [
                'project'        => 'required',
                // 'owner'        => 'required',
                // 'location'         =>  'required',
                // 'mobile'         =>  'required',
                'journal_no'         =>  'required',
                'date'         =>  'required',
                'invoice_no'         =>  'required',
                'cc_code' => 'required',
                'party_info' => 'required',
                'txn_type' => 'required',
                'pay_mode' => 'required',
                'ac_code' => 'required',
                'acc_head' => 'required',
                'amount' => 'required',
                'tax_rate' => 'required',
                'narration' => 'required'
            ],
            [
                'project.required' => 'Project Name is required',
                // 'owner.required' => 'Owner is required',
                // 'location.required' => 'Location is required',
                // 'mobile.required' => 'Mobile is required',
                'journal_no.required' => 'Journal No is required',
                'date.required' => 'Date is required',
                'invoice_no.required' => 'nvoice No is required',
                'cc_code.required' => 'Cost Center is required',
                'party_info.required' => 'Party Info is required',
                'txn_type.required' => 'TXN Type is required',
                'pay_mode.required' => 'Pay Mode is required',
                'ac_code.required' => 'Account Code is required',
                'acc_head.required' => 'Account Head is required',
                'amount.required' => 'Amount is required',
                'tax_rate.required' => 'Tax Rate is required',
                'narration.required' => 'Narration is required',

            ]
        );

        // dd($request->all());
        $sub_invoice = Carbon::now()->format('Ymd');

        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest()->first();
        // dd($latest_invoice_no);
        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no,0,-1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }

        $journal=new Journal();
        $journal->project_id = $request->project;
        $journal->journal_no = $journal_no;
        $journal->date = $request->date;
        $journal->invoice_no = $request->invoice_no;
        $journal->cost_center_id = $request->cost_center_name;
        $journal->party_info_id = $request->party_info;
        $journal->txn_type = $request->txn_type;
        $journal->txn_mode = $request->pay_mode;
        $journal->ac_head_id = $request->acc_head;
        $journal->amount = $request->amount;
        $journal->tax_rate = $request->tax_rate;
        $journal->credit_party_info = $request->credit_party_info;
        $journal->vat_amount = $request->vat_amount;
        $journal->total_amount = $request->total_amount;
        $journal->narration = $request->narration;
        $journal->state = "Authorization";
        $save = $journal->save();
        return back()->with('success',"Successfully Added");
    }

    public function journalEntryEditPost(Request $request,$journal)
    {

        $request->validate(
            [
                'project'        => 'required',
                // 'owner'        => 'required',
                // 'location'         =>  'required',
                // 'mobile'         =>  'required',
                'journal_no'         =>  'required',
                'date'         =>  'required',
                'invoice_no'         =>  'required',
                'cc_code' => 'required',
                'party_info' => 'required',
                'txn_type' => 'required',
                'pay_mode' => 'required',
                'ac_code' => 'required',
                'acc_head' => 'required',
                'amount' => 'required',
                'tax_rate' => 'required',
                'narration' => 'required'
            ],
            [
                'project.required' => 'Project Name is required',
                // 'owner.required' => 'Owner is required',
                // 'location.required' => 'Location is required',
                // 'mobile.required' => 'Mobile is required',
                'journal_no.required' => 'Journal No is required',
                'date.required' => 'Date is required',
                'invoice_no.required' => 'nvoice No is required',
                'cc_code.required' => 'Cost Center is required',
                'party_info.required' => 'Party Info is required',
                'txn_type.required' => 'TXN Type is required',
                'pay_mode.required' => 'Pay Mode is required',
                'ac_code.required' => 'Account Code is required',
                'acc_head.required' => 'Account Head is required',
                'amount.required' => 'Amount is required',
                'tax_rate.required' => 'Tax Rate is required',
                'narration.required' => 'Narration is required',

            ]
        );


        $journal=Journal::find($journal);
        if(!$journal)
        {
            return back()->with('error', "Not Found");

        }
        // dd($request->credit_party_info);
        $journal->project_id = $request->project;
        $journal->date = $request->date;
        $journal->invoice_no = $request->invoice_no;
        $journal->cost_center_id = $request->cost_center_name;
        $journal->party_info_id = $request->party_info;
        $journal->txn_type = $request->txn_type;
        $journal->txn_mode = $request->pay_mode;
        $journal->ac_head_id = $request->acc_head;
        $journal->amount = $request->amount;
        $journal->tax_rate = $request->tax_rate;
        $journal->vat_amount = $request->vat_amount;
        $journal->total_amount = $request->total_amount;
        $journal->credit_party_info = $request->credit_party_info;
        $journal->narration = $request->narration;
        $journal->state = "Authorization";
        $journal->comment = null;
        $save = $journal->save();
        return back()->with('success',"Successfully Updated");
    }


    public function journalEdit($journal)
    {
        $journalF=Journal::find($journal);
        if(!$journalF)
        {
            return back()->with('error', "Not Found");

        }
        $projects = ProjectDetail::all();
        $modes = PayMode::all();
        $terms = PayTerm::all();
        $sub_invoice = Carbon::now()->format('Ymd');
        $cCenters = CostCenter::all();
        $txnTypes = TxnType::all();
        $acHeads = AccountHead::all();
        $pInfos = PartyInfo::all();
        $vats = VatRate::all();
        $journals=Journal::latest()->paginate(50);

        return view('backend.journal.journalEntry', compact('projects', 'journalF', 'modes', 'terms', 'cCenters', 'txnTypes', 'acHeads', 'vats', 'pInfos','journals'));
    }

    public function journalDelete($journal)
    {
        $journal=Journal::find($journal);
        if(!$journal)
        {
            return back()->with('error', "Not Found");
        }
        $journal->forceDelete();
        return redirect()->route('journalEntry')->with('success','Deleted Successfully');
    }

    public function journalAuthorize()
    {
        Gate::authorize('app.journal_authorize');
            $journals=Journal::where('authorized', false)->where('state', "Authorization")->paginate(25);
        return view('backend.journal.journalAuthorize', compact('journals'));

    }

    public function journalView($journal)
    {
        $journal=Journal::find($journal);
        if(!$journal)
        {
            return back()->with('error', "Not Found");
        }
       return view('backend.journal.journalView', compact('journal'));
    }

    public function journalMakeAuthorize($journal)
    {
        $journal=Journal::find($journal);
        if(!$journal)
        {
            return back()->with('error', "Not Found");
        }
        $journal->authorized=true;
        $journal->state='Approval';
        $journal->comment = null;
        $journal->checked=false;
        $journal->save();
        return redirect()->route('journalAuthorize')->with('success','Successfully Authorized');
    }

    public function journaAuthDecline(Request $request, $journal)
    {
        $journal=Journal::find($journal);
        if(!$journal)
        {
            return back()->with('error', "Not Found");
        }
        $journal->state='Entry';
        $journal->comment=$request->comment;
        $journal->checked=false;
        $journal->save();
        return redirect()->route('journalAuthorize')->with('success','Authorization Decline');
    }


    public function journalApproval()
    {
        Gate::authorize('app.journal_approval');
        $journals=Journal::where('authorized', true)->where('approved', false)->where('state', "Approval")->paginate(25);
        return view('backend.journal.journalAuthorize', compact('journals'));
    }


    public function journalMakeApprove($journal)
    {
        $journal=Journal::find($journal);
        if(!$journal)
        {
            return back()->with('error', "Not Found");
        }
        $journal->approved=true;
        $journal->state='done';
        $journal->comment = null;
        $journal->save();
        return redirect()->route('journalApproval')->with('success','Approved Successfully');
    }

    public function journaApproveDecline(Request $request, $journal)
    {
        $journal=Journal::find($journal);
        if(!$journal)
        {
            return back()->with('error', "Not Found");
        }
        $journal->state='Entry';
        $journal->comment=$request->comment;
        $journal->authorized=false;
        $journal->checked=false;
        $journal->save();
        return redirect()->route('journalApproval')->with('success','Approval Declinedssss');
    }
}
