<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MstDefinitionsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(MstACTypesTable::class);
        $this->call(ProjectDetailsTypeSeeder::class);
        $this->call(CostCenterTypeTable::class);
        $this->call(VatTypeTable::class);
        $this->call(CountryTableSeeder::class);
        $this->call(UnitTableSeeder::class);
        $this->call(VatRateTableSeeder::class);
        $this->call(PayModeTableSeeder::class);
        $this->call(PayTermTableSeeder::class);
        $this->call(BranchTableSeeder::class);
        $this->call(TxnTableSeeder::class);
    }
}
