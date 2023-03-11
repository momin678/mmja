<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\AccHead;
use App\Models\AccountHead;
use App\Models\MasterAccount;
use App\Models\MstACType;
use App\Models\MstDefinition;
use App\MstCatType;
use App\VatType;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;

class MasterAccountController extends Controller
{
    public function masteAccDetails()
    {
        // dd(1);

        $vat_types = VatType::get();
        $mstAccType = MstACType::get();
        $categories=MstCatType::get();
        $mst_definitions = MstDefinition::get();
        $masterDetails = MasterAccount::where('mst_ac_type', '!=', 'Draft')->latest()->paginate(25);
        return view('backend.masterAccount.masteAccDetails', compact('masterDetails', 'mst_definitions', 'mstAccType', 'vat_types','categories'));
    }

    public function MasterDetailsPost(Request $request)
    {
        // return $request;
        $request->validate(
            [
                'mst_ac_head' => 'required',
                'mst_definition'        => 'required',
                'mst_ac_type'        => 'required',
                'vat_type'         =>  'required',
            ],
            [
                'mst_ac_head.required' => 'Master Account Head is required',
                'mst_definition.required' => 'Definition is required',
                'mst_ac_type.required' => 'Account Type is required',
                'vat_type.required' => 'Vat Type is required',

            ]
        );

        $typeCat = MstACType::where('id', $request->mst_ac_type)->first();
        $cat = MstCatType::where('id', $request->category)->latest()->first();

        $latest_master = MasterAccount::withTrashed()->whereBetween('mst_ac_code', [$cat->value, $cat->value + 99])->latest()->first();
        if ($latest_master) {
            if ($latest_master->mst_ac_code >= $cat->value + 99) {
                return back()->with('error', 'No Place to Store');
            }
        }

        $masterAcc = new MasterAccount;
        if ($latest_master) {
            $masterAcc->mst_ac_code = $latest_master->mst_ac_code + 1;
        } else {
            $masterAcc->mst_ac_code = $cat->value;
        }

        $reserved= ($request->category) ==5 ? 1 : 0;

        $masterAcc->mst_ac_head     = $request->mst_ac_head;
        $masterAcc->account_type_id = $request->category;
        $masterAcc->mst_definition  = $request->mst_definition;
        $masterAcc->mst_ac_type     = $request->mst_ac_type;
        $masterAcc->vat_type        = $request->vat_type;
        $masterAcc->reserved        = $reserved;
        $masterAcc->category_id     = $request->category;
        

        $masterAS = $masterAcc->save();



        return back()->with('success', 'Added Successfully');
    }

    public function masterEdit($masterAcc)
    {

        $masterAcc = MasterAccount::find($masterAcc);
        if (!$masterAcc) {
            return back()->with('error', "Not Found");
        }
        $vat_types = VatType::get();
        $categories=MstCatType::get();

        $mstAccType = MstACType::get();
        $mst_definitions = MstDefinition::get();
        $masterDetails = MasterAccount::where('mst_ac_type', '!=', 'Draft')->latest()->paginate(25);
        $master_details = MasterAccount::latest()->get();
        $masterDetailsPDF = MasterAccount::where('mst_ac_code', '!=', 'Draft')->latest()->get();
        return view('backend.masterAccount.chart-of-account', compact('vat_types', 'mstAccType', 'categories', 'mst_definitions', 'masterDetails', 'master_details', 'masterAcc', 'masterDetailsPDF'));
        // return view('backend.masterAccount.masteAccDetails', compact('masterDetails','categories', 'masterAcc', 'mst_definitions', 'mstAccType', 'vat_types'));
    }
    public function masterDetailsUpdate($masterAcc, Request $request)
    {
        $request->validate(
            [
                'mst_ac_head' => 'required',
                'mst_definition'        => 'required',
                // 'mst_ac_type'        => 'required',
                'vat_type'         =>  'required',
            ],
            [
                'mst_ac_head.required' => 'Master Account Head is required',
                'mst_definition.required' => 'Definition is required',
                // 'mst_ac_type.required' => 'Account Type is required',
                'vat_type.required' => 'Vat Type is required',

            ]
        );

        $masterAcc = MasterAccount::find($masterAcc);
        if (!$masterAcc) {
            return back()->with('error', "Not Found");
        }



        $masterAcc->mst_ac_head = $request->mst_ac_head;
        $masterAcc->mst_definition = $request->mst_definition;

        // $masterAcc->mst_ac_type = $request->mst_ac_type;

        $masterAcc->vat_type = $request->vat_type;

        $masterAcc->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function masterDelete($masterAcc)
    {
        $masterAcc = MasterAccount::find($masterAcc);
        if (!$masterAcc) {
            return back()->with('error', "Not Found");
        }
        $count = AccountHead::where('ma_code', $masterAcc->mst_ac_code)->count();
        if ($count > 0) {
            return back()->with('error', "It has Account Head");
        }

        $masterAcc->forceDelete();
        return back()->with('success', "Deleted Successfully");
    }


    public function accHeadDetails()
    {
        $masterDetails = MasterAccount::latest()->get();
        // dd($masterDetails);
        return view('backend.masterAccount.accHeadDetails', compact('masterDetails'));
    }


    public function findMasterAcc(Request $request, MasterAccount $masterAcc)
    {
        $last = AccountHead::where('ma_code', $masterAcc->mst_ac_code)->latest()->first();
        if ($last) {
            $subCode = $last->ac_code + 1;
        } else {
            $subCode = 100;
        }


        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.findMasterAcc', ['masterAcc' => $masterAcc, 'subCode' => $subCode])->render()]);
        }
    }

