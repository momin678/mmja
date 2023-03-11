<?php

use App\ProjectDetailsType;
use Illuminate\Database\Seeder;

class ProjectDetailsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectDetailsType::create([
            'title'=>'Retail Store',
        ]);

        ProjectDetailsType::create([
            'title'=>'Warehouse',
        ]);

    }
}
