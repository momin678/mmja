<?php

namespace App\Http\Controllers\backend;

use App\Branch;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceTemp;
use App\InvoiceItem;
use App\InvoiceItemTemp;
use App\ItemList;
use App\PartyInfo;

use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\Stock;
use App\StockTransection;
use App\TempInvoice;
use Carbon\Carbon;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;

class TaxInvoiceController extends Controller
{
    public function taxInvoIssue()
    {
        $delete_invoice_temp=InvoiceTemp::whereDate('created_at','<', Carbon::today())->delete();
        // dd($delete_item);
        $sub_invoice=Carbon::now()->format('Ymd');
        $latest_invoice_no=InvoiceTemp::whereDate('created_at', Carbon::today())->where('invoice_no','LIKE',"%{$sub_invoice}%")->latest()->first();
        // dd($latest_invoice_no);
        if($latest_invoice_no)
        {
            $invoice_no=$latest_invoice_no->invoice_no+1;
        }
        else
        {
            $invoice_no=Carbon::now()->format('Ymd').'001';
        }
        // dd(Carbon::now()->format('Ymd'));
        $invoice=new InvoiceTemp;
        $invoice->invoice_no=$invoice_no;
        $invoice->save();
        $modes=PayMode::get();
        $terms=PayTerm::get();
        $branches=Branch::get();
        $customers=PartyInfo::get();
        $invoicess=Invoice::latest()->paginate(25);
        $projects=ProjectDetail::get();
        $itms=ItemList::get();
            return view('backend.taxInvoice.taxtInvoiceIssue',compact('customers','modes','terms','branches','customers','invoice','invoicess','projects','itms'));
    }



    public function selectItemByTerm(Request $request)
    {

        $item=PartyInfo::where('cc_code',$request->value)->first();
        // return $party;
        return $item;


    }

    public function partyInfoInvoice(Request $request)
    {
        // return $request->all();
        $info=PartyInfo::where('cc_code',$request->value)->first();
        return $info;
    }

    public function findDate(Request $request)
    {
        $date=Carbon::today()->addDays((int)$request->value)->format('Y-m-d');
        return $date;
    }


    public function findItem(Request $request)
    {
        $item=ItemList::where('barcode',$request->value)->first();
        $vat=100-(int)$item->vatRate->value;
        $unit_price=($item->sell_price/100)*$vat;

        if ($request->ajax()) {
            return Response()->json([   'item' => $item,
                                        'unit_price' => $unit_price,
                                        'net_amount' => $unit_price
        ]);
        }
        // return $item;

    }


    public function findItemId(Request $request)
    {
        $item=ItemList::where('id',$request->value)->first();
        $vat=100-(int)$item->vatRate->value;
        $unit_price=($item->sell_price/100)*$vat;

        if ($request->ajax()) {
            return Response()->json([   'item' => $item,
                                        'unit_price' => $unit_price,
                                        'net_amount' => $unit_price
        ]);
        }

    }

