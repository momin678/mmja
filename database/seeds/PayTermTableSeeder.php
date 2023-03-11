<?php

use App\PayTerm;
use Illuminate\Database\Seeder;

class PayTermTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PayTerm::create([
            'title'=>'Today',
            'value' => 0,
        ]);

        PayTerm::create([
            'title'=>'10 Days',
            'value' => 10,
        ]);


        PayTerm::create([
            'title'=>'15 Days',
            'value' => 15,
        ]);

        PayTerm::create([
            'title'=>'30 Days',
            'value' => 30,
        ]);

        PayTerm::create([
            'title'=>'45 Days',
            'value' => 45,
        ]);

        PayTerm::create([
            'title'=>'60 Days',
            'value' => 60,
        ]);

        PayTerm::create([
            'title'=>'75 Days',
            'value' => 75,
        ]);

        PayTerm::create([
            'title'=>'90 Days',
            'value' => 90,
        ]);
    }
}
