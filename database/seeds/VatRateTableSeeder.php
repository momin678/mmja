<?php

use App\VatRate;
use Illuminate\Database\Seeder;

class VatRateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VatRate::create([
            'name'=>"0 Rated",
            'value'=>0,
        ]);
        VatRate::create([
            'name'=>"Exempted",
            'value'=>0,
        ]);
        VatRate::create([
            'name'=>"No TRN",
            'value'=>3,
        ]);
        VatRate::create([
            'name'=>"Standard",
            'value'=>5,
        ]);
    }
}
