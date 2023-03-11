<?php

use App\Branch;
use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::create([
            'title'=>'A',
        ]);
        Branch::create([
            'title'=>'B',
        ]);
        Branch::create([
            'title'=>'C',
        ]);
    }
}
