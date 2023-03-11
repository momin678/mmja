<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceItem;
use App\ItemList;
use App\ProjectDetail;
use App\SaleOrder;
use App\SaleOrderItem;
use App\SaleOrderTemp;
use App\SaleReturn;
use App\SaleReturnTemp;
use App\StockTransection;
use Illuminate\Http\Request;

class SalesReturnController extends Controller
{
    public function salesReturn()
    {
        $saleReturns=  SaleReturn::distinct()->get(['invoice_no']);
        return view('backend.salesReturn.saleReturn', compact('saleReturns'));
    }

    public function findInvoice(Request $request)
    {
        $item=Invoice::where('invoice_no',$request->value)->first();
        $project=ProjectDetail::find($item->project_id);
        $customer=$item->partyInfo($item->customer_name);
        $items=$item->items($item->invoice_no);
        $itemReturn=SaleReturnTemp::where('invoice_no',$request->invoice_no)->where('item_id',$request->item_name)->first();

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.form.itemSelect2', ['items' => $items])->render(),
            'page2' => view('backend.ajax.salesReturnList', ['items' => $itemReturn])->render(),
                'item' => $item, 'project'=>$project, 'items'=>$items, 'customer'=>$customer

        ]);
        }
    }



    public function tempSaleOrderReturn(Request $request)
    {

        $item=InvoiceItem::where('id',$request->item_name)->where('invoice_no',$request->invoice_no)->first();
        // return $item;
        $saleOrder=Invoice::where('invoice_no',$request->invoice_no)->first();
        $itemReturn=SaleReturnTemp::where('invoice_no',$request->invoice_no)->where('item_id',$item->item_id)->first();
        // return $itemReturn;
        if(!$itemReturn)
            {
                $itemReturn=new SaleReturnTemp();
                $quantity=$request->quantity;
            }
            else
            {
                $quantity=$request->quantity+$itemReturn->quantity;
            }
            if($item->quantity < (int)$quantity)
            {
            return Response()->json(['error' =>"Invalid Entry. Invoice Quantity ". $item->quantity]);
            }
        $itemReturn->invoice_no= $saleOrder->invoice_no;
        $itemReturn->item_id= $item->item_id;
        $itemReturn->barcode= $item->barcode;
        $itemReturn->quantity=$quantity;
        $itemReturn->unit= $item->unit;
        $itemReturn->unit_price= $item->unit_price;
        $itemReturn->discount=0;
        $itemReturn->net_amount=$itemReturn->quantity * $item->unit_price;
        $itemReturn->cost_price=0;
        $itemReturn->vat_rate= $item->vat_rate;
        $itemReturn->vat_amount=0;
        $itemReturn->total_unit_price=0;
        $itemReturn->save();
        // return $itemReturn;
        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.salesReturnList', ['itemReturn' => $itemReturn,'i' =>1])->render(),
                                        // 'total_cost_price' => $total_cost_price,
                                        // 'total_unit_price' => $total_unit_price,
                                        // 'total_vat_amount' => $total_vat_amount
        ]);
        }

    }

    public function finalSaveSaleReturn(Request $request)
    {
        $temps=SaleReturnTemp::where('invoice_no', $request->invoice_no)->get();
        if($temps->count()<1)
        {
            return back()->with('error',"Please, Refresh the page and try again");
        }
        foreach($temps as $temp)
        {
            $itemReturn=SaleReturn::where('invoice_no', $temp->invoice_no)->where('item_id',$temp->item_id)->first();
            if(!$itemReturn)
            {
                $itemReturn=new SaleReturn();
                $itemReturn->invoice_no= $temp->invoice_no;
                $itemReturn->item_id= $temp->item_id;
                $itemReturn->barcode= $temp->barcode;
            }
            else
            {
                return back()->with('error',"Already Stored");
            }
            $itemReturn->quantity=$temp->quantity;
            $itemReturn->unit= $temp->unit;
            $itemReturn->unit_price= $temp->unit_price;
            $itemReturn->discount=0;
            $itemReturn->net_amount=$itemReturn->quantity * $temp->unit_price;
            $itemReturn->cost_price=0;
            $itemReturn->vat_rate= $temp->vat_rate;
            $itemReturn->vat_amount=0;
            $itemReturn->total_unit_price=0;
            $itemReturn->save();
            $stock=StockTransection::where('transection_id',$itemReturn->id)->where('tns_type_code','T')->where('item_id',$itemReturn->item_id)->first();
            $latestStock=StockTransection::latest()->first();
            // dd($itemReturn->id);
            if(!$stock)
            {
                $stock=new StockTransection();
                $stock->transection_id=$itemReturn->id;
                $stock->item_id=$itemReturn->item_id;
            }
            $stock->quantity=$itemReturn->quantity;
            $stock->stock_effect = 1 ;
            $stock->tns_type_code="T";
            $stock->tns_description="Sale Return";
            $stock->save();
            $temp->delete();
        }

        return redirect()->route('saleReturnPrint',$itemReturn);

    }

    public function saleReturnPrint($invoiceF)
    {
        $invoice=SaleReturn::where('id',$invoiceF)->first();
        if(!$invoice)
        {
            $invoice=SaleReturn::where('invoice_no',$invoiceF)->first();
        }

        return view('backend.pdf.saleReturnInvoice',compact('invoice'));

    }


    public function refresh_saleReturn(Request $request)
    {
        $saleReturns=  SaleReturn::distinct()->get(['invoice_no']);

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.saleReturnRight', ['saleReturns' => $saleReturns,'i' =>1])->render()
        ]);
        }

    }


    public function findItemIdSaleReturn(Request $request)
    {
        $item=InvoiceItem::where('id',$request->value)->first();
        // return $item;
        $unit_price=$item->cost_price/$item->quantity;
        if ($request->ajax()) {
            return Response()->json([   'item' => $item,
                                        'unit_price' =>number_format((float)(  $unit_price),'3','.',''),
                                        'cost_price' =>number_format((float)(  $unit_price),'2','.','')
                                        // 'price'=>number_format((float)($unit_price),2,'.',''),
                                        // 'net_amount' => number_format((float)($item->total_amount),2,'.','')
        ]);
        }

    }


}
