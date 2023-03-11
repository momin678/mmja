<?php

use App\TransectionDefinition;
use Illuminate\Database\Seeder;

class TransectionDefinitionTableSeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransectionDefinition::updateOrCreate([
            'trn_desc' => 'Sales',
            'trns_code' => 'S',
            'trn_type' => 'Issue',
            'trn_type_code' => 'I',
            'stock_effect' => -1
        ]);

        TransectionDefinition::updateOrCreate([
            'trn_desc' =>'Sales Return',
            'trns_code' => 'T',
            'trn_type' => 'Issue',
            'trn_type_code' => 'I',
            'stock_effect' => -1
        ]);

        TransectionDefinition::updateOrCreate([
            'trn_desc' => 'Purchase ',
            'trns_code' => 'P',
            'trn_type' => 'Receive',
            'trn_type_code' => 'R',
            'stock_effect' => 1
        ]);

        TransectionDefinition::updateOrCreate([
            'trn_desc' => 'Purchase Return',
            'trns_code' => 'Q',
            'trn_type' => 'Issue',
            'trn_type_code' => 'I',
            'stock_effect' => -1
        ]);

        TransectionDefinition::updateOrCreate([
            'trn_desc' => 'Stock Adjustment +',
            'trns_code' => 'R',
            'trn_type' => 'Receive',
            'trn_type_code' => 'R',
            'stock_effect' => 1
        ]);

        TransectionDefinition::updateOrCreate([
            'trn_desc' => 'Stock Adjustment -',
            'trns_code' => 'U',
            'trn_type' => 'Issue',
            'trn_type_code' => 'I',
            'stock_effect' => -1
        ]);
    }
}
