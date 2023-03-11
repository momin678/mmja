<?php

namespace App\Http\Controllers\backend;

use App\GoodsReceived;
use App\GoodsReceivedDetails;
use App\Http\Controllers\Controller;
use App\InvoicePosting as AppInvoicePosting;
use App\InvoicePostingDetails;
use App\PurchaseTemp;
use App\PurchseDetail;
use Illuminate\Http\Request;

class InvoicePosting extends Controller
{
    public function index(){
        $goods_received = GoodsReceived::where('is_invoice_posted', 0)->get();
        // return $goods_received;
        $invoice_posted = AppInvoicePosting::paginate(20);
        return view('backend.invoice-posting.index', compact('goods_received', 'invoice_posted'));
    }

    public function invoice_post_form($id){
        $goods_received = GoodsReceived::find($id);
        $goods_items = GoodsReceivedDetails::where('goods_received_no', $goods_received->goods_received_no)->get();
        $invoice_lists = AppInvoicePosting::paginate(20);
        return view('backend.invoice-posting.show', compact('goods_received', 'goods_items', 'goods_received', 'invoice_lists'));
    
    }

    public function invoice_posting_submit(Request $request){
        // return $request;
        
        $request->validate([
            'invoice_posting_no'    => 'required',
            'challan_number'        => 'required'
        ]);

        $invoice_posting= new AppInvoicePosting;
        $invoice_posting->invoice_posting_no            = $request->invoice_posting_no;
        $invoice_posting->temp_invoice_posting_no       = $request->temp_invoice_posting_no;
        $invoice_posting->goods_received_no             = $request->goods_received_no;
        $invoice_posting->po_no                         = $request->purchase_no;
        $invoice_posting->pr_no                         = $request->pr_id;
        $invoice_posting->project_id                    = $request->project_id;
        $invoice_posting->supplier_id                   = $request->supplier_id;
        $invoice_posting->delivery_note                 = $request->challan_number;
        $invoice_posting->save();
        
        if ($invoice_posting){
            $purchase_details= PurchseDetail::where('purchase_no', $request->purchase_no)->get();
        
            foreach ($purchase_details as $key => $each_item) {
                $inv_post_details= new InvoicePostingDetails;
                $inv_post_details->invoice_posting_no   = $request->invoice_posting_no;
                $inv_post_details->item_id              = $each_item->item_id;
                $inv_post_details->quantity             = $each_item->quantity;
                $inv_post_details->purchase_rate        = $each_item->purchase_rate;
                $inv_post_details->vat_rate             = $each_item->vat_rate;
                $inv_post_details->vat_amount           = $each_item->vat_amount;
                $inv_post_details->total_amount         = $each_item->total_amount;
                $inv_post_details->save();
            }

            GoodsReceived::where('goods_received_no', $request->goods_received_no)
            ->update(['is_invoice_posted' => 1]);
    
            $notification= array(
                'message'       => 'Invoice Posting Completed',
                'alert-type'    => 'success'
            );
        }else{
            $notification= array(
                'message'       => 'Invoice Posting Failed!',
                'alert-type'    => 'alert'
            );
        }

        return redirect('invoice-posting')->with($notification);
    }

    public function ip_details($id){
        $invoice_posting = AppInvoicePosting::find($id);
        $details= InvoicePostingDetails::where('invoice_posting_no', $invoice_posting->invoice_posting_no)->get();

        $invoice_lists = AppInvoicePosting::paginate(20);
        return view('backend.invoice-posting.ip-details', compact('invoice_posting', 'details','invoice_lists'));

    }
}
