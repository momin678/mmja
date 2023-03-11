<?php

namespace App\Http\Controllers\backend;
use App\Style;
use App\Brand;
use App\Group;
use App\Branch;
use App\CostCenterType;
use App\DeliveryItem;
use App\DeliveryNote;
use App\DeliveryNoteSale;
use App\Fifo;
use App\FifoInvoice;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceAmount;
use App\InvoiceTemp;
use App\InvoiceItem;
use App\InvoiceItemTemp;
use App\ItemList;
use App\Mapping;
use App\PartyInfo;


use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\SaleInvoice;
use App\SaleOrder;
use App\SaleOrderItem;
use App\Stock;
use App\StockTransection;
use App\TempInvoice;
use Carbon\Carbon;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Stub\ReturnArgument;

class TaxInvoiceController extends Controller
{
      public function taxInvoIssue()
    {
        $delete_invoice_temp = InvoiceTemp::whereDate('created_at', '<', Carbon::today())->delete();
        // dd($delete_item);
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_invoice_no = InvoiceTemp::whereDate('created_at', Carbon::today())->where('invoice_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','desc')->first();

        if ($latest_invoice_no) {
            $invoice_no = $latest_invoice_no->invoice_no + 1;
        } else {
            $invoice_no = Carbon::now()->format('Ymd') . '001';
        }
        $invoice = new InvoiceTemp;
        $invoice->invoice_no = $invoice_no;
        $invoice->save();
        $modes = PayMode::get();
        $terms = PayTerm::get();
        $branches = Branch::get();
        $customers = PartyInfo::get();
        $invoicess = Invoice::where('invoice_from','Counter Sale')->orderBy('id','DESC')->paginate(25);
        $projects = ProjectDetail::get();
        $itms = ItemList::orderBy('barcode','ASC')->get();
        $gl_code = Mapping::where('fld_txn_type', "sale")->first();
        $styles=Style::get();

        $latest = PartyInfo::withTrashed()->orderBy('id','DESC')->first();

        if ($latest) {
            $pi_code = preg_replace('/^PI-/', '', $latest->pi_code);
            ++$pi_code;
        } else {
            $pi_code = 1;
        }
        if ($pi_code < 10) {
            $cc = "PI-000" . $pi_code;
        } elseif ($pi_code < 100) {
            $cc = "PI-00" . $pi_code;
        } elseif ($pi_code < 1000) {
            $cc = "PI-0" . $pi_code;
        } else {
            $cc = "PI-" . $pi_code;
        }
        $costTypes = CostCenterType::get();
        $colors=Brand::get();
        $sizes=Group::get();
        return view('backend.taxInvoice.taxtInvoiceIssue', compact('costTypes', 'cc', 'customers', 'modes', 'terms', 'branches', 'customers', 'invoice', 'invoicess', 'projects', 'itms', 'gl_code','styles','colors','sizes'));
    }



    public function selectItemByTerm(Request $request)
    {
        $item = PartyInfo::where('cc_code', $request->value)->first();
        return $item;
    }

    public function partyInfoInvoice(Request $request)
    {
        $info = PartyInfo::where('pi_code', $request->value)->first();
        return $info;
    }

    public function findDate(Request $request)
    {
        $date =  (new Carbon($request->date))->addDays($request->value)->format('Y-m-d');
        return $date;
    }



