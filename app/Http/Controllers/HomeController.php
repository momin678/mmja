<?php

namespace App\Http\Controllers;

use App\Fifo;
use App\FifoInvoice;
use App\Invoice;
use App\InvoiceAmount;
use App\InvoiceItem;
use App\ItemList;

use App\Models\BankDetail;
use App\Models\CostCenter;
use App\Models\MasterAccount;
use App\PartyInfo;
use App\ProfitCenter;
use App\ProjectDetail;
use App\Purchase;
use App\PurchaseDetail;
use App\Setting;
use App\Stock;

use App\StockTransection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $settings= Setting::where('config_name', 'company_name')->first();
        // return $settings;
        return view('home');
    }


    public function pdf($id)
    {
        if ($id == "bankDetails") {
            $bankDetails = BankDetail::latest()->get();
            return view('backend/pdf/bankDetailsPdf', compact('bankDetails'));
        }

        if ($id == "projDetails") {
            $projDetails = ProjectDetail::where('proj_type', '!=', "Draft")->latest()->get();
            return view('backend/pdf/projDetailsPdf', compact('projDetails'));
        }

        if ($id == "MasterAccDetails") {
            $masterDetails = MasterAccount::where('mst_ac_code', '!=', 'Draft')->latest()->get();
            return view('backend/pdf/MasterAccDetailsPdf', compact('masterDetails'));
        }

        if ($id == "costCenter") {
            $costCenters = CostCenter::latest()->get();
            return view('backend/pdf/costCentersPdf', compact('costCenters'));
        }


        if ($id == "profitCenter") {
            $profitDetails = ProfitCenter::where('activity', '!=', 'Draft')->latest()->get();
            return view('backend/pdf/profitCentersPdf', compact('profitDetails'));
        }

        if ($id == "partyCenter") {
            $partyInfos = PartyInfo::orderBy('id','DESC')->get();
            return view('backend/pdf/partyInfoPdf', compact('partyInfos'));
        }
    }




    public function SearchAjax(Request $request, $id)
    {

        if ($id == "masterAcc") {
            $masterDetails = MasterAccount::where('mst_ac_code', 'like', "%{$request->q}%")
                ->orWhere('mst_ac_head', 'like', "%{$request->q}%")
                ->orWhere('mst_definition', 'like', "%{$request->q}%")
                ->orWhere('mst_ac_type', 'like', "%{$request->q}%")
                ->orWhere('vat_type', 'like', "%{$request->q}%")
                ->latest()
                ->take(40)
                ->get();
            $i = 1;

            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.masterAccTbody', ['masterDetails' => $masterDetails, 'i' => $i])->render()]);
            }
        }


        if ($id == "costCenter") {
            $costCenters = CostCenter::where('cc_code', 'like', "%{$request->q}%")
                ->orWhere('cc_name', 'like', "%{$request->q}%")
                ->latest()
                ->take(40)
                ->get();
            $i = 1;
            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.costCenterTbody', ['costCenters' => $costCenters, 'i' => $i])->render()]);
            }
        }

        if ($id == "projectDetails") {
            $projDetails = ProjectDetail::where('proj_no', 'like', "%{$request->q}%")
                ->orWhere('proj_name', 'like', "%{$request->q}%")
                ->orWhere('cont_no', 'like', "%{$request->q}%")
                ->latest()
                ->take(40)
                ->get();
            $i = 1;

            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.projectDetailsTbody', ['projDetails' => $projDetails, 'i' => $i])->render()]);
            }
        }

        if ($id == "bankDetails") {
            $bankDetails = BankDetail::where('bank_code', 'like', "%{$request->q}%")
                ->orWhere('bank_name', 'like', "%{$request->q}%")
                ->orWhere('ac_no', 'like', "%{$request->q}%")
                ->latest()
                ->take(40)
                ->get();
            $i = 1;
            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.bankDetailsTbody', ['bankDetails' => $bankDetails, 'i' => $i])->render()]);
            }
        }


        if ($id == "profitCenter") {
            $profitDetails = ProfitCenter::where('pc_code', 'like', "%{$request->q}%")
                ->orWhere('pc_name', 'like', "%{$request->q}%")
                ->latest()
                ->take(40)
                ->get();
            $i = 1;
            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.profitCenterTbody', ['profitDetails' => $profitDetails, 'i' => $i])->render()]);
            }
        }


        if ($id == "partyCenter") {
            $partyInfos = PartyInfo::where('pi_code', 'like', "%{$request->q}%")
                ->orWhere('pi_name', 'like', "%{$request->q}%")
                ->orWhere('trn_no', 'like', "%{$request->q}%")
                ->latest()
                ->take(40)
                ->get();
            $i = 1;
            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.partyInfoTbody', ['partyInfos' => $partyInfos, 'i' => $i])->render()]);
            }
        }
    }

    public function print()
    {
        return view('backend.pdf.print');
    }

    public function school()
    {
        return view('student');
    }
    public function school2()
    {
        return view('school2');
    }

    public function employee()
    {
        return view('employee');
    }

    public function inv()
    {
        return view('inv');
    }

    public function fifo()
    {
        // dd(1);
        return view('fifo');
    }

    public function invItem()
    {
        return view('test.invItem');
    }




    public function compare()
    {
        // dd(1);
        return view('test.compare');
    }


    public function repairinvitmstocksalefromfifo()
    {
        $fifos=Fifo::get();

        foreach($fifos as $fifo)
        {
            $items=InvoiceItem::where('item_id',$fifo->item_id)->get();
            foreach($items as $item)
            {
                $item->purchase_price=$fifo->unit_cost_price;
                $item->save();
                StockTransection::where('transection_id',$item->invoice_id)->where('item_id',$item->item_id)->where('tns_type_code','S')->update([
                        'purchase_rate' =>$item->purchase_price
                ]);
            }
        }

        return back()->with('success', 'Succesfully Repaired');

    }


    public function fifo_update(){
        $po_items = PurchaseDetail::all();
        return view('backend.update-file.fifo-update', compact('po_items'));
    }
    public function fifo_update_submit(){
        $po_items = PurchaseDetail::all();
        foreach($po_items as $item){
            $po_id = Purchase::where('purchase_no', $item->purchase_no)->first();
            Fifo::where('purchase_id', $po_id->id)->where('item_id', $item->item_id)->first()->update(['unit_cost_price'=>$item->purchase_rate+(($item->purchase_rate*5)/100)]);
        }
        return back();
    }

 public function invoice()
    {
        return view('test.invoice');
    }

    public function  invoiceItem(Invoice $invoice)
    {
        $items=InvoiceItem::where('invoice_id',$invoice->id)->get();
        return view('test.invoiceItems',compact('invoice','items'));
    }

    public function invoiceDelete(Invoice $invoice)
    {


        $items=InvoiceItem::where('invoice_id',$invoice->id)->get();
        foreach($items as $itm)
        {
            $FifoInv=FifoInvoice::where('invoice_id',$itm->invoice_id)->where('item_id',$itm->item_id)->get();
            foreach($FifoInv as $fitm)
            {
                $ffffff=Fifo::where('id',$fitm->fifo_id)->where('item_id',$fitm->item_id)->first();
                $ffffff->consumed=$ffffff->consumed-$fitm->quantity;
                $ffffff->remaining=$ffffff->remaining+$fitm->quantity;
                $ffffff->save();
                StockTransection::where('transection_id',$invoice->id)->where('item_id',$fitm->item_id)->where('tns_type_code','S')->delete();
                $fitm->delete();
            }

            $itm->forceDelete();
        }

        InvoiceAmount::where('invoice_id',$invoice->id)->delete();

        $invoice->forceDelete();

        return redirect('/invoicecheck');
    }
    
    
      public function newReport()
    {
        $invoicess= Invoice::whereMonth('date',8)->get();
        return view('test.neweReport',compact('invoicess'));
    }


 public function tax()
    {
        $invoicess=Invoice::whereMonth('date','>',8)->whereMonth('date','<',12)->orderBy('date','ASC')->get();
        return view('tax',compact('invoicess'));
    }
    
    
     public function tax_september()
    {
        $invoicess=Invoice::whereMonth('date',9)->orderBy('date','ASC')->get();
        return view('tax',compact('invoicess'));
    }

    public function tax_oct()
    {
        $invoicess=Invoice::whereMonth('date',10)->orderBy('date','ASC')->get();
        return view('tax',compact('invoicess'));
    }

    public function tax_nov()
    {
        $invoicess=Invoice::whereMonth('date',11)->orderBy('date','ASC')->get();
        return view('tax',compact('invoicess'));
    }

    
    
       public function new_stock()
    {
        $items=ItemList::get();
        foreach($items as $item)
        {
            $stock=Stock::where('item_id',$item->id)->first();
            if(!$stock)
            {
                $stock=new Stock();
                $stock->item_id = $item->id;
            }
            $stock->quantity=$item->itemStock();
            $stock->save();
        }

        dd('done');
    }
    
     public function purchase_export(){
        $purchases = Purchase::where('status', 101)->whereBetween('date', ['2022-09-01', '2022-11-30'])->get();
        return view('purchase-export', compact('purchases'));
    }
}
