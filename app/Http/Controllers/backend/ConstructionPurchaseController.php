<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\ItemList;
use App\ProjectDetail;
use App\PurchaseRequisition;
use App\TempPRNO;
use App\Unit;
use Illuminate\Http\Request;

class ConstructionPurchaseController extends Controller
{
    public function index(){
        $temp_pr = '';                                                    
        $exit_temp_no = TempPRNO::whereDate('created_at', '=', date('Y-m-d'))->max('pr_no');
        if($exit_temp_no){
            $temp_pr = $exit_temp_no+1;
        }else {
            $temp_pr = date("Ymd").'01';
        }
        $new_pr_no = new TempPRNO;
        $new_pr_no->pr_no = $temp_pr;
        $new_pr_no->save();

        $units = Unit::all();
        $purchaseRequisitions = PurchaseRequisition::orderBy("id", "DESC")->paginate(15);
        $itemLists = ItemList::orderBy("barcode", "asc")->get();
        $projects = ProjectDetail::all();
        return view('backend.construction-purchase.index', compact('units', 'purchaseRequisitions', 'itemLists', 'projects', 'new_pr_no'));
    }
}
