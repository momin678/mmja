<?php

use App\CostCenterType;
use Illuminate\Database\Seeder;

class CostCenterTypeTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CostCenterType::create([
            'title'=>'Supplier',
        ]);

        CostCenterType::create([
            'title'=>'Customer',
        ]);

        CostCenterType::create([
            'title'=>'Employee',
        ]);

        CostCenterType::create([
            'title'=>'Government Body',
        ]);

    }
}