    public function accHeahDetailsPost(Request $request, MasterAccount $masterAcc)
    {
        $request->validate(
            [
                'fld_ac_head'        => 'required',
            ],

            [
                'fld_ac_head.required' => 'A/C Head is required',
            ]
        );
        $accHeadL = AccountHead::where('ma_code', $masterAcc->mst_ac_code)->latest()->first();
        $accHead = new AccountHead();
        if ($accHeadL) {
            $accHead->ac_code = $accHeadL->ac_code + 1;
        } else {
            $accHead->ac_code = 100;
        }

        $accHead->ma_code = $masterAcc->mst_ac_code;
        $accHead->fld_ac_head = $request->fld_ac_head;
        $accHead->fld_ac_code = $masterAcc->mst_ac_code . "-" . $accHead->ac_code;
        $accHead->fld_ms_ac_head = $masterAcc->mst_ac_head;
        $accHead->fld_definition = $masterAcc->mst_definition;
        $accHead->account_type_id= $masterAcc->account_type_id;
        $accHead->master_account_id= $masterAcc->id;

        $accHead->save();


        return back()->with('success', 'Added Successfully');
    }

    public function editAccHead(AccountHead $item, Request $request)
    {
        $account_head = AccountHead::where('id', $item->id)->latest()->first();

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.editAccHead', ['account_head' => $account_head,])->render()]);
        }
    }

    public function accHeahEditPost(AccountHead $account_head, Request $request)
    {
        $request->validate(
            [
                'fld_ac_head'        => 'required',
            ],

            [
                'fld_ac_head.required' => 'A/C Head is required',
            ]
        );
        $account_head->fld_ac_head = $request->fld_ac_head;
        $account_head->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function mstAccType()
    {
        $types = MstACType::get();
        $cats = MstCatType::get();
        return view('backend.masterAccount.accountTypes', compact('types', 'cats'));
    }

    public function masterCatPost(Request $request)
    {
        $request->validate(
            [
                'title'        => 'required',
                'value'        => 'required',
            ],

            [
                'title.required' => 'Title is required',
                'value.required' => 'Value is required',

            ]
        );
        $masterCat = new MstCatType();
        $masterCat->title = $request->title;
        $masterCat->value = $request->value;
        $masterCat->save();
        return back()->with('success', "Added Successfully");
    }


    public function masterAccType(Request $request)
    {
        $request->validate(
            [
                'title'        => 'required',
                'cat_type'        => 'required',
            ],

            [
                'title.required' => 'Title is required',
                'cat_type.required' => 'Category Type is required',

            ]
        );
        $masterCat = new MstACType();
        $masterCat->title = $request->title;
        $masterCat->cat_type = $request->cat_type;
        $masterCat->save();
        return back()->with('success', "Added Successfully");
    }


    public function findMastedCode(Request $request)
    {

        // $typeCat = MstACType::where('id', $request->value)->first();
        $cat = MstCatType::where('id', $request->value)->latest()->first();

        $latest_master = MasterAccount::withTrashed()->whereBetween('mst_ac_code', [$cat->value, $cat->value + 99])->latest()->first();
        if ($latest_master) {
            if ($latest_master->mst_ac_code >= $cat->value + 99) {
                $msCode='No Place to Store';
            }
            else
            {
                $msCode=$latest_master->mst_ac_code + 1;
                }
            }

            else
            {
                $msCode = $cat->value;
            }


            return $msCode;

        }

        public function deleteAcHead($acHead)
        {
            $head=AccountHead::find($acHead);
            if(!$head)
            {
                return back()->with('error','Not Found');
            }
            $head->forceDelete();
            return back()->with('success','Deleted Successfully');
        }
        // work by mominul
        public function chart_of_account(){
            $vat_types = VatType::get();
            $mstAccType = MstACType::get();
            $categories=MstCatType::get();
            $mst_definitions = MstDefinition::get();
            $masterDetails = MasterAccount::where('mst_ac_type', '!=', 'Draft')->orderBy('mst_ac_code')->paginate(25);
            $masterDetailsPDF = MasterAccount::where('mst_ac_code', '!=', 'Draft')->orderBy('mst_ac_code')->get();
            $master_details = MasterAccount::latest()->get();
            return view('backend.masterAccount.chart-of-account', compact('vat_types', 'mstAccType', 'categories', 'mst_definitions', 'masterDetails', 'master_details', 'masterDetailsPDF'));
        }

        public function new_account_head(Request $request){
            $master_details = MasterAccount::orderBy('mst_ac_code')->get();
            return view('backend.masterAccount.new-accHeadDetails', compact('master_details'));
        }
        
        public function chart_of_account_pdf(){
            $masterDetails = MasterAccount::where('mst_ac_code', '!=', 'Draft')->latest()->get();
            $pdf = PDF::loadView('backend.masterAccount.chart-of-account-pdf', compact('masterDetails'));
            return $pdf->download('chart-of-account-list.pdf');
        }

}
