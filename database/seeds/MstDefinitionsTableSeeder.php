<?php

use Illuminate\Database\Seeder;
use App\Models\MstDefinition;

class MstDefinitionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MstDefinition::create([
            'title'=>'Sales Turnover',
        ]);
        MstDefinition::create([
            'title'=>'Rent Income',
        ]);
        MstDefinition::create([
            'title'=>'Fixed Asset',
        ]);
        MstDefinition::create([
            'title'=>'Liquid Asset',
        ]);
        MstDefinition::create([
            'title'=>'Current / Operating Asset',
        ]);
        MstDefinition::create([
            'title'=>'Current Liability',
        ]);
        MstDefinition::create([
            'title'=>'Owners Investment',
        ]);
        MstDefinition::create([
            'title'=>'Long Term Liability',
        ]);
        MstDefinition::create([
            'title'=>'Sell of Asset',
        ]);
        MstDefinition::create([
            'title'=>'Other Income',
        ]);
        MstDefinition::create([
            'title'=>'Cost of Sales / Goods Sold',
        ]);
        MstDefinition::create([
            'title'=>'Administrative Expense',
        ]);
        MstDefinition::create([
            'title'=>'Marketing, advertising, and promotion',
        ]);
        MstDefinition::create([
            'title'=>'Salaries, benefits and wages',
        ]);
        MstDefinition::create([
            'title'=>'Utility Expenses',
        ]);
        MstDefinition::create([
            'title'=>'Rent and insurance',
        ]);
        MstDefinition::create([
            'title'=>'Depreciation and amortization',
        ]);
        MstDefinition::create([
            'title'=>'Property Investment',
        ]);

    }
}
