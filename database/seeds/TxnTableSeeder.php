<?php

use App\TxnType;
use Illuminate\Database\Seeder;

class TxnTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TxnType::create([
            'title'=>'Purchase/Expense',
        ]);

        TxnType::create([
            'title'=>'Income',
        ]);
    }
}
