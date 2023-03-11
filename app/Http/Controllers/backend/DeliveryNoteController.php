<?php

namespace App\Http\Controllers\backend;

use App\Branch;
use App\DeliveryItem;
use App\DeliveryNote;
use App\DeliveryNoteSale;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\ItemList;
use App\PartyInfo;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\SaleOrder;
use App\SaleOrderItem;
use App\StockTransection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeliveryNoteController extends Controller
{
    public function deliveryNote()
    {
        $sales=SaleOrder::latest()->paginate(60);
        return view('backend.deliveryNote.deliveryNote', compact('sales'));
    }

    public function saleOrderDetails($sale, Request $request)
    {
        $invoice=SaleOrder::find($sale);
        $modes=PayMode::get();
        $terms=PayTerm::get();
        $customers=PartyInfo::get();
        $projects=ProjectDetail::get();
        $itms=ItemList::get();
        $notes=DeliveryNote::all();
        $i=0;
        if(!$invoice)
        {
            return back()->with('error', "Not Found");
        }

        $sub_invoice=Carbon::now()->format('Ymd');
        $dn_no=DeliveryNote::whereDate('created_at', Carbon::today())->where('delivery_note_no','LIKE',"%{$sub_invoice}%")->latest()->first();
        if($dn_no)
        {
            // $dn_code=preg_replace('/^DN/', '', $dn_no->delivery_note_no );
            $dn_code=rtrim($dn_no->delivery_note_no,'DN');
            // return $dn_code;
            $no=$dn_code+1;
            $dcode=$no.'DN';
        }
        else
        {
            $dcode=Carbon::now()->format('Ymd').'01'.'DN';
        }

        $no=$dcode;

        // return $no;
        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.deliveryNoteDetails', ['invoice' => $invoice,'i' =>1, 'modes'=>$modes, 'terms'=> $terms, 'customers'=>$customers,'projects'=>$projects,'itms'=>$itms,'notes'=>$notes,'no' => $dcode])->render()
        ]);
        }

    }


    public function asignDeliveryNote(Request $request, $sale)
    {
        $request->validate([
            // 'proj_no' => 'required',
            'note_no'        => 'required',
        ],
        [
            'note_no.required' => 'Required',

        ]
    );
        $delivery_no=DeliveryNote::where('delivery_note_no', $request->note_no)->first();
        $deliverySale=DeliveryNoteSale::where('sale_order_id', $sale)->first();
        $invoice=SaleOrder::find($sale);
        if(!$delivery_no)
        {
            $delivery_no=new DeliveryNote();
            $delivery_no->delivery_note_no=$request->note_no;
            $delivery_no->save();
        }

        if(!$deliverySale)
        {
            $deliverySale=new DeliveryNoteSale();

                    // **************************Stock transection in delivery note**************************
                    //     $items=SaleOrderItem::where('sale_order_no',$invoice->sale_order_no)->get();
                    //     foreach($items as $item)
                    //    {
                    //     $stock=StockTransection::where('transection_id',$invoice->id)->where('item_id',$invoice->id)->first();
                    //     $latestStock=StockTransection::latest()->first();
                    //     if(!$stock)
                    //     {
                    //         $stock=new StockTransection();
                    //         $stock->transection_id=$invoice->id;
                    //         $stock->item_id=$item->item_id;
                    //     }
                    //     $stock->quantity=$item->quantity;
                    //     $stock->stock_effect = -1 ;
                    //     $stock->tns_type_code="S";
                    //     $stock->tns_description="Sales";
                    //     $stock->save();
                    //    }
                    // *********************************************************************
        }

        $deliverySale->sale_order_id=$sale;
        $deliverySale->delivery_note_id=$delivery_no->id;
        $deliverySale->save();
        return redirect()->route('updateNote', $invoice)->with('success','Delivery Note Stored');

    }

    public function updateNote($invoice)
    {
        $sales=SaleOrder::latest()->paginate(60);
        $invoice=SaleOrder::find($invoice);
        $modes=PayMode::get();
        $terms=PayTerm::get();
        $customers=PartyInfo::get();
        $projects=ProjectDetail::get();
        $itms=ItemList::get();
        $notes=DeliveryNote::all();
        $i=0;
        $sub_invoice=Carbon::now()->format('Ymd');
        $dn_no=DeliveryNote::whereDate('created_at', Carbon::today())->where('delivery_note_no','LIKE',"%{$sub_invoice}%")->latest()->first();
        if($dn_no)
        {
            $dn_code=rtrim($dn_no->delivery_note_no,'DN');
            $no=$dn_no->dn_code+1;
            $dcode=$no.'DN';
        }
        else
        {
            $dcode=Carbon::now()->format('Ymd').'01'.'DN';
        }
        $no=$dcode;

        return view('backend.deliveryNote.deliveryNote', compact('sales','invoice','modes','terms','customers','projects','itms','notes', 'i','no'));
    }

    public function deliveryNotePrint($invoice)
    {
        // dd($invoice);
        $dnote=DeliveryNote::find($invoice);
        $invoice=$dnote->deliverySale->saleOrder;
        return view('backend.pdf.deliveryNote',compact('dnote','invoice'));

    }

    public function generateDeliveryNote(Request $request, $sale)
    {
        // dd(1);
        $project=ProjectDetail::where('id',$request->branch)->first();
        $invoice=SaleOrder::find($sale);
        foreach($request->items as $key => $value)
        {
            $itm=ItemList::where('id',$request->items[$key]['item_id'])->first();
            $checkStock= $project->stockCheck($project->id,$request->items[$key]['item_id']);
                    if($checkStock < $request->items[$key]['quantity'])
                    {
                        return redirect()->route('updateNote', $invoice)->with('error','Not in Stock '.$itm->barcode.'. Available Quantity '.$checkStock);
                    }


        }
        $delivery_no=DeliveryNote::where('delivery_note_no', $request->note_no)->first();
        $deliverySale=DeliveryNoteSale::where('sale_order_id', $sale)->first();

        if(!$delivery_no)
        {
            $delivery_no=new DeliveryNote();
            $delivery_no->delivery_note_no=$request->note_no;
            $delivery_no->save();
        }
        if(!$deliverySale)
        {
            $deliverySale=new DeliveryNoteSale();
        }
        $deliverySale->sale_order_id=$sale;
        $deliverySale->delivery_note_id=$delivery_no->id;
        $deliverySale->save();
        foreach($request->items as $key => $value)
        {
            if($request->items[$key]['quantity'] != 0)
            {
                $deliveries=new DeliveryItem;
            $deliveries->delivery_note_id=$delivery_no->id;;
            $deliveries->sale_order_id=$sale;
            $deliveries->sale_order_item_id= $request->items[$key]['id'];
            $deliveries->style_id= $request->items[$key]['style_id'];
            $deliveries->size=$request->items[$key]['size'];
            $deliveries->color_id=$request->items[$key]['color_id'];

            $deliveries->quantity=$request->items[$key]['quantity']==null? 0:$request->items[$key]['quantity'];
            $deliveries->save();
            }

            $stock=StockTransection::where('transection_id',$deliverySale->id)->where('item_id',$request->items[$key]['item_id'])->where('tns_type_code','S')->first();
            $latestStock=StockTransection::latest()->first();
            if(!$stock)
            {
                $stock=new StockTransection();
                $stock->transection_id=$deliverySale->id;
                $stock->item_id=$request->items[$key]['item_id'];
            }
            $stock->quantity=$request->items[$key]['quantity']==null? 0:$request->items[$key]['quantity'];
            $stock->stock_effect = -1 ;
            $stock->tns_type_code="S";
            $stock->tns_description="Sales";
            $stock->save();
        }
        return redirect()->route('updateNote', $invoice)->with('success','Delivery Note Generated');
    }



    public function searchSODNo(Request $request)
    {
        $so=SaleOrder::where('sale_order_no', 'LIKE', "%{$request->value}%")->get();
        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.saleOrderDeliveryNotSearch', ['sales' => $so,'i' =>1])->render()
        ]);
        }
    }


    public function searchSODNoMonth(Request $request)
    {
        $year=substr($request->value, 0, 4);
        $month=substr($request->value, 5, 8);
        $so=SaleOrder::whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->get();
        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.saleOrderDeliveryNotSearch', ['sales' => $so,'i' =>1])->render()
        ]);
        }
    }

    public function searchSODNoDate(Request $request)
    {
        $so=SaleOrder::whereDate('created_at', $request->value)->get();
        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.saleOrderDeliveryNotSearch', ['sales' => $so,'i' =>1])->render()
        ]);
        }
    }

    public function searchSODNoDateRange(Request $request)
    {
        $so=SaleOrder::whereBetween('created_at', [$request->from, $request->to])->get();
        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.saleOrderDeliveryNotSearch', ['sales' => $so,'i' =>1])->render()
        ]);
        }

    }

    public function dnList()
    {
        $dNotes=DeliveryNote::latest()->paginate(60);
        return view('backend.deliveryNote.deliveryNoteList',compact('dNotes'));
    }

    public function deliveryNoteDetails(Request $request,$dnote)
    {
        $deliveryNote=DeliveryNote::find($dnote);
        $saleOrder=$deliveryNote->deliverySale->saleOrder;
        $modes=PayMode::get();
        $terms=PayTerm::get();
        $customers=PartyInfo::get();
        $projects=ProjectDetail::get();
        $itms=ItemList::get();
        $notes=DeliveryNote::all();
        $i=0;
        if(!$saleOrder)
        {
            return back()->with('error', "Not Found");
        }

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.deliveryNoteDetailsView', ['invoice' => $saleOrder,'i' =>1, 'modes'=>$modes, 'terms'=> $terms, 'customers'=>$customers,'projects'=>$projects,'itms'=>$itms,'notes'=>$notes, 'dnote' =>$dnote])->render(),
                                        'dnote'=>$dnote
        ]);
        }
    }




    public function findDNo(Request $request)
    {
        $dNotes=DeliveryNote::where('delivery_note_no', 'LIKE', "%{$request->value}%")->get();
        // $dNotes=DeliveryNoteSale::where('delivery_note_no', 'LIKE', "%{$request->value}%")->get();

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.DeliveryNotFind', ['dNotes' => $dNotes,'i' =>1])->render()
        ]);
        }
    }


    public function findDNoMonth(Request $request)
    {
        $year=substr($request->value, 0, 4);
        $month=substr($request->value, 5, 8);
        $dNotes=DeliveryNote::whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->get();

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.DeliveryNotFind', ['dNotes' => $dNotes,'i' =>1])->render()
        ]);
        }
    }


    public function findDNoDate(Request $request)
    {

        $dNotes=DeliveryNote::whereDate('created_at', $request->value)->get();

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.DeliveryNotFind', ['dNotes' => $dNotes,'i' =>1])->render()
        ]);
        }
    }


    public function findDNoDateRange(Request $request)
    {

        $dNotes=DeliveryNote::whereBetween('created_at', [$request->from, $request->to])->get();

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.DeliveryNotFind', ['dNotes' => $dNotes,'i' =>1])->render()
        ]);
        }
    }

    public function deliverySummery()
    {
        $dNotes=DeliveryNote::latest()->paginate(60);
        return view('backend.deliveryNote.deliverySummary', compact('dNotes'));

    }

    public function deliveryNotesummery($dnote, Request $request)
    {

        $deliveryNote=DeliveryNote::find($dnote);
        // return $deliveryNote;
        $saleOrder=$deliveryNote->deliverySale->saleOrder;
        // return $saleOrder;
        $modes=PayMode::get();
        $terms=PayTerm::get();
        $customers=PartyInfo::get();
        $projects=ProjectDetail::get();
        $itms=ItemList::get();
        $notes=DeliveryNote::all();
        $i=0;
        if(!$saleOrder)
        {
            return back()->with('error', "Not Found");
        }

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.deliverySummery', ['invoice' => $saleOrder,'i' =>1, 'modes'=>$modes, 'terms'=> $terms, 'customers'=>$customers,'projects'=>$projects,'itms'=>$itms,'notes'=>$notes, 'dnote' =>$dnote])->render(),
                                        'dnote'=>$dnote
        ]);
        }

    }

    public function searchDNo(Request $request)
    {
        $dNotes=DeliveryNote::where('delivery_note_no', 'LIKE', "%{$request->value}%")->get();
        // $dNotes=DeliveryNoteSale::where('delivery_note_no', 'LIKE', "%{$request->value}%")->get();

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.DeliveryNotSearchS', ['dNotes' => $dNotes,'i' =>1])->render()
        ]);
        }
    }

    public function searchDNoMonth(Request $request)
    {
        $year=substr($request->value, 0, 4);
        $month=substr($request->value, 5, 8);
        $dNotes=DeliveryNote::whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->get();

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.DeliveryNotSearchS', ['dNotes' => $dNotes,'i' =>1])->render()
        ]);
        }
    }

    public function searchDNoDate(Request $request)
    {

        $dNotes=DeliveryNote::whereDate('created_at', $request->value)->get();

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.DeliveryNotSearchS', ['dNotes' => $dNotes,'i' =>1])->render()
        ]);
        }
    }

    public function searchDNoDateRange(Request $request)
    {

        $dNotes=DeliveryNote::whereBetween('created_at', [$request->from, $request->to])->get();

        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.DeliveryNotSearchS', ['dNotes' => $dNotes,'i' =>1])->render()
        ]);
        }
    }


}
