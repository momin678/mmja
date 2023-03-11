<?php

use App\VatType;
use Illuminate\Database\Seeder;

class VatTypeTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VatType::create([
            'title'=>'Input',
        ]);

        VatType::create([
            'title'=>'Output',
        ]);
    }
}
