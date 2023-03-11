<?php

namespace App\Http\Controllers\backend;

use App\Branch;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceItem;
use App\InvoiceTemp;
use App\ItemList;
use App\Mapping;
use App\PartyInfo;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\SaleOrder;
use App\SaleOrderItem;
use App\SaleOrderItemTemp;
use App\SaleOrderTemp;
use App\StockTransection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleOrderController extends Controller
{
    public function saleOrderReceive()
    {
        $delete_invoice_temp=SaleOrderTemp::whereDate('created_at','<', Carbon::today())->delete();
        $sub_invoice=Carbon::now()->format('Ymd');
        $latest_sale_order_no=SaleOrderTemp::whereDate('created_at', Carbon::today())->where('sale_order_no','LIKE',"%{$sub_invoice}%")->latest()->first();
        if($latest_sale_order_no)
        {
            $latest_sale_order_no=$latest_sale_order_no->sale_order_no+1;
        }
        else
        {
            $latest_sale_order_no=Carbon::now()->format('Ymd').'001';
        }
        $sale=new SaleOrderTemp();
        $sale->sale_order_no=$latest_sale_order_no;
        $sale->save();
        $modes=PayMode::get();
        $terms=PayTerm::get();
        $branches=Branch::get();
        $customers=PartyInfo::get();
        $sales=SaleOrder::latest()->paginate(25);
        $projects=ProjectDetail::get();
        $itms=ItemList::get();
        $gl_code=Mapping::where('fld_txn_type',"sale")->first();
            return view('backend.saleOrder.saleOrderReceive',compact('customers','modes','terms','branches','customers','sale','sales','projects','itms','gl_code'));
    }

    public function tempSaleOrder(Request $request)
    {

        if(!$request->branch)
        {
            if ($request->ajax()) {
                return Response()->json(['fail' => 'Branch is required']);
            }
        }
        $project=ProjectDetail::where('id',$request->branch)->first();
        $itm=ItemList::where('id',$request->item_name)->first();
        $temp=SaleOrderItemTemp::where('sale_order_no',$request->invoice_no)->where('item_id',$itm->id)->first();

        $checkStock= $project->stockCheck($project->id,$itm->id);
// return 11;
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

        $temp=new SaleOrderItemTemp();
        $temp->sale_order_no=$request->invoice_no;
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

        $total_cost_price=SaleOrderItemTemp::where('sale_order_no',$request->invoice_no)->sum('cost_price');
        $total_unit_price=SaleOrderItemTemp::where('sale_order_no',$request->invoice_no)->sum('total_unit_price');
        $total_vat_amount=SaleOrderItemTemp::where('sale_order_no',$request->invoice_no)->sum('vat_amount');
        $invoice_draft=SaleOrderTemp::where('sale_order_no',$request->invoice_no)->latest()->first();
        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.saleOrder', ['invoice_draft' => $invoice_draft,'i' =>1])->render(),
                                        'total_cost_price' => $total_cost_price,
                                        'total_unit_price' => $total_unit_price,
                                        'total_vat_amount' => $total_vat_amount
        ]);
        }

    }




    public function finalSaveSaleOrder(Request $request)
    {

        $gl_code=Mapping::where('fld_txn_type',"sale")->first();
        $invoice=SaleOrder::where('sale_order_no',$request->invoice_no)->first();
        if(!$invoice)
        {
            $invoice=new SaleOrder();
            $invoice->sale_order_no=$request->invoice_no;
        }
        else
        {
            // SaleOrderItem::where('sale_order_no',$request->invoice_no)->delete();
            return back()->with('error','Already Stored');
        }
        $invoice->date=$request->date;
        $invoice->project_id=$request->branch;
        $invoice->customer_name=$request->customer_name;
        $invoice->trn_no=$request->trn_no;
        $invoice->pay_mode=$request->pay_mode;
        $invoice->pay_terms=$request->pay_terms;
        $invoice->due_date=$request->due_date;
        $invoice->contact_no=$request->contact_no;
        $invoice->address=$request->address;
        $invoice->gl_code=$gl_code ? $gl_code->fld_ac_code: null;
        $invoice->save();
        $invoiceNew=Invoice::where('sale_order_id',$invoice->id)->first();
        if(!$invoiceNew)
        {
            $sub_invoice=Carbon::now()->format('Ymd');
            $latest_invoice_no=InvoiceTemp::whereDate('created_at', Carbon::today())->where('invoice_no','LIKE',"%{$sub_invoice}%")->latest()->first();
            if($latest_invoice_no)
            {
                $invoice_no=$latest_invoice_no->invoice_no+1;
            }
            else
            {
                $invoice_no=Carbon::now()->format('Ymd').'001';
            }
            $invoicetemp=new InvoiceTemp;
            $invoicetemp->invoice_no=$invoice_no;
            $invoicetemp->save();
            $invoiceNew=new Invoice();
            $invoiceNew->invoice_no= $invoicetemp->invoice_no;
            $invoiceNew->sale_order_id=$invoice->id;
        }
        $invoiceNew->date=$invoice->date;
        $invoiceNew->project_id=$invoice->project_id;
        $invoiceNew->customer_name=$invoice->customer_name;
        $invoiceNew->trn_no= $invoice->trn_no;
        $invoiceNew->pay_mode=$invoice->pay_mode;
        $invoiceNew->pay_terms=$invoice->pay_terms;
        $invoiceNew->due_date=$invoice->due_date;
        $invoiceNew->contact_no=$invoice->contact_no;
        $invoiceNew->address=$invoice->address;
        $invoiceNew->gl_code=$invoice->gl_code;
        $invoiceNew->save();
        $items=SaleOrderItemTemp::where('sale_order_no',$request->invoice_no)->get();
        foreach($items as $item)
        {

            $invoice_item=new InvoiceItem();
            $invoice_item->invoice_no=$invoiceNew->invoice_no;
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
            $stock=StockTransection::where('transection_id',$invoice->id)->where('item_id',$invoice_item->id)->where('tns_type_code',"S")->first();
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
// dd($invoiceNew);
        return redirect()->route('invoicePrint',$invoiceNew);
    }

    public function SalePartyInfo(Request $request)
    {
        $info=PartyInfo::where('pi_code',$request->value)->first();
        return $info;
    }

    public function findDateSale(Request $request)
    {
        $date=Carbon::today()->addDays((int)$request->value)->format('Y-m-d');
        return $date;
    }


    public function findItemSale(Request $request)
    {
        $item=ItemList::where('barcode',$request->value)->first();
        $vat=100-(int)$item->vatRate->value;
        $unit_price=$item->sell_price;

        if ($request->ajax()) {
            return Response()->json([   'item' => $item,
                                        'unit_price' => $unit_price,
                                        'net_amount' => $unit_price
        ]);
        }
    }


    public function findItemIdSale(Request $request)
    {
        $item=ItemList::where('id',$request->value)->first();
        $vat=100-(int)$item->vatRate->value;
        $unit_price=$item->sell_price;

        if ($request->ajax()) {
            return Response()->json([   'item' => $item,
                                        'unit_price' => $unit_price,
                                        'net_amount' => $unit_price
        ]);
        }

    }


    public function itemDeleteSale($item, Request $request)
    {
        $itm=SaleOrderItemTemp::where('id',$item)->first();
        $sale_order_no=$itm->sale_order_no;
        $itm->delete();
        $total_cost_price=SaleOrderItemTemp::where('sale_order_no',$sale_order_no)->sum('cost_price');
        $total_unit_price=SaleOrderItemTemp::where('sale_order_no',$sale_order_no)->sum('total_unit_price');
        $total_vat_amount=SaleOrderItemTemp::where('sale_order_no',$sale_order_no)->sum('vat_amount');
        $invoice_draft=SaleOrderTemp::where('sale_order_no',$sale_order_no)->latest()->first();
        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.saleOrder', ['invoice_draft' => $invoice_draft,'i' =>1])->render(),
                                        'total_cost_price' => $total_cost_price,
                                        'total_unit_price' => $total_unit_price,
                                        'total_vat_amount' => $total_vat_amount
        ]);
        }
    }


    public function SaleOrderController($invoice)
    {
        $invoice=Invoice::where('id',$invoice)->first();
        return view('backend.pdf.saleInvoice',compact('invoice'));

    }


    public function saleOrderPrint($invoice)
    {
        $invoice=SaleOrder::where('id',$invoice)->first();
        return view('backend.pdf.saleInvoice',compact('invoice'));

    }


    public function refresh_sale_order(Request $request)
    {
        $invoicess=SaleOrder::latest()->paginate(25);

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.saleOrderRight', ['invoicess' => $invoicess,'i' =>1])->render()
        ]);
        }

    }
}
