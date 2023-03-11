<?php

namespace App\Http\Controllers\backend;

use App\Branch;
use App\CostCenterType;
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


            return view('backend.saleOrder.saleOrderReceive',compact('costTypes','cc','customers','modes','terms','branches','customers','sale','sales','projects','itms','gl_code'));
    }

    public function tempSaleOrder(Request $request)
    {
        $itm=ItemList::where('id',$request->item_name)->first();
        $temp=SaleOrderItemTemp::where('sale_order_no',$request->invoice_no)->where('item_id',$itm->id)->first();
        $vat=100-(int)$itm->vatRate->value;
        if(!$temp)
        {
        $temp=new SaleOrderItemTemp();
        $temp->sale_order_no=$request->invoice_no;
        $temp->barcode=$itm->barcode;
        $temp->style_id=$itm->style_id;
        $temp->size=$itm->group_name;
        $temp->color_id=$itm->brand_id;

        $temp->item_id=$itm->id;
        $temp->quantity=$request->quantity;
        $temp->vat_rate=$itm->vatRate->value;
        $temp->unit=$itm->unit;
        $temp->cost_price=$itm->total_amount* $temp->quantity;
        $temp->unit_price=$itm->sell_price;
        $temp->net_amount=$temp->unit_price*$temp->quantity;
        $temp->total_unit_price=$temp->unit_price*$temp->quantity;
        $temp->vat_amount= $temp->cost_price-($temp->unit_price*$temp->quantity);
        }
        else
        {
            $temp->quantity=$temp->quantity+$request->quantity;
            $temp->cost_price=$itm->total_amount* $temp->quantity;
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
                    'total_cost_price' => number_format((float)($total_cost_price),'2','.',''),
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
            SaleOrderItem::where('sale_order_no',$request->invoice_no)->delete();
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

        $items=SaleOrderItemTemp::where('sale_order_no',$request->invoice_no)->get();
        foreach($items as $item)
        {

            $invoice_item=new SaleOrderItem();
            $invoice_item->sale_order_no=$item->sale_order_no;
            $invoice_item->style_id=$item->style_id;
            $invoice_item->size=$item->size;
            $invoice_item->color_id=$item->color_id;
            $invoice_item->sale_order_id=$invoice->id;
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
        }

        return redirect()->route('saleOrderView',$invoice);
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
        $unit_price=$item->sell_price;
        if ($request->ajax()) {
            return Response()->json([   'item' => $item,
                                        'unit_price' => $item->total_amount,
                                        'net_amount' =>number_format((float)($item->total_amount),2,'.','')
        ]);
        }
    }


    public function findItemIdSale(Request $request)
    {
        $item=ItemList::where('id',$request->value)->first();
        $unit_price=$item->total_amount;
        if ($request->ajax()) {
            return Response()->json([   'item' => $item,
                                        'unit_price' => $unit_price,
                                        'price'=>number_format((float)($unit_price),2,'.',''),
                                        'net_amount' => number_format((float)($item->total_amount),2,'.','')
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


    public function saleOrderView($invoice)
    {
        $invoice=SaleOrder::where('id',$invoice)->first();
        $modes=PayMode::get();
        $terms=PayTerm::get();
        $branches=Branch::get();
        $customers=PartyInfo::get();
        $invoicess=SaleOrder::latest()->paginate(25);
        $projects=ProjectDetail::get();
        $itms=ItemList::get();
        $i=0;
        return view('backend.saleOrder.saleOrderView',compact('invoice','modes','terms','branches','customers','invoicess','projects','itms', 'i'));
        // return view('backend.pdf.invoice',compact('invoice'));
    }




    public function saleOrderEdit($invoice)
    {
        $sale=SaleOrder::where('id',$invoice)->first();
        if(isset($sale->deliveryNoteSale))
        {
            return back()->with('error',"Delivery Note Already Generated. Your Can't Update It Now!");
        }
        $modes=PayMode::get();
        $terms=PayTerm::get();
        $branches=Branch::get();
        $customers=PartyInfo::get();
        $sales=SaleOrder::latest()->paginate(25);
        $projects=ProjectDetail::get();
        $itms=ItemList::get();
        $i=0;
        $invoice_temp=SaleOrderTemp::where('sale_order_no',$sale->sale_order_no)->first();
        if(!$invoice_temp)
        {
            $invoice_temp=new SaleOrderTemp;
            $invoice_temp->sale_order_no=$sale->sale_order_no;
            $invoice_temp->save();
        }
        SaleOrderItemTemp::where('sale_order_no',$sale->sale_order_no)->delete();
        $items=SaleOrderItem::where('sale_order_no',$sale->sale_order_no)->get();
        foreach($items as $item)
        {
            $item_temp=new SaleOrderItemTemp;
            $item_temp->sale_order_no=$item->sale_order_no;
            $item_temp->barcode=$item->barcode;
            $item_temp->item_id=$item->item_id;
            $item_temp->style_id=$item->style_id;
            $item_temp->size=$item->size;
            $item_temp->color_id=$item->color_id;
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
        return view('backend.saleOrder.saleOrderedit',compact('sale','modes','terms','branches','customers','sales','projects','itms', 'i'));
    }



    public function finalSaveSaleUpdate(Request $request, $invoice)
    {
        $invoice=SaleOrder::where('id',$invoice)->first();
        if(isset($invoice->deliveryNoteSale))
        {
            return back()->with('fail',"Delivery Note Already Generated. Your Can't Update It Now!");
        }
        if(!$invoice)
        {
            $invoice=new SaleOrder();
            $invoice->sale_order_no=$request->sale_order_no;
        }
        // dd($request->customer_name);
        $invoice->date=$request->date;
        $invoice->project_id=$request->branch;
        $invoice->customer_name=$request->customer_name;
        $invoice->trn_no=$request->trn_no;
        $invoice->pay_mode=$request->pay_mode;
        $invoice->pay_terms=$request->pay_terms;
        $invoice->due_date=$request->due_date;
        $invoice->contact_no=$request->contact_no;
        $invoice->address=$request->address;
        $invoice->save();

        SaleOrderItem::where('sale_order_no',$invoice->sale_order_no)->forceDelete();
        $items=SaleOrderItemTemp::where('sale_order_no',$invoice->sale_order_no)->get();
        foreach($items as $item)
        {
            $invoice_item=new SaleOrderItem();
            $invoice_item->sale_order_no=$item->sale_order_no;
            $invoice_item->sale_order_id=$invoice->id;
            $invoice_item->barcode=$item->barcode;
            $invoice_item->item_id=$item->item_id;
            $invoice_item->style_id=$item->style_id;
            $invoice_item->size=$item->size;
            $invoice_item->color_id=$item->color_id;
            $invoice_item->net_amount=1;
            $invoice_item->quantity=$item->quantity;
            $invoice_item->vat_rate=$item->vat_rate;
            $invoice_item->vat_amount=$item->vat_amount;
            $invoice_item->unit=$item->unit;
            $invoice_item->total_unit_price=$item->total_unit_price;
            $invoice_item->cost_price=$item->cost_price;
            $invoice_item->unit_price=$item->unit_price;
            $invoice_item->save();
        }
        return redirect()->route('saleOrderPrint',$invoice);
    }

        public function searchSO(Request $request)
    {
        $so=SaleOrder::where('sale_order_no', 'LIKE', "%{$request->value}%")->get();

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.saleOrderRight', ['invoicess' => $so,'i' =>1])->render()
        ]);
        }

    }



    public function customerPost(Request $request)
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
        $sv=$draftCost->save();
        $newCustomer=$draftCost;
        // dd($customer);
        $customers=PartyInfo::get();

        // return back()->with('success','Added Successfylly',compact('newCustomer'));
        return Response()->json(['page' => view('backend.ajax.form.customerSelect', ['customers' => $customers])->render(),
                'newCustomer' => $newCustomer
        ]);

    }


}
