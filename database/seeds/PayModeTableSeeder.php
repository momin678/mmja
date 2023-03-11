<?php

use App\PayMode;
use Illuminate\Database\Seeder;

class PayModeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PayMode::create([
            'title'=>'Cash',
        ]);

        PayMode::create([
            'title'=>'Credit',
        ]);

        PayMode::create([
            'title'=>'Card',
        ]);
    }
}
