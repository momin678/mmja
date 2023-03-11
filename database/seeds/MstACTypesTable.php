<?php

use App\Models\MstACType;
use Illuminate\Database\Seeder;

class MstACTypesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MstACType::create([
            'title'=>'REVENUE INCOME',
            'cat_type' => 3 
        ]);

        MstACType::create([
            'title'=>'CAPITAL INCOME',
            'cat_type' => 1
        ]);

        MstACType::create([
            'title'=>'CAPITAL EXPENSE',
            'cat_type' => 4
        ]);

        MstACType::create([
            'title'=>'ASSET',
            'cat_type' => 2
        ]);

        MstACType::create([
            'title'=>'REVENUE EXPENSE',
            'cat_type' => 4
        ]);

        MstACType::create([
            'title'=>'LIABILITY',
            'cat_type' => 2
        ]);

    }
}
