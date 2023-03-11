<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptVoucher extends Model
{
    // protected $table = 'receipt_vouchers';
    protected $fillable = ['id'];
    public function tax_invoice(){
        return $this->belongsTo(Invoice::class, "tax_invoice_id");
    }
    public function project()
    {
        return $this->belongsTo(ProjectDetail::class,'project_id');
    }
    public function partyInfo()
    {
        return $this->belongsTo(PartyInfo::class, "customer_id");
    }
    public function tax_invoice_items($tax_invoice_no){
        $tax_invoice_info = Invoice::find($tax_invoice_no);
        $invoice_items = InvoiceItem::where("invoice_no", $tax_invoice_info->invoice_no)->get();
        return $invoice_items;
    }
}