      public function findItem(Request $request)
    {
        // return $request->all();
        $item = ItemList::where('barcode', $request->value)->first();
        $vat = 100 - (int)$item->vatRate->value;
        $unit_price = ($item->sell_price / 100) * $vat;
        $fifo = Fifo::where('item_id', $item->id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
        // return $item->total_amount;
        $tempcheck=InvoiceItemTemp::where('item_id', $item->id)->where('invoice_no',$request->invoice_no)->first();

        $items=ItemList::where('style_id',$item->style_id)->where('brand_id',$item->brand_id)->orderBy('group_no','ASC')->get();
        $project = ProjectDetail::where('id', $request->branch)->first();
        $stock= $item->avail_stock? $item->avail_stock->quantity:0;
        if(!$tempcheck)
        {
            if ($request->ajax()) {
                return Response()->json([
                    'page' => view('backend.ajax.colorItem', ['items' => $items, 'i' => 1])->render(),
                    'item' => $item,
                    'unit_price' => $item->total_amount,
                    'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                    'cost_price' => $fifo->unit_cost_price,
                    'stock' => $stock
                ]);
            }
        }
        else
        {
            $total_cost=0;
            $fifo = Fifo::where('item_id', $item->id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                $quantity = $tempcheck->quantity+1;
                $qty= $quantity;
                // return $fifo;
                while ($quantity > 0) {
                    if ($fifo) {
                        if ($fifo->remaining >= $quantity) {
                            $cost = $fifo->unit_cost_price * $quantity;
                            $total_cost = $total_cost + $cost;
                            $quantity = 0;
                        } else {
                            $cost = $fifo->unit_cost_price * $fifo->remaining;
                            $total_cost = $total_cost + $cost;
                            $quantity = $quantity - $fifo->remaining;
                            $fifo = Fifo::where('id', '>', $fifo->id)->where('item_id',$item->id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                        }
                    } else {
                        return Response()->json(['stockout' => 'Not in stock']);
                    }
                }
                $unit_cost_price=$total_cost/$qty;
                if ($request->ajax()) {
                return Response()->json([
                    'page' => view('backend.ajax.colorItem', ['items' => $items, 'i' => 1])->render(),
                    'item' => $item,
                    'unit_price' => $item->total_amount,
                    'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                    'cost_price' => $unit_cost_price,
                    'stock' => $stock
                ]);
            }
        }
    }


     public function findItemId(Request $request)
    {
        // return $request->all();
        $item = ItemList::where('id', $request->value)->first();
        // return $item;
        $vat = 100 - (int)$item->vatRate->value;
        $unit_price = ($item->sell_price / 100) * $vat;
        $fifo = Fifo::where('item_id', $item->id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
        // return $item->total_amount;
        // return $fifo;
        $project = ProjectDetail::where('id', $request->branch)->first();
        $stock= $item->avail_stock? $item->avail_stock->quantity:0;
        $tempcheck=InvoiceItemTemp::where('item_id', $request->value)->where('invoice_no',$request->invoice_no)->first();
        if(!$tempcheck)
        {
            if ($request->ajax()) {
                return Response()->json([
                    'item' => $item,
                    'unit_price' => $item->total_amount,
                    'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                    'cost_price' => $fifo->unit_cost_price,
                    'stock' => $stock
                ]);
            }
        }
        else
        {
            $total_cost=0;
            $fifo = Fifo::where('item_id', $request->value)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                $quantity = $tempcheck->quantity+1;
                $qty= $quantity;
                // return $fifo;
                while ($quantity > 0) {
                    if ($fifo) {
                        if ($fifo->remaining >= $quantity) {
                            $cost = $fifo->unit_cost_price * $quantity;
                            $total_cost = $total_cost + $cost;
                            $quantity = 0;
                        } else {
                            $cost = $fifo->unit_cost_price * $fifo->remaining;
                            $total_cost = $total_cost + $cost;
                            $quantity = $quantity - $fifo->remaining;
                            $fifo = Fifo::where('id', '>', $fifo->id)->where('item_id', $request->value)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                        }
                    } else {
                        return Response()->json(['stockout' => 'Not in stock']);
                    }
                }
                $unit_cost_price=$total_cost/$qty;
                if ($request->ajax()) {
                return Response()->json([
                    'item' => $item,
                    'unit_price' => $item->total_amount,
                    'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                    'cost_price' => $unit_cost_price,
                    'stock' => $stock
                ]);
            }
        }
    }

     public function findItemColor(Request $request)
    {

        $items=ItemList::where('style_id',$request->style)->where('brand_id',$request->color)->orderBy('group_no','ASC')->get();


        if ($request->ajax()) {


                return Response()->json([
                    'page' => view('backend.ajax.colorItem', ['items' => $items, 'i' => 1])->render()
                ]);
        }

        return back();

    }


    public function findItemIdedit(Request $request)
    {
        $total_cost = 0;
        $qty=1;
        $item = ItemList::where('id', $request->value)->first();
        $vat = 100 - (int)$item->vatRate->value;
        $unit_price = ($item->sell_price / 100) * $vat;
        $invoice_tempQ=InvoiceItemTemp::where('invoice_no',$request->invoice_no)->where('item_id',$request->value)->first();
        $invoice_itemQ=InvoiceItem::where('invoice_no',$request->invoice_no)->where('item_id',$request->value)->first();
        // return $item->total_amount;
        $invoice=Invoice::where('invoice_no',$request->invoice_no)->first();
        // return $invoice;
        if($invoice_tempQ)
        {
            $qty=$invoice_tempQ->quantity+$qty;
        }
        if($invoice_itemQ)
        {
            $total_cost_price=$invoice_itemQ->purchase_price*$invoice_itemQ->quantity;

            if($qty>$invoice_itemQ->quantity)
            {
                $fifo = Fifo::where('item_id', $request->value)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                $quantity = $qty-$invoice_itemQ->quantity;
                // return $fifo;
                while ($quantity > 0) {
                    if ($fifo) {
                        if ($fifo->remaining >= $quantity) {
                            $cost = $fifo->unit_cost_price * $quantity;
                            $total_cost = $total_cost + $cost;
                            $quantity = 0;
                        } else {
                            $cost = $fifo->unit_cost_price * $fifo->remaining;
                            $total_cost = $total_cost + $cost;
                            $quantity = $quantity - $fifo->remaining;
                            $fifo = Fifo::where('id', '>', $fifo->id)->where('item_id', $request->value)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                        }
                    } else {
                        return Response()->json(['stockout' => 'Not in stock']);
                    }
                }

                $total_cost_price=$total_cost_price+$total_cost;
                $unit_cost_price=$total_cost_price/$qty;
                if ($request->ajax()) {
                return Response()->json([
                    'item' => $item,
                    'unit_price' => $item->total_amount,
                    'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                    'cost_price' => $unit_cost_price
                ]);
            }
            }
            else
            {
                $quantity = $invoice_itemQ->quantity-$qty;
                // return $quantity;
                $invoice_items_fifo=FifoInvoice::where('invoice_id',$invoice->id)->where('item_id',$request->value)->orderBy('id','desc')->first();

                $mcost=0;
                // return $quantity;
                while($quantity>0)
                {
                        if($invoice_items_fifo->quantity>$quantity)
                        {
                            $mcost2=$invoice_items_fifo->fifo->unit_cost_price*$quantity;
                            $mcost=$mcost+$mcost2;
                            $quantity=0;
                        }
                        else
                        {

                            $mcost2=$invoice_items_fifo->fifo->unit_cost_price*$invoice_items_fifo->quantity;
                            $quantity=$quantity-$invoice_items_fifo->quantity;
                            $invoice_items_fifo=FifoInvoice::where('id','<',$invoice_items_fifo->id)->where('invoice_id',$invoice->id)->where('item_id',$request->value)->orderBy('id','desc')->first();
                            $mcost=$mcost+$mcost2;
                        }
                }
                // return $mcost;
                $total_cost_price=$total_cost_price-$mcost;
                // return $total_cost_price;
                $unit_cost_price=$total_cost_price/$qty;
                if ($request->ajax()) {
                    return Response()->json([
                        'item' => $item,
                        'unit_price' => $item->total_amount,
                        'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                        'cost_price' => $unit_cost_price
                    ]);
                }
            }
        }
        else
        {
            $fifo = Fifo::where('item_id', $item->id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();

            if ($request->ajax()) {
                return Response()->json([
                    'item' => $item,
                    'unit_price' => $item->total_amount,
                    'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                    'cost_price' => $fifo->unit_cost_price
                ]);
            }
        }

    }

    public function findItemEdit(Request $request)
    {
        $total_cost = 0;
        $qty=1;
        $item = ItemList::where('barcode', $request->value)->first();

        $invoice_tempQ=InvoiceItemTemp::where('invoice_no',$request->invoice_no)->where('item_id',$item->id)->first();
        $invoice_itemQ=InvoiceItem::where('invoice_no',$request->invoice_no)->where('item_id',$item->id)->first();
        // return $item->total_amount;
        $invoice=Invoice::where('invoice_no',$request->invoice_no)->first();
        // return $invoice;
        if($invoice_itemQ)
        {
            $total_cost_price=$invoice_itemQ->purchase_price*$invoice_itemQ->quantity;

            if($invoice_tempQ)
            {
                $qty=$invoice_tempQ->quantity+$qty;
            }
            // return $qty;
            if($qty>$invoice_itemQ->quantity)
            {
                $fifo = Fifo::where('item_id', $item->id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                $quantity = $qty-$invoice_itemQ->quantity;
                // return $fifo;
                while ($quantity > 0) {
                    if ($fifo) {
                        if ($fifo->remaining >= $quantity) {
                            $cost = $fifo->unit_cost_price * $quantity;
                            $total_cost = $total_cost + $cost;
                            $quantity = 0;
                        } else {
                            $cost = $fifo->unit_cost_price * $fifo->remaining;
                            $total_cost = $total_cost + $cost;
                            $quantity = $quantity - $fifo->remaining;
                            $fifo = Fifo::where('id', '>', $fifo->id)->where('item_id', $item->id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                        }
                    } else {
                        return Response()->json(['stockout' => 'Not in stock']);
                    }
                }

                $total_cost_price=$total_cost_price+$total_cost;
                $unit_cost_price=$total_cost_price/$qty;
                if ($request->ajax()) {
                return Response()->json([
                    'item' => $item,
                    'unit_price' => $item->total_amount,
                    'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                    'cost_price' => $unit_cost_price
                ]);
            }
            }
            else
            {
                $quantity = $invoice_itemQ->quantity-$qty;
                // return $quantity;
                $invoice_items_fifo=FifoInvoice::where('invoice_id',$invoice->id)->where('item_id',$item->id)->orderBy('id','desc')->first();
                // return $invoice_items_fifo->quantity;
                $mcost=0;
                while($quantity>0)
                {
                        if($invoice_items_fifo->quantity>$quantity)
                        {
                            $mcost2=$invoice_items_fifo->fifo->unit_cost_price*$quantity;
                            $mcost=$mcost+$mcost2;
                            $quantity=0;
                        }
                        else
                        {
                            $mcost2=$invoice_items_fifo->fifo->unit_cost_price*$invoice_items_fifo->quantity;
                            $quantity=$quantity-$invoice_items_fifo->quantity;
                            $invoice_items_fifo=FifoInvoice::where('id','<',$invoice_items_fifo->id)->where('invoice_id',$invoice->id)->where('item_id',$item->id)->orderBy('id','desc')->first();
                            $mcost=$mcost+$mcost2;
                        }
                }
                // return $mcost;
                $total_cost_price=$total_cost_price-$mcost;
                // return $total_cost_price;
                $unit_cost_price=$total_cost_price/$qty;
                if ($request->ajax()) {
                    return Response()->json([
                        'item' => $item,
                        'unit_price' => $item->total_amount,
                        'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                        'cost_price' => $unit_cost_price
                    ]);
                }
            }
        }
        else
        {
            $fifo = Fifo::where('item_id', $item->id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();

            if ($request->ajax()) {
                return Response()->json([
                    'item' => $item,
                    'unit_price' => $item->total_amount,
                    'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                    'cost_price' => $fifo->unit_cost_price
                ]);
            }
        }
    }


    public function tempInvoice(Request $request)
    {

        if (!$request->branch) {
            if ($request->ajax()) {
                return Response()->json(['fail' => 'Branch is required']);
            }
        }
        $project = ProjectDetail::where('id', $request->branch)->first();
        $itm = ItemList::where('id', $request->item_name)->first();
        $temp = InvoiceItemTemp::where('invoice_no', $request->invoice_no)->where('item_id', $itm->id)->first();
        $checkStock = $itm->avail_stock? $itm->avail_stock->quantity:0;
        $vat = 100 - (int)$itm->vatRate->value;
        $invoice_temp=InvoiceTemp::where('invoice_no',$request->invoice_no)->first();

        // return $checkStock;
        if (!$temp) {
            if ($checkStock < $request->quantity) {
                if ($request->ajax()) {
                    return Response()->json(['stockout' => 'Stock Out']);
                }
            }

            $temp = new InvoiceItemTemp();
            $temp->invoice_no = $request->invoice_no;
            $temp->barcode = $itm->barcode;
            $temp->item_id = $itm->id;
            $temp->style_id = $itm->style_id;
            $temp->size = $itm->group_no;
            $temp->color_id = $itm->brand_id;
            $temp->quantity = $request->quantity;
            $temp->vat_rate = $itm->vatRate->value;
            $temp->unit = $itm->unit;
            $temp->cost_price = $itm->total_amount * $temp->quantity;
            $temp->unit_price = $itm->sell_price;
            $temp->net_amount = $temp->unit_price * $temp->quantity;
            $temp->total_unit_price = $temp->unit_price * $temp->quantity;
            $temp->vat_amount = $temp->cost_price - ($temp->unit_price * $temp->quantity);
            $temp->purchase_price = $request->cost_price;
        } else {
            if ($checkStock < ($temp->quantity + $request->quantity)) {
                if ($request->ajax()) {
                    return Response()->json(['stockout' => 'Not in stock']);
                }
            }
            $temp->quantity = $temp->quantity + $request->quantity;
            $temp->cost_price = $itm->total_amount * $temp->quantity;
            $temp->unit_price = $itm->sell_price;
            $temp->net_amount = $temp->unit_price * $temp->quantity;
            $temp->total_unit_price = $temp->unit_price * $temp->quantity;
            $temp->vat_amount = $temp->cost_price - ($temp->unit_price * $temp->quantity);
            $temp->purchase_price = $request->cost_price;

        }
        $temp->save();

        $total_cost_price = InvoiceItemTemp::where('invoice_no', $request->invoice_no)->sum('cost_price');
        $total_unit_price = InvoiceItemTemp::where('invoice_no', $request->invoice_no)->sum('total_unit_price');
        $total_vat_amount = InvoiceItemTemp::where('invoice_no', $request->invoice_no)->sum('vat_amount');
        $invoice_draft = InvoiceTemp::where('invoice_no', $request->invoice_no)->orderBy('id','DESC')->first();
        $t_qty=$invoice_temp->quantity();

        if ($request->ajax()) {

            if ($total_cost_price < 10000) {
                return Response()->json([
                    'page' => view('backend.ajax.invoice', ['invoice_draft' => $invoice_draft, 'i' => 1])->render(),
                    'total_cost_price' => number_format((float)($total_cost_price), 2, '.', ''),
                    'total_unit_price' => number_format((float)($total_unit_price), 2, '.', ''),
                    'total_vat_amount' => number_format((float)($total_vat_amount), 2, '.', ''),
                    't_qty' => $t_qty
                ]);
            } else {
                return Response()->json([
                    'page' => view('backend.ajax.invoice2', ['invoice_draft' => $invoice_draft, 'i' => 1])->render(),
                    'total_cost_price' => number_format((float)($total_cost_price), 2, '.', ''),
                    'total_unit_price' => number_format((float)($total_unit_price), 2, '.', ''),
                    'total_vat_amount' => number_format((float)($total_vat_amount), 2, '.', ''),
                    't_qty' => $t_qty
                ]);
            }
        }
    }


    public function tempInvoiceedit(Request $request)
    {

        if (!$request->branch) {
            if ($request->ajax()) {
                return Response()->json(['fail' => 'Branch is required']);
            }
        }
        $project = ProjectDetail::where('id', $request->branch)->first();
        $itm = ItemList::where('id', $request->item_name)->first();
        $temp = InvoiceItemTemp::where('invoice_no', $request->invoice_no)->where('item_id', $itm->id)->first();
        $checkStock = $project->stockCheck($project->id, $itm->id);
        $vat = 100 - (int)$itm->vatRate->value;
        if (!$temp) {
            if ($checkStock < $request->quantity) {
                if ($request->ajax()) {
                    return Response()->json(['stockout' => 'Stock Out']);
                }
            }

            $temp = new InvoiceItemTemp();
            $temp->invoice_no = $request->invoice_no;
            $temp->barcode = $itm->barcode;
            $temp->item_id = $itm->id;
            $temp->style_id = $itm->style_id;
            $temp->size = $itm->group_no;
            $temp->color_id = $itm->brand_id;
            $temp->quantity = $request->quantity;
            $temp->vat_rate = $itm->vatRate->value;
            $temp->unit = $itm->unit;
            $temp->cost_price = $itm->total_amount * $temp->quantity;
            $temp->unit_price = $itm->sell_price;
            $temp->net_amount = $temp->unit_price * $temp->quantity;
            $temp->total_unit_price = $temp->unit_price * $temp->quantity;
            $temp->vat_amount = $temp->cost_price - ($temp->unit_price * $temp->quantity);
            $temp->purchase_price = $request->cost_price;
        } else {
            if ($checkStock < ($temp->quantity + $request->quantity)) {
                if ($request->ajax()) {
                    return Response()->json(['stockout' => 'Not in stock']);
                }
            }
            $temp->quantity = $temp->quantity + $request->quantity;
            $temp->cost_price = $itm->total_amount * $temp->quantity;
            $temp->unit_price = $itm->sell_price;
            $temp->net_amount = $temp->unit_price * $temp->quantity;
            $temp->total_unit_price = $temp->unit_price * $temp->quantity;
            $temp->vat_amount = $temp->cost_price - ($temp->unit_price * $temp->quantity);
            $temp->purchase_price = $request->cost_price;

        }
        $temp->save();

        $total_cost_price = InvoiceItemTemp::where('invoice_no', $request->invoice_no)->sum('cost_price');
        $total_unit_price = InvoiceItemTemp::where('invoice_no', $request->invoice_no)->sum('total_unit_price');
        $total_vat_amount = InvoiceItemTemp::where('invoice_no', $request->invoice_no)->sum('vat_amount');
        $invoice_draft = InvoiceTemp::where('invoice_no', $request->invoice_no)->orderBy('id','DESC')->first();
        if ($request->ajax()) {

            if ($total_cost_price < 10000) {
                return Response()->json([
                    'page' => view('backend.ajax.invoice', ['invoice_draft' => $invoice_draft, 'i' => 1])->render(),
                    'total_cost_price' => number_format((float)($total_cost_price), 2, '.', ''),
                    'total_unit_price' => number_format((float)($total_unit_price), 2, '.', ''),
                    'total_vat_amount' => number_format((float)($total_vat_amount), 2, '.', '')
                ]);
            } else {
                return Response()->json([
                    'page' => view('backend.ajax.invoice2', ['invoice_draft' => $invoice_draft, 'i' => 1])->render(),
                    'total_cost_price' => number_format((float)($total_cost_price), 2, '.', ''),
                    'total_unit_price' => number_format((float)($total_unit_price), 2, '.', ''),
                    'total_vat_amount' => number_format((float)($total_vat_amount), 2, '.', '')
                ]);
            }
        }
    }

    public function previewSaveInvoice(Request $request)
    {

        $invoice = InvoiceTemp::where('invoice_no', $request->invoice_no)->orderBy('id','DESC')->first();


        $invoice->date = $request->date;
        $invoice->project_id = $request->branch;
        $invoice->customer_name = $request->customer_name;
        $invoice->trn_no = $request->trn_no;
        $invoice->pay_mode = $request->pay_mode;
        $invoice->pay_terms = $request->pay_terms;
        $invoice->due_date = $request->due_date;
        $invoice->contact_no = $request->contact_no;
        $invoice->address = $request->address;
        $invoice->save();
        $amountFrom=$request->amount_from;
        $amountTo=$request->amount_to;


        return redirect()->route('invoicePreview', [$invoice,$amountFrom,$amountTo])->with('success', 'Invoice Preview');
    }

    public function invoicePreview($invoice,$amountFrom,$amountTo)
    {

        $invoice=InvoiceTemp::where('id',$invoice)->first();
        if(!$invoice)
        {
            return redirect()->route('taxInvoIssue')->with('error', 'Page Not Found');

        }
        $items=InvoiceItemTemp::where('invoice_no',$invoice->invoice_no)->orderBy('barcode','ASC')->get();
        $modes = PayMode::get();
        $terms = PayTerm::get();
        $branches = Branch::get();
        $customers = PartyInfo::get();
        $invoicess = Invoice::where('invoice_from','Counter Sale')->orderBy('id','DESC')->paginate(25);
        $projects = ProjectDetail::get();
        $gl_code = Mapping::where('fld_txn_type', "sale")->first();

        $i=1;
        return view('backend.taxInvoice.invoicePreview',compact('invoice','items','modes','terms','branches','customers','invoicess','projects','i','amountFrom','amountTo'));

    }


    public function updatePreviewInv($invoice)
    {

        $invoice=InvoiceTemp::where('id',$invoice)->first();
        if(!$invoice)
        {
            return redirect()->route('taxInvoIssue')->with('error', 'Page Not Found');

        }
        $items=InvoiceItemTemp::where('invoice_no',$invoice->invoice_no)->orderBy('barcode','ASC')->get();
        $modes = PayMode::get();
        $terms = PayTerm::get();
        $branches = Branch::get();
        $customers = PartyInfo::get();
        $invoicess = Invoice::where('invoice_from','Counter Sale')->orderBy('id','DESC')->paginate(25);
        $projects = ProjectDetail::get();
        $gl_code = Mapping::where('fld_txn_type', "sale")->first();
        $itms = ItemList::orderBy('barcode','ASC')->get();
        $latest = PartyInfo::withTrashed()->orderBy('id','DESC')->first();

        if ($latest) {
            $pi_code = preg_replace('/^PI-/', '', $latest->pi_code);
            ++$pi_code;
        } else {
            $pi_code = 1;
        }
        if ($pi_code < 10) {
            $cc = "PI-000" . $pi_code;
        } elseif ($pi_code < 100) {
            $cc = "PI-00" . $pi_code;
        } elseif ($pi_code < 1000) {
            $cc = "PI-0" . $pi_code;
        } else {
            $cc = "PI-" . $pi_code;
        }
        $costTypes = CostCenterType::get();
        $i=1;
       $styles=Style::get();
        $colors=Brand::get();
        $sizes=Group::get();
        return view('backend.taxInvoice.invoicePreviewUpdate',compact('sizes','colors','styles','invoice','items','modes','terms','branches','customers','invoicess','projects','i','itms','cc','costTypes'));

    }


    public function finalSaveInvoice(Request $request)
    {
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_invoice_no = Invoice::whereDate('created_at', Carbon::today())->where('invoice_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();

        if ($latest_invoice_no) {
            $invoice_no = $latest_invoice_no->invoice_no + 1;
        } else {
            $invoice_no = Carbon::now()->format('Ymd') . '001';
        }
        $gl_code = Mapping::where('fld_txn_type', "sale")->first();

            $invoice = new Invoice;
            $invoice->invoice_no =  $invoice_no;

        $invoice->date = $request->date;
        $invoice->project_id = $request->branch;
        $invoice->customer_name = $request->customer_name;
        $invoice->trn_no = $request->trn_no;
        $invoice->pay_mode = $request->pay_mode;
        $invoice->pay_terms = $request->pay_terms;
        $invoice->due_date = $request->due_date;
        $invoice->contact_no = $request->contact_no;
        $invoice->address = $request->address;
        $invoice->gl_code = $gl_code ? $gl_code->fld_ac_code : null;
        $invoice->invoice_from = "Counter Sale";

        $invoice->save();
        $items = InvoiceItemTemp::where('invoice_no', $request->invoice_no)->get();
        foreach ($items as $item) {
            $invoice_item = new InvoiceItem;
            $invoice_item->invoice_no =  $invoice_no;
            $invoice_item->invoice_id = $invoice->id;
            $invoice_item->barcode = $item->barcode;
            $invoice_item->item_id = $item->item_id;
            $invoice_item->style_id = $item->style_id;
            $invoice_item->size = $item->size;
            $invoice_item->color_id = $item->color_id;
            $invoice_item->net_amount = 1;
            $invoice_item->quantity = $item->quantity;
            $invoice_item->vat_rate = $item->vat_rate;
            $invoice_item->vat_amount = $item->vat_amount;
            $invoice_item->unit = $item->unit;
            $invoice_item->total_unit_price = $item->total_unit_price;
            $invoice_item->cost_price = $item->cost_price;
            $invoice_item->unit_price = $item->unit_price;
            $invoice_item->purchase_price = $item->purchase_price;
            $invoice_item->save();
            
              $newStock=Stock::where('item_id',$item->item_id)->first();
            $newStock->quantity=$newStock->quantity-$item->quantity;
            $newStock->save();

            $stock = new StockTransection();
            $stock->transection_id = $invoice->id;
            $stock->item_id = $item->item_id;
            $stock->date = $request->date;
            $stock->quantity = $item->quantity;
            $stock->stock_effect = -1;
            $stock->tns_type_code = "S";
            $stock->tns_description = "Sales";
            $stock->cost_price = $item->cost_price;
            $stock->purchase_rate = $item->purchase_price;;

            $stock->save();
            $fifo = Fifo::where('item_id', $item->item_id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
            $quantity = $item->quantity;
            while ($quantity > 0) {
                if ($fifo) {
                    if ($fifo->remaining >= $quantity) {
                        $fifo->consumed = $fifo->consumed + $quantity;
                        $fifo->remaining = $fifo->remaining - $quantity;

                        $fifo->save();
                        $fifo_invoice = new FifoInvoice();
                        $fifo_invoice->fifo_id = $fifo->id;
                        $fifo_invoice->invoice_id =  $invoice->id;
                        $fifo_invoice->item_id = $item->item_id;
                        $fifo_invoice->delivery_note_id = 0;
                        $fifo_invoice->quantity =$quantity;
                        $fifo_invoice->save();
                        $quantity = 0;
                    } else {

                        $fifo->consumed = $fifo->consumed + $fifo->remaining;
                        $quantity = $quantity - $fifo->remaining;
                        $inQty=$fifo->remaining;

                        $fifo->remaining = 0;
                        $fifo->save();
                        $fifo_invoice = new FifoInvoice();
                        $fifo_invoice->fifo_id = $fifo->id;
                        $fifo_invoice->invoice_id = $invoice->id;
                        $fifo_invoice->item_id = $item->item_id;
                        $fifo_invoice->delivery_note_id = 0;
                        $fifo_invoice->quantity =$inQty;

                        $fifo_invoice->save();

                        $fifo = Fifo::where('id', '>', $fifo->id)->where('item_id', $item->item_id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                    }
                }
            }

        }
        if ($request->amount_from != null) {
            $invoiceAmount = new InvoiceAmount;
            $invoiceAmount->invoice_id = $invoice->id;
            $invoiceAmount->amount_from = $request->amount_from;
            $invoiceAmount->amount_to = $request->amount_from - number_format((float)($invoice->grossTotal($invoice->invoice_no)), '2', '.', '');
            $invoiceAmount->save();
        }
        // InvoiceItemTemp::where('invoice_no', $request->invoice_no)->delete();
        // InvoiceTemp::where('invoice_no', $request->invoice_no)->delete();
        return redirect()->route('invoiceView', $invoice)->with('success', 'Succesfully Generated');
    }


    public function invoicess()
    {
        $invoicess = Invoice::orderBy('id','DESC')->get();
        return view('backend.taxInvoice.invoicess', compact('invoicess'));
    }

    public function invoicePrint($invoice)
    {
        $invoice = Invoice::where('id', $invoice)->first();
        if ($invoice->taxbleSup($invoice->invoice_no) > 9999) {
            return view('backend.pdf.invoice', compact('invoice'));
        } else {
            return view('backend.pdf.invoice2', compact('invoice'));
        }
    }


    public function itemDelete($item, Request $request)
    {
        $itm = InvoiceItemTemp::where('id', $item)->first();
        $invoice_no = $itm->invoice_no;
        $itm->delete();
        $total_cost_price = InvoiceItemTemp::where('invoice_no', $invoice_no)->sum('cost_price');
        $total_unit_price = InvoiceItemTemp::where('invoice_no', $invoice_no)->sum('total_unit_price');
        $total_vat_amount = InvoiceItemTemp::where('invoice_no', $invoice_no)->sum('vat_amount');
        $invoice_draft = InvoiceTemp::where('invoice_no', $invoice_no)->orderBy('id','DESC')->first();
        $t_qty=$invoice_draft->quantity();

        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.invoice', ['invoice_draft' => $invoice_draft, 'i' => 1])->render(),
                'total_cost_price' => $total_cost_price,
                'total_unit_price' => $total_unit_price,
                'total_vat_amount' => $total_vat_amount,
                't_qty' => $t_qty
            ]);
        }
    }


    public function refresh_invoice(Request $request)
    {
        $invoicess = Invoice::where('invoice_from','Counter Sale')->orderBy('id','DESC')->paginate(25);
        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.invoiceRight', ['invoicess' => $invoicess, 'i' => 1])->render()
            ]);
        }
    }

    public function invoiceView($invoice)
    {
        $invoice = Invoice::where('id', $invoice)->first();
        $modes = PayMode::get();
        $terms = PayTerm::get();
        $branches = Branch::get();
        $customers = PartyInfo::get();
        $invoicess = Invoice::where('invoice_from','Counter Sale')->orderBy('id','DESC')->paginate(25);
        $projects = ProjectDetail::get();
        $itms = ItemList::get();
        $i = 0;
        return view('backend.taxInvoice.invoiceView', compact('invoice', 'modes', 'terms', 'branches', 'customers', 'invoicess', 'projects', 'itms', 'i'));
    }


    public function saleinvoiceView(Request $request, $invoice)
    {
        $invoice = Invoice::where('id', $invoice)->first();
        $modes = PayMode::get();
        $terms = PayTerm::get();
        $branches = Branch::get();
        $customers = PartyInfo::get();
        $invoicess = Invoice::where('invoice_from','Counter Sale')->orderBy('id','DESC')->paginate(25);
        $projects = ProjectDetail::get();
        $itms = ItemList::get();
        $i = 0;
        // return view('backend.taxInvoice.invoiceView', compact('invoice', 'modes', 'terms', 'branches', 'customers', 'invoicess', 'projects', 'itms', 'i'));
        if ($request->ajax()) {
            return Response()->json(['page' => view('backend.ajax.saleinvoiceView',compact('invoice', 'modes', 'terms', 'branches', 'customers', 'invoicess', 'projects', 'itms', 'i'))->render()
        ]);
        }

    }

    public function invoiceView2($invoice)
    {
        $invoice = Invoice::where('id', $invoice)->first();
        $modes = PayMode::get();
        $terms = PayTerm::get();
        $branches = Branch::get();
        $customers = PartyInfo::get();
        $invoicess = Invoice::where('invoice_from','Counter Sale')->orderBy('id','DESC')->paginate(25);
        $projects = ProjectDetail::get();
        $itms = ItemList::get();
        $i = 0;
        return view('backend.taxInvoice.invoiceView2', compact('invoice', 'modes', 'terms', 'branches', 'customers', 'invoicess', 'projects', 'itms', 'i'));
    }



    public function invoiceEdit($invoice)
    {
        $invoice = Invoice::where('id', $invoice)->first();
        $modes = PayMode::get();
        $terms = PayTerm::get();
        $branches = Branch::get();
        $customers = PartyInfo::get();
        $invoicess = Invoice::where('invoice_from','Counter Sale')->orderBy('id','DESC')->paginate(25);
        $projects = ProjectDetail::get();
        $itms = ItemList::orderBy('barcode','ASC')->get();
        $i = 0;
        InvoiceItemTemp::where('invoice_no', $invoice->invoice_no)->forceDelete();

        $invoice_temp = InvoiceTemp::where('invoice_no', $invoice->invoice_no)->first();
        if (!$invoice_temp) {
            $invoice_temp = new InvoiceTemp;
            $invoice_temp->invoice_no = $invoice->invoice_no;
            $invoice_temp->save();
        }
        $items = InvoiceItem::where('invoice_no', $invoice->invoice_no)->get();
        foreach ($items as $item) {
            $item_temp = new InvoiceItemTemp;
            $item_temp->invoice_no = $item->invoice_no;
            $item_temp->barcode = $item->barcode;
            $item_temp->item_id = $item->item_id;
            $item_temp->style_id = $item->style_id;
            $item_temp->size = $item->size;
            $item_temp->color_id = $item->color_id;
            $item_temp->net_amount = 1;
            $item_temp->quantity = $item->quantity;
            $item_temp->vat_rate = $item->vat_rate;
            $item_temp->vat_amount = $item->vat_amount;
            $item_temp->unit = $item->unit;
            $item_temp->total_unit_price = $item->total_unit_price;
            $item_temp->cost_price = $item->cost_price;
            $item_temp->unit_price = $item->unit_price;
            $item_temp->purchase_price = $item->purchase_price;
            $item_temp->save();
        }
        return view('backend.taxInvoice.invoiceEdit', compact('invoice', 'modes', 'terms', 'branches', 'customers', 'invoicess', 'projects', 'itms', 'i'));
    }


    public function finalSaveInvoiceUpdate(Request $request, $invoice)
    {
        dd('Not Available');
        $invoice = Invoice::where('id', $invoice)->first();
        if (!$invoice) {
            $invoice = new Invoice;
            $invoice->invoice_no = $request->invoice_no;
        }
        $invoice->date = $request->date;
        $invoice->project_id = $request->branch;
        $invoice->customer_name = $request->customer_name;
        $invoice->trn_no = $request->trn_no;
        $invoice->pay_mode = $request->pay_mode;
        $invoice->pay_terms = $request->pay_terms;
        $invoice->due_date = $request->due_date;
        $invoice->contact_no = $request->contact_no;
        $invoice->address = $request->address;
        $invoice->save();
        $stock_trans_updt=StockTransection::where('tns_type_code','S')->where('transection_id',$invoice->id)->get();
        foreach($stock_trans_updt as $st_up)
        {
            $st_up->date=$request->date;
            $st_up->save();
        }
        $itemCheck=InvoiceItem::where('invoice_id',$invoice->id)->get();
        foreach($itemCheck as $check)
        {
            $invoice_temp_check=InvoiceItemTemp::where('invoice_no',$check->invoice_no)->where('item_id', $check->item_id)->first();
            if(!$invoice_temp_check)
            {
                $stock = StockTransection::where('transection_id', $invoice->id)->where('item_id', $check->item_id)->where('tns_type_code','S')->forceDelete();

                $fifoInvItm=FifoInvoice::where('invoice_id',$invoice->id)->where('item_id',$check->item_id)->get();
                foreach($fifoInvItm as $checkItm)
                {
                    $fifoUpdate=$checkItm->fifo;
                    $fifoUpdate->consumed=$fifoUpdate->consumed-$checkItm->quantity;
                    $fifoUpdate->remaining=$fifoUpdate->remaining+$checkItm->quantity;
                    $fifoUpdate->save();
                    $checkItm->forceDelete();
                }
                $check->forceDelete();
            }
        }
        $items = InvoiceItemTemp::where('invoice_no', $invoice->invoice_no)->get();
        foreach ($items as $item) {
            $itemCheck=InvoiceItem::where('invoice_no',$item->invoice_no)->where('item_id',$item->item_id)->first();
            // dd($itemCheck);
            if($itemCheck)
            {
                if( $itemCheck->quantity<$item->quantity)
                {
                    $fifo = Fifo::where('item_id', $item->item_id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                        $quantity = $item->quantity-$itemCheck->quantity;
                        while ($quantity > 0) {
                        if ($fifo) {
                            if ($fifo->remaining >= $quantity) {
                                $fifo->consumed = $fifo->consumed + $quantity;
                                $fifo->remaining = $fifo->remaining - $quantity;
                                $fifo->save();
                                $fifo_invoice = new FifoInvoice();
                                $fifo_invoice->fifo_id = $fifo->id;
                                $fifo_invoice->invoice_id =  $invoice->id;
                                $fifo_invoice->item_id = $item->item_id;
                                $fifo_invoice->delivery_note_id = 0;
                                $fifo_invoice->quantity =$quantity;
                                $fifo_invoice->save();
                                $quantity = 0;
                            } else {

                                $fifo->consumed = $fifo->consumed + $fifo->remaining;
                                $quantity = $quantity - $fifo->remaining;
                                $inQty=$fifo->remaining;
                                $fifo->remaining = 0;
                                $fifo->save();
                                $fifo_invoice = new FifoInvoice();
                                $fifo_invoice->fifo_id = $fifo->id;
                                $fifo_invoice->invoice_id = $invoice->id;
                                $fifo_invoice->item_id = $item->item_id;
                                $fifo_invoice->delivery_note_id = 0;
                                $fifo_invoice->quantity =$inQty;
                                $fifo_invoice->save();
                                $fifo = Fifo::where('id', '>', $fifo->id)->where('item_id', $item->item_id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                            }
                        }
                    }
                }

                else
                {
                    $fifoInvItm=FifoInvoice::where('invoice_id',$invoice->id)->where('item_id',$item->item_id)->orderBy('fifo_id','desc')->first();
                    $quantity=$itemCheck->quantity-$item->quantity;
                    // dd($quantity);
                    while($quantity>0)
                    {
                        if($fifoInvItm)
                        {
                            if($fifoInvItm->quantity>=$quantity)
                            {
                                $ff=$fifoInvItm->fifo;
                                $ff->consumed=$ff->consumed-$quantity;
                                $ff->remaining=$ff->remaining+$quantity;
                                $ff->save();

                                if($fifoInvItm->quantity-$quantity==0)
                                {
                                    $fifoInvItm->forceDelete();
                                }
                                else
                                {
                                    $fifoInvItm->quantity=$fifoInvItm->quantity-$quantity;
                                    $fifoInvItm->save();
                                }
                                $quantity=0;
                            }
                            else
                            {
                                $ff=$fifoInvItm->fifo;
                                $ff->consumed=$ff->consumed-$fifoInvItm->quantity;
                                $ff->remaining=$ff->remaining+$fifoInvItm->quantity;
                                $ff->save;
                                $ff_id=$fifoInvItm->fifo_id;
                                $rQty=$fifoInvItm->quantity;
                                $hulu =$fifoInvItm->forceDelete();

                                $quantity=$quantity-$rQty;
                                $fifoInvItm=FifoInvoice::where('fifo_id','<',$ff_id)->where('invoice_id',$invoice->id)->where('item_id',$item->item_id)->orderBy('fifo_id','DESC')->first();

                            }
                        }
                    }

                }


                $itemCheck->invoice_no = $item->invoice_no;
                $itemCheck->invoice_id = $invoice->id;
                $itemCheck->barcode = $item->barcode;
                $itemCheck->item_id = $item->item_id;
                $itemCheck->style_id = $item->style_id;
                $itemCheck->size = $item->size;
                $itemCheck->color_id = $item->color_id;
                $itemCheck->net_amount = 1;
                $itemCheck->quantity = $item->quantity;
                $itemCheck->vat_rate = $item->vat_rate;
                $itemCheck->vat_amount = $item->vat_amount;
                $itemCheck->unit = $item->unit;
                $itemCheck->total_unit_price = $item->total_unit_price;
                $itemCheck->cost_price = $item->cost_price;
                $itemCheck->unit_price = $item->unit_price;
                $itemCheck->unit_price = $item->unit_price;
                $itemCheck->purchase_price = $item->purchase_price;
                $itemCheck->save();
            }
            else
            {
                $invoice_item = new InvoiceItem;
            $invoice_item->invoice_no = $item->invoice_no;
            $invoice_item->invoice_id = $invoice->id;
            $invoice_item->barcode = $item->barcode;
            $invoice_item->item_id = $item->item_id;
            $invoice_item->style_id = $item->style_id;
            $invoice_item->size = $item->size;
            $invoice_item->color_id = $item->color_id;
            $invoice_item->net_amount = 1;
            $invoice_item->quantity = $item->quantity;
            $invoice_item->vat_rate = $item->vat_rate;
            $invoice_item->vat_amount = $item->vat_amount;
            $invoice_item->unit = $item->unit;
            $invoice_item->total_unit_price = $item->total_unit_price;
            $invoice_item->cost_price = $item->cost_price;
            $invoice_item->unit_price = $item->unit_price;
            $invoice_item->unit_price = $item->unit_price;
            $invoice_item->purchase_price = $item->purchase_price;
            $invoice_item->save();
            $fifo = Fifo::where('item_id', $item->item_id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
            $quantity = $item->quantity;
            while ($quantity > 0) {
                if ($fifo) {
                    if ($fifo->remaining >= $quantity) {
                        $fifo->consumed = $fifo->consumed + $quantity;
                        $fifo->remaining = $fifo->remaining - $quantity;
                        $fifo->save();
                        $fifo_invoice = new FifoInvoice();
                        $fifo_invoice->fifo_id = $fifo->id;
                        $fifo_invoice->invoice_id =  $invoice->id;
                        $fifo_invoice->item_id = $item->item_id;
                        $fifo_invoice->delivery_note_id = 0;
                        $fifo_invoice->quantity =$quantity;
                        $fifo_invoice->save();
                        $quantity = 0;
                    } else {

                        $fifo->consumed = $fifo->consumed + $fifo->remaining;
                        $quantity = $quantity - $fifo->remaining;
                        $inQty=$fifo->remaining;
                        $fifo->remaining = 0;
                        $fifo->save();
                        $fifo_invoice = new FifoInvoice();
                        $fifo_invoice->fifo_id = $fifo->id;
                        $fifo_invoice->invoice_id = $invoice->id;
                        $fifo_invoice->item_id = $item->item_id;
                        $fifo_invoice->delivery_note_id = 0;
                        $fifo_invoice->quantity =$inQty;
                        $fifo_invoice->save();
                        $fifo = Fifo::where('id', '>', $fifo->id)->where('item_id', $item->item_id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                    }
                }
            }

            }

            $stock = StockTransection::where('transection_id', $invoice->id)->where('item_id', $item->item_id)->where('tns_type_code','S')->first();
            if (!$stock) {
                $stock = new StockTransection();
                $stock->transection_id = $invoice->id;
                $stock->item_id = $item->item_id;
            }
            $stock->quantity = $item->quantity;
            $stock->stock_effect = -1;
            $stock->tns_type_code = "S";
            $stock->tns_description = "Sales";
            $stock->cost_price = $item->cost_price;
            $stock->date = $request->date;
            $stock->save();


        }
        return redirect()->route('invoicePrint', $invoice);
    }


    public function salesTaxtInvoiceIssue()
    {
        $invoicess = Invoice::where('invoice_from','Warehouse Sale')->orderBy('id','DESC')->paginate(25);
        return view('backend.taxInvoice.salesTaxtInvoiceIssue', compact('invoicess'));
    }


    public function saleOrderTaxInvoice($sale, Request $request)
    {
        $invoice = SaleOrder::find($sale);
        $modes = PayMode::get();
        $terms = PayTerm::get();
        $customers = PartyInfo::get();
        $projects = ProjectDetail::get();
        $itms = ItemList::get();
        $notes = DeliveryNote::all();
        $i = 0;
        if (!$invoice) {
            return back()->with('error', "Not Found");
        }

        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.saleRaxInvoiceDetails', ['invoice' => $invoice, 'i' => 1, 'modes' => $modes, 'terms' => $terms, 'customers' => $customers, 'projects' => $projects, 'itms' => $itms, 'notes' => $notes])->render(),
                'sale' => $sale
            ]);
        }
    }


    public function deliveryNotInvoice($dnote, Request $request)
    {

        $deliveryNote = DeliveryNote::find($dnote);
        // return $deliveryNote;
        $saleOrder = $deliveryNote->deliverySale->saleOrder;
        // return $saleOrder;
        $modes = PayMode::get();
        $terms = PayTerm::get();
        $customers = PartyInfo::get();
        $projects = ProjectDetail::get();
        $itms = ItemList::get();
        $notes = DeliveryNote::all();
        $i = 0;
        if (!$saleOrder) {
            return back()->with('error', "Not Found");
        }

        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.saleRaxInvoiceDetails', ['invoice' => $saleOrder, 'i' => 1, 'modes' => $modes, 'terms' => $terms, 'customers' => $customers, 'projects' => $projects, 'itms' => $itms, 'notes' => $notes, 'dnote' => $dnote])->render(),
                'dnote' => $dnote
            ]);
        }
    }


    public function genTaxInvoiceSO($sale)
    {
        $saleOrder = SaleOrder::where('id', $sale)->first();
        if (!$saleOrder) {
            return back()->with('error', "Not Found");
        }
        $invoiceNew = Invoice::where('sale_order_id', $saleOrder->id)->first();
        if (!$invoiceNew) {
            $sub_invoice = Carbon::now()->format('Ymd');
            $latest_invoice_no = InvoiceTemp::whereDate('created_at', Carbon::today())->where('invoice_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();
            if ($latest_invoice_no) {
                $invoice_no = $latest_invoice_no->invoice_no + 1;
            } else {
                $invoice_no = Carbon::now()->format('Ymd') . '001';
            }
            $invoicetemp = new InvoiceTemp;
            $invoicetemp->invoice_no = $invoice_no;
            $invoicetemp->save();
            $invoiceNew = new Invoice();
            $invoiceNew->invoice_no = $invoicetemp->invoice_no;
            $invoiceNew->sale_order_id = $saleOrder->id;
            $invoiceNew->date = $saleOrder->date;
            $invoiceNew->project_id = $saleOrder->project_id;
            $invoiceNew->customer_name = $saleOrder->customer_name;
            $invoiceNew->trn_no = $saleOrder->trn_no;
            $invoiceNew->pay_mode = $saleOrder->pay_mode;
            $invoiceNew->pay_terms = $saleOrder->pay_terms;
            $invoiceNew->due_date = $saleOrder->due_date;
            $invoiceNew->contact_no = $saleOrder->contact_no;
            $invoiceNew->address = $saleOrder->address;
            $invoiceNew->gl_code = $saleOrder->gl_code;
            $invoiceNew->save();
            $items = SaleOrderItem::where('sale_order_id', $saleOrder->id)->get();
            foreach ($items as $item) {
                $invoice_item = new InvoiceItem();
                $invoice_item->invoice_no = $invoiceNew->invoice_no;
                $invoice_item->invoice_id = $invoiceNew->id;
                $invoice_item->barcode = $item->barcode;
                $invoice_item->item_id = $item->item_id;
                $invoice_item->net_amount = 1;
                $invoice_item->quantity = $item->quantity;
                $invoice_item->vat_rate = $item->vat_rate;
                $invoice_item->vat_amount = $item->vat_amount;
                $invoice_item->unit = $item->unit;
                $invoice_item->total_unit_price = $item->total_unit_price;
                $invoice_item->cost_price = $item->cost_price;
                $invoice_item->unit_price = $item->unit_price;
                $invoice_item->save();
                $stock = StockTransection::where('transection_id', $invoiceNew->id)->where('item_id', $invoice_item->id)->where('tns_type_code', "S")->first();
                $latestStock = StockTransection::orderBy('id','DESC')->first();
                if (!$stock) {
                    $stock = new StockTransection();
                    $stock->transection_id = $invoiceNew->id;
                    $stock->item_id = $item->item_id;
                }
                $stock->quantity = $item->quantity;
                $stock->stock_effect = -1;
                $stock->tns_type_code = "S";
                $stock->tns_description = "Sales";
                $stock->save();
            }
            $saleInvoicenew = new SaleInvoice();
            $saleInvoicenew->sale_order_id = $saleOrder->id;
            $saleInvoicenew->invoice_id = $invoiceNew->id;
            $saleInvoicenew->save();
            return redirect()->route('invoiceView', $invoiceNew)->with('success', "Genrated Successfully");
        }
        return redirect()->route('invoiceView', $invoiceNew)->with('error', "Already Generated. You can see the invoice now.");
    }

    public function taxInvoiceList()
    {
        $invoicess = Invoice::orderBy('id','DESC')->paginate(100);
        return view('backend.taxInvoice.invoiceList', compact('invoicess'));
    }



    public function genTaxInvoiceDN($dnote)
    {
        $deliveryNote = DeliveryNote::where('id', $dnote)->first();
        if (!$deliveryNote) {
            return back()->with('error', "Not Found");
        }
        $saleOrder = $deliveryNote->deliverySale->saleOrder;
        $invoiceNew = Invoice::where('sale_order_id', $saleOrder->id)->where('delivery_note_id', $deliveryNote->id)->first();
        if (!$invoiceNew) {
            $sub_invoice = Carbon::now()->format('Ymd');
            $latest_invoice_no = InvoiceTemp::whereDate('created_at', Carbon::today())->where('invoice_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();
            if ($latest_invoice_no) {
                $invoice_no = $latest_invoice_no->invoice_no + 1;
            } else {
                $invoice_no = Carbon::now()->format('Ymd') . '001';
            }
            $invoicetemp = new InvoiceTemp;
            $invoicetemp->invoice_no = $invoice_no;
            $invoicetemp->save();
            $invoiceNew = new Invoice();
            $invoiceNew->invoice_no = $invoicetemp->invoice_no;
            $invoiceNew->delivery_note_id = $deliveryNote->id;
            $invoiceNew->sale_order_id = $saleOrder->id;
            $invoiceNew->date = $saleOrder->date;
            $invoiceNew->project_id = $saleOrder->project_id;
            $invoiceNew->customer_name = $saleOrder->customer_name;
            $invoiceNew->trn_no = $saleOrder->trn_no;
            $invoiceNew->pay_mode = $saleOrder->pay_mode;
            $invoiceNew->pay_terms = $saleOrder->pay_terms;
            $invoiceNew->due_date = $saleOrder->due_date;
            $invoiceNew->contact_no = $saleOrder->contact_no;
            $invoiceNew->address = $saleOrder->address;
            $invoiceNew->gl_code = $saleOrder->gl_code;
            $invoiceNew->save();
            $items = DeliveryItem::where('sale_order_id', $saleOrder->id)->where('delivery_note_id', $deliveryNote->id)->get();
            foreach ($items as $item) {
                // return $item->saleItem;
                $invoice_item = new InvoiceItem();
                $invoice_item->invoice_no = $invoiceNew->invoice_no;
                $invoice_item->invoice_id = $invoiceNew->id;
                $invoice_item->barcode = $item->saleItem->barcode;
                $invoice_item->item_id = $item->saleItem->item_id;
                $invoice_item->style_id = $item->style_id;
                $invoice_item->size = $item->size;
                $invoice_item->color_id = $item->color_id;
                $invoice_item->net_amount = 1;
                $invoice_item->quantity = $item->quantity;
                $invoice_item->vat_rate = $item->saleItem->vat_rate;
                $invoice_item->unit = $item->saleItem->unit;
                $invoice_item->total_unit_price = $item->saleItem->total_unit_price / $item->saleItem->quantity * $item->quantity;
                $invoice_item->cost_price = $item->saleItem->cost_price / $item->saleItem->quantity * $item->quantity;
                $invoice_item->unit_price = $item->saleItem->unit_price;
                $invoice_item->vat_amount = $invoice_item->total_unit_price * ($item->saleItem->vat_rate / 100);
                $invoice_item->purchase_price = $item->purchase_price;
                $invoice_item->save();
            //     $stock = StockTransection::where('transection_id', $invoiceNew->id)->where('item_id', $invoice_item->id)->where('tns_type_code', "S")->first();
            //     $latestStock = StockTransection::orderBy('id','DESC')->first();
            //     if (!$stock) {
            //         $stock = new StockTransection();
            //         $stock->transection_id = $invoiceNew->id;
            //         $stock->item_id = $item->saleItem->item_id;
            //     }
            //     $stock->quantity = $item->quantity;
            //     $stock->stock_effect = -1;
            //     $stock->tns_type_code = "S";
            //     $stock->tns_description = "Sales";
            //     $stock->cost_price = $invoice_item->cost_price;
            //     $stock->save();
            }
            // $saleInvoicenew=new SaleInvoice();
            // $saleInvoicenew->sale_order_id= $saleOrder->id;
            // $saleInvoicenew->invoice_id= $invoiceNew->id;
            // $saleInvoicenew->save();
            return redirect()->route('invoiceView', $invoiceNew)->with('success', "Genrated Successfully");
        }
        return redirect()->route('invoiceView', $invoiceNew)->with('error', "Already Generated. You can see the invoice now.");
    }


    public function searchDNo(Request $request)
    {
        $dNotes = DeliveryNote::where('delivery_note_no', 'LIKE', "%{$request->value}%")->get();
        // $dNotes=DeliveryNoteSale::where('delivery_note_no', 'LIKE', "%{$request->value}%")->get();

        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.DeliveryNotSearch', ['dNotes' => $dNotes, 'i' => 1])->render()
            ]);
        }
    }

    public function searchDNoMonth(Request $request)
    {
        $year = substr($request->value, 0, 4);
        $month = substr($request->value, 5, 8);
        $dNotes = DeliveryNote::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();

        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.DeliveryNotSearch', ['dNotes' => $dNotes, 'i' => 1])->render()
            ]);
        }
    }

    public function searchDNoDate(Request $request)
    {

        $dNotes = DeliveryNote::whereDate('created_at', $request->value)->get();

        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.DeliveryNotSearch', ['dNotes' => $dNotes, 'i' => 1])->render()
            ]);
        }
    }

    public function searchDNoDateRange(Request $request)
    {

        $dNotes = DeliveryNote::whereBetween('created_at', [$request->from, $request->to])->get();

        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.DeliveryNotSearch', ['dNotes' => $dNotes, 'i' => 1])->render()
            ]);
        }
    }


    public function searchInvoice(Request $request)
    {
        // return $request->all();
        $invoicess = Invoice::where('invoice_from','Counter Sale')->where('invoice_no', 'LIKE', "%{$request->value}%")->get();

        // $invoicess=Invoice::orderBy('id','DESC')->paginate(25);

        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.invoiceRight', ['invoicess' => $invoicess, 'i' => 1])->render()
            ]);
        }
    }


    public function searchSaleInvoice(Request $request)
    {

        $invoicess = Invoice::where('invoice_from','Warehouse Sale')->where('invoice_no', 'LIKE', "%{$request->value}%")->get();


        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.saleinvoiceRight', ['invoicess' => $invoicess, 'i' => 1])->render()
            ]);
        }
    }

    public function amountto(Request $request)
    {
        $invoice = Invoice::where('invoice_no', $request->invoice)->first();
        // return $invoice->invoiceAmount;
        $invoiceAmount = $invoice->invoiceAmount;
        // dd($invoiceAmount);
        if (!$invoiceAmount) {
            $invoiceAmount = new InvoiceAmount;
        }
        $invoiceAmount->invoice_id = $invoice->id;
        $invoiceAmount->amount_from = $request->value;
        $invoiceAmount->amount_to = $request->value - $request->c;
        $invoiceAmount->save();
        $amount_to = number_format((float)($invoiceAmount->amount_to), '2', '.', '');
        if ($request->ajax()) {
            return Response()->json(['amount_to' => $amount_to]);
        }
    }

    public function quantityFifo(Request $request)
    {
        $total_cost = 0;
        $fifo = Fifo::where('item_id', $request->item_name)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
        $tempcheck=InvoiceItemTemp::where('item_id', $request->item_name)->where('invoice_no',$request->invoice_no)->first();
        if(!$tempcheck)
        {
            $quantity = $request->value;
            $qty=$quantity;
            while ($quantity > 0) {

                if ($fifo) {
                    if ($fifo->remaining >= $quantity) {
                        $cost = $fifo->unit_cost_price * $quantity;
                        $total_cost = $total_cost + $cost;
                        $quantity = 0;
                    } else {
                        $cost = $fifo->unit_cost_price * $fifo->remaining;
                        $total_cost = $total_cost + $cost;
                        $quantity = $quantity - $fifo->remaining;
                        $fifo = Fifo::where('id', '>', $fifo->id)->where('item_id', $request->item_name)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                    }
                } else {
                    return Response()->json(['stockout' => 'Not in stock']);
                }
            }
            $cost_price = $total_cost / $qty;
            $net_amount = $request->unit_price * $request->value;
            return Response()->json([
                'cost_price' => number_format((float)($cost_price), '2', '.', ''),
                'net_amount' => number_format((float)($net_amount), '2', '.', '')
            ]);
        }
        else
        {
            $quantity = $request->value+$tempcheck->quantity;
            $qty=$quantity;
            while ($quantity > 0) {

                if ($fifo) {
                    if ($fifo->remaining >= $quantity) {
                        $cost = $fifo->unit_cost_price * $quantity;
                        $total_cost = $total_cost + $cost;
                        $quantity = 0;
                    } else {
                        $cost = $fifo->unit_cost_price * $fifo->remaining;
                        $total_cost = $total_cost + $cost;
                        $quantity = $quantity - $fifo->remaining;
                        $fifo = Fifo::where('id', '>', $fifo->id)->where('item_id', $request->item_name)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                    }
                } else {
                    return Response()->json(['stockout' => 'Not in stock']);
                }
            }
            $cost_price = $total_cost / $qty;
            $net_amount = $request->unit_price * $request->value;
            return Response()->json([
                'cost_price' => number_format((float)($cost_price), '2', '.', ''),
                'net_amount' => number_format((float)($net_amount), '2', '.', '')
            ]);

        }
    }

    public function quantityFifoedit(Request $request)
    {
        // return $request->all();
        $item = ItemList::where('id', $request->item_name)->first();

        $total_cost = 0;
        $fifo = Fifo::where('item_id', $request->item_name)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
        $invoice_tempQ=InvoiceItemTemp::where('invoice_no',$request->invoice_no)->where('item_id',$request->item_name)->first();
        // return $invoice_tempQ;
        $invoice_itemQ=InvoiceItem::where('invoice_no',$request->invoice_no)->where('item_id',$request->item_name)->first();

        $invoice=Invoice::where('invoice_no',$request->invoice_no)->first();
        // return $invoice_itemQ;

        if($invoice_tempQ)
        {
            $qty=$request->value+$invoice_tempQ->quantity;
        }
        else
        {
            $qty = $request->value;
        }

        if($invoice_itemQ)
        {
            $total_cost_price=$invoice_itemQ->purchase_price*$invoice_itemQ->quantity;


            if($qty>$invoice_itemQ->quantity)
            {

                $fifo = Fifo::where('item_id', $item->id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
                $quantity = $qty-$invoice_itemQ->quantity;

                while ($quantity > 0) {


                    if ($fifo) {


                        if ($fifo->remaining >= $quantity) {

                            $cost = $fifo->unit_cost_price * $quantity;
                            $total_cost = $total_cost + $cost;
                            $quantity = 0;
                        } else {

                            $cost = $fifo->unit_cost_price * $fifo->remaining;
                            $total_cost = $total_cost + $cost;
                            $quantity = $quantity - $fifo->remaining;

                            $fifo = Fifo::where('id', '>', $fifo->id)->where('item_id', $item->id)->where('remaining', '>', 0)->orderBy('id', 'asc')->first();
                        }
                    } else {
                        return Response()->json(['stockout' => 'Not in stock']);
                    }
                }

                $total_cost_price=$total_cost_price+$total_cost;
                $unit_cost_price=$total_cost_price/$qty;
                if ($request->ajax()) {
                return Response()->json([
                    'item' => $item,
                    'unit_price' => $item->total_amount,
                    'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                    'cost_price' => $unit_cost_price
                ]);
            }
            }
            else
            {
                $quantity = $invoice_itemQ->quantity-$qty;
                $invoice_items_fifo=FifoInvoice::where('invoice_id',$invoice->id)->where('item_id',$request->item_name)->orderBy('id','desc')->first();
                $mcost=0;
                while($quantity>0)
                {
                        if($invoice_items_fifo->quantity>$quantity)
                        {
                            $mcost2=$invoice_items_fifo->fifo->unit_cost_price*$quantity;
                            $mcost=$mcost+$mcost2;
                            $quantity=0;
                        }
                        else
                        {
                            $mcost2=$invoice_items_fifo->fifo->unit_cost_price*$invoice_items_fifo->quantity;
                            $quantity=$quantity-$invoice_items_fifo->quantity;
                            $invoice_items_fifo=FifoInvoice::where('id','<',$invoice_items_fifo->id)->where('invoice_id',$invoice->id)->where('item_id',$request->item_name)->orderBy('id','desc')->first();
                            $mcost=$mcost+$mcost2;
                        }
                }
                $total_cost_price=$total_cost_price-$mcost;
                $unit_cost_price=$total_cost_price/$qty;
                if ($request->ajax()) {
                    return Response()->json([
                        'item' => $item,
                        'unit_price' => $item->total_amount,
                        'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                        'cost_price' => $unit_cost_price
                    ]);
                }
            }
        }
        else
        {
            $fifo = Fifo::where('item_id', $item->id)->where('remaining', '>', 0)->orderBy('id', 'ASC')->first();
            if ($request->ajax()) {
                return Response()->json([
                    'item' => $item,
                    'unit_price' => $item->total_amount,
                    'net_amount' => number_format((float)($item->total_amount), 2, '.', ''),
                    'cost_price' => $fifo->unit_cost_price
                ]);
            }
        }

    }


    public function tarek()
    {
        $invoicess=Invoice::get();
        return view('tarek',compact('invoicess'));
    }

    public function tarekInvUpdate($invoice)
    {
        $inv=Invoice::where('id',$invoice)->first();
        $items=InvoiceItem::where('invoice_id',$inv->id)->get();
        return view('tarekInv', compact('inv','items'));
    }

    public function updateStock($item)
    {
        $itm=InvoiceItem::where('id',$item)->first();
        // dd($itm);
        $stock=StockTransection::where('transection_id',$itm->invoice_id)->where('tns_type_code','S')->where('item_id',$itm->item_id)->first();
        if($stock)
        {
            $stock->quantity=$itm->quantity;
        $stock->cost_price=$itm->cost_price;
        }
        else
        {
            $invoice=Invoice::find($itm->invoice_id);
            $stock=new StockTransection();
            $stock->item_id=$itm->item_id;
            $stock->transection_id=$itm->invoice_id;
            $stock->quantity=$itm->quantity;
            $stock->stock_effect= "-1";
            $stock->tns_type_code="S";
            $stock->tns_description="Sales";
            $stock->Date=$invoice->date;
            $stock->cost_price=$itm->cost_price;

        }
        $stock->save();
        return redirect()->back();

    }
}
