<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartyInfo extends Model
{
    use  SoftDeletes;

    public function journals()
    {
        return $this->hasMany(Journal::class,'party_info_id');
    }

    public function purchase(){
        return $this->hasMany(Purchase::class, 'supplier_id');
    }
    public function paidAmount(){
        return $this->hasMany(PaymentVoucher::class, 'supplier_id');
    }

    public function hasDue()
    {
        return $this->hasOne(Purchase::class,'supplier_id');
    }

    public function currentAP()
    {
        return $this->hasMany(Purchase::class,'supplier_id')->where('pay_date','>=',date('Y-m-d'))->where('pay_mode','Credit')->sum('grand_total');
    }

    public function ap($day1,$day2)
    {
        return $this->hasMany(Purchase::class,'supplier_id')->where('pay_date', '<=', Carbon::now()->subDays($day1))->where('pay_date', '>=', Carbon::now()->subDays($day2))->where('pay_mode','Credit')->sum('grand_total');

    }

    public function days_up($day)
    {
        return $this->hasMany(Purchase::class,'supplier_id')->where('pay_date', '<', Carbon::now()->subDays($day))->where('pay_mode','Credit')->sum('grand_total');

    }

    public function apTotal()
    {
        return $this->hasMany(Purchase::class,'supplier_id')->where('pay_mode','Credit')->sum('grand_total');

    }

    public function customerName(){
        return $this->hasMany(JournalRecord::class, 'party_info_id')->where('transaction_type', 'DR');
    }

}