    public function tempInvoice(Request $request)
    {

        if(!$request->branch)
        {
            if ($request->ajax()) {
                return Response()->json(['fail' => 'Branch is required']);
            }
        }

        $project=ProjectDetail::where('id',$request->branch)->first();
        $itm=ItemList::where('id',$request->item_name)->first();
        $temp=InvoiceItemTemp::where('invoice_no',$request->invoice_no)->where('item_id',$itm->id)->first();
        $checkStock= $project->stockCheck($project->id,$itm->id);
        // return $itm->vatRate->value;
        $vat=100-(int)$itm->vatRate->value;
        // return $vat;
        if(!$temp)
        {
        if($checkStock < $request->quantity)
        {
            if ($request->ajax()) {
                return Response()->json(['stockout' => 'Stock Out']);
            }
        }

        $temp=new InvoiceItemTemp();
        $temp->invoice_no=$request->invoice_no;
        $temp->barcode=$itm->barcode;
        $temp->item_id=$itm->id;
        $temp->quantity=$request->quantity;
        $temp->vat_rate=$itm->vatRate->value;
        $temp->unit=$itm->unit;
        $temp->cost_price=$itm->sell_price*$temp->quantity;
        $temp->unit_price=($itm->sell_price/100)*$vat;
        $temp->net_amount=$temp->unit_price*$temp->quantity;
        $temp->total_unit_price=$temp->unit_price*$temp->quantity;
        $temp->vat_amount= $temp->cost_price-($temp->unit_price*$temp->quantity);
        }
        else
        {
            if($checkStock < ($temp->quantity+$request->quantity))
            {
                if ($request->ajax()) {
                    return Response()->json(['stockout' => 'Not in stock']);
                }
            }
            $temp->quantity=$temp->quantity+$request->quantity;
            $temp->cost_price=$itm->sell_price*$temp->quantity;
            $temp->unit_price=($itm->sell_price/100)*$vat;
            $temp->net_amount=$temp->unit_price*$temp->quantity;
            $temp->total_unit_price=$temp->unit_price*$temp->quantity;
            $temp->vat_amount= $temp->cost_price-($temp->unit_price*$temp->quantity);
        }
        $temp->save();

        $total_cost_price=InvoiceItemTemp::where('invoice_no',$request->invoice_no)->sum('cost_price');
        $total_unit_price=InvoiceItemTemp::where('invoice_no',$request->invoice_no)->sum('total_unit_price');
        $total_vat_amount=InvoiceItemTemp::where('invoice_no',$request->invoice_no)->sum('vat_amount');
        $invoice_draft=InvoiceTemp::where('invoice_no',$request->invoice_no)->latest()->first();
        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.invoice', ['invoice_draft' => $invoice_draft,'i' =>1])->render(),
                                        'total_cost_price' => $total_cost_price,
                                        'total_unit_price' => $total_unit_price,
                                        'total_vat_amount' => $total_vat_amount
        ]);
        }

    }


    public function finalSaveInvoice(Request $request)
    {
        $invoice=Invoice::where('invoice_no',$request->invoice_no)->first();
        if(!$invoice)
        {
            $invoice=new Invoice;
            $invoice->invoice_no=$request->invoice_no;
        }
        else
        {
            InvoiceItem::where('invoice_no',$request->invoice_no)->delete();
        }
        $invoice->date=$request->date;
        $invoice->branch=$request->branch;
        $invoice->customer_name=$request->customer_name;
        $invoice->trn_no=$request->trn_no;
        $invoice->pay_mode=$request->pay_mode;
        $invoice->pay_terms=$request->pay_terms;
        $invoice->due_date=$request->due_date;
        $invoice->contact_no=$request->contact_no;
        $invoice->address=$request->address;
        $invoice->save();
        $items=InvoiceItemTemp::where('invoice_no',$request->invoice_no)->get();
        foreach($items as $item)
        {
            $invoice_item=new InvoiceItem;
            $invoice_item->invoice_no=$item->invoice_no;
            $invoice_item->invoice_id=$invoice->id;
            $invoice_item->barcode=$item->barcode;
            $invoice_item->item_id=$item->item_id;
            $invoice_item->net_amount=1;
            $invoice_item->quantity=$item->quantity;
            $invoice_item->vat_rate=$item->vat_rate;
            $invoice_item->vat_amount=$item->vat_amount;
            $invoice_item->unit=$item->unit;
            $invoice_item->total_unit_price=$item->total_unit_price;
            $invoice_item->cost_price=$item->cost_price;
            $invoice_item->unit_price=$item->unit_price;
            $invoice_item->save();
            $stock=StockTransection::where('transection_id',$invoice->id)->where('item_id',$invoice_item->id)->first();
            $latestStock=StockTransection::latest()->first();
            if(!$stock)
            {
                $stock=new StockTransection();
                $stock->transection_id=$invoice->id;
                $stock->item_id=$item->item_id;
            }
            $stock->quantity=$item->quantity;
            $stock->stock_effect = -1 ;
            $stock->tns_type_code="S";
            $stock->tns_description="Sales";
            $stock->save();
        }

        return redirect()->route('invoicePrint',$invoice);
        // return view('backend.pdf.invoice',compact('invoice'));
    }


    public function invoicess()
    {
        $invoicess=Invoice::latest()->get();
        return view('backend.taxInvoice.invoicess',compact('invoicess'));
    }

    public function invoicePrint($invoice)
    {
        $invoice=Invoice::where('id',$invoice)->first();
        return view('backend.pdf.invoice',compact('invoice'));

    }


    public function itemDelete($item, Request $request)
    {
        $itm=InvoiceItemTemp::where('id',$item)->first();
        $invoice_no=$itm->invoice_no;
        $itm->delete();
        $total_cost_price=InvoiceItemTemp::where('invoice_no',$invoice_no)->sum('cost_price');
        $total_unit_price=InvoiceItemTemp::where('invoice_no',$invoice_no)->sum('total_unit_price');
        $total_vat_amount=InvoiceItemTemp::where('invoice_no',$invoice_no)->sum('vat_amount');
        $invoice_draft=InvoiceTemp::where('invoice_no',$invoice_no)->latest()->first();
        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.invoice', ['invoice_draft' => $invoice_draft,'i' =>1])->render(),
                                        'total_cost_price' => $total_cost_price,
                                        'total_unit_price' => $total_unit_price,
                                        'total_vat_amount' => $total_vat_amount
        ]);
        }
    }


    public function refresh_invoice(Request $request)
    {
        $invoicess=Invoice::latest()->paginate(25);

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.invoiceRight', ['invoicess' => $invoicess,'i' =>1])->render()
        ]);
        }

    }

    public function invoiceView($invoice)
    {
        $invoice=Invoice::where('id',$invoice)->first();
        $modes=PayMode::get();
        $terms=PayTerm::get();
        $branches=Branch::get();
        $customers=PartyInfo::get();
        $invoicess=Invoice::latest()->paginate(25);
        $projects=ProjectDetail::get();
        $itms=ItemList::get();
        $i=0;
        return view('backend.taxInvoice.invoiceView',compact('invoice','modes','terms','branches','customers','invoicess','projects','itms', 'i'));
        // return view('backend.pdf.invoice',compact('invoice'));
    }



    public function invoiceEdit($invoice)
    {
        $invoice=Invoice::where('id',$invoice)->first();
        $modes=PayMode::get();
        $terms=PayTerm::get();
        $branches=Branch::get();
        $customers=PartyInfo::get();
        $invoicess=Invoice::latest()->paginate(25);
        $projects=ProjectDetail::get();
        $itms=ItemList::get();
        $i=0;
        $invoice_temp=InvoiceTemp::where('invoice_no',$invoice->invoice_no)->first();
        if(!$invoice_temp)
        {
            $invoice_temp=new InvoiceTemp;
            $invoice_temp->invoice_no=$invoice->invoice_no;
            $invoice_temp->save();
        }
        InvoiceItemTemp::where('invoice_no',$invoice->invoice_no)->delete();
        $items=InvoiceItem::where('invoice_no',$invoice->invoice_no)->get();
        foreach($items as $item)
        {
            $item_temp=new InvoiceItemTemp;
            $item_temp->invoice_no=$item->invoice_no;
            $item_temp->barcode=$item->barcode;
            $item_temp->item_id=$item->item_id;
            $item_temp->net_amount=1;
            $item_temp->quantity=$item->quantity;
            $item_temp->vat_rate=$item->vat_rate;
            $item_temp->vat_amount=$item->vat_amount;
            $item_temp->unit=$item->unit;
            $item_temp->total_unit_price=$item->total_unit_price;
            $item_temp->cost_price=$item->cost_price;
            $item_temp->unit_price=$item->unit_price;
            $item_temp->save();
        }
        return view('backend.taxInvoice.invoiceEdit',compact('invoice','modes','terms','branches','customers','invoicess','projects','itms', 'i'));
    }


    public function finalSaveInvoiceUpdate(Request $request, $invoice)
    {
        $invoice=Invoice::where('id',$invoice)->first();
        if(!$invoice)
        {
            $invoice=new Invoice;
            $invoice->invoice_no=$request->invoice_no;
        }
        $invoice->date=$request->date;
        $invoice->branch=$request->branch;
        $invoice->customer_name=$request->customer_name;
        $invoice->trn_no=$request->trn_no;
        $invoice->pay_mode=$request->pay_mode;
        $invoice->pay_terms=$request->pay_terms;
        $invoice->due_date=$request->due_date;
        $invoice->contact_no=$request->contact_no;
        $invoice->address=$request->address;
        $invoice->save();

        InvoiceItem::where('invoice_no',$invoice->invoice_no)->delete();
        $items=InvoiceItemTemp::where('invoice_no',$invoice->invoice_no)->get();
        foreach($items as $item)
        {
            $invoice_item=new InvoiceItem;
            $invoice_item->invoice_no=$item->invoice_no;
            $invoice_item->invoice_id=$invoice->id;
            $invoice_item->barcode=$item->barcode;
            $invoice_item->item_id=$item->item_id;
            $invoice_item->net_amount=1;
            $invoice_item->quantity=$item->quantity;
            $invoice_item->vat_rate=$item->vat_rate;
            $invoice_item->vat_amount=$item->vat_amount;
            $invoice_item->unit=$item->unit;
            $invoice_item->total_unit_price=$item->total_unit_price;
            $invoice_item->cost_price=$item->cost_price;
            $invoice_item->unit_price=$item->unit_price;
            $invoice_item->save();

            $stock=StockTransection::where('transection_id',$invoice->id)->where('item_id',$item->item_id)->first();

            // $latestStock=StockTransection::latest()->first();
            if(!$stock)
            {
                $stock=new StockTransection();
                $stock->transection_id=$invoice->id;
                $stock->item_id=$item->item_id;
            }
            $stock->quantity=$item->quantity;
            $stock->stock_effect = -1 ;
            $stock->tns_type_code="S";
            $stock->tns_description="Sales";
            $stock->save();
        }

        return redirect()->route('invoicePrint',$invoice);

    }

}
