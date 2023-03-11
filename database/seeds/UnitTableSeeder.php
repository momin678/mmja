<?php

use App\Unit;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = array('Box', 'Packets', 'PCS', 'Dozen');
        foreach($units as $unit){
            Unit::create(['name' => $unit]);
        }
    }
}
