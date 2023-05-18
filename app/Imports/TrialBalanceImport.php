<?php

namespace App\Imports;

use App\JournalRecord;
use App\Models\AccountHead;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class TrialBalanceImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $ac_head= trim($row[0]);
        $account_head= AccountHead::where('fld_ac_code', $ac_head)->first();
        

        $transaction_type='';
        if(isset($row[3])){
            $transaction_type='DR';
        }elseif(isset($row[4])){
            $transaction_type='CR';
        }

        if($account_head){
            return new JournalRecord([
                'journal_id'            => 0,
                'project_details_id'    => 0,
                'cost_center_id'        => 0,
                'party_info_id'         => 0,
                'journal_no'            => 'import',
                'account_head_id'       => $account_head->id,
                'master_account_id'     => $account_head->master_account_id,
                'account_head'          => $account_head->fld_ac_head,
                'amount'                => isset($row[3]) ? $row[3] : $row[4], 
                'total_amount'          => isset($row[3]) ? $row[3] : $row[4], 
                'transaction_type'      => $transaction_type,
                'vat_rate_id'           => 0,
                'journal_date'          => Carbon::today(),
                'is_main_head'          => 1,
             ]);
        }

        
    }
}
