<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate([
            'config_name' => 'company_name',
            'config_value' => 'MOHAMMED HABIB READYMADE GARMENTS TRADING LLC',
        ]);

        Setting::updateOrCreate([
            'config_name' => 'company_address',
            'config_value' => 'Office No- 11, Jurf industrail zone3, Ajman, Ajman, United Arab Emirates, 2449',
        ]);

        Setting::updateOrCreate([
            'config_name' => 'company_tele',
            'config_value' => '+971526860005',
        ]);

        Setting::updateOrCreate([
            'config_name' => 'company_email',
            'config_value' => 'cotton-mart@gmail.com',
        ]);

        Setting::updateOrCreate([
            'config_name' => 'title_name',
            'config_value' => 'Cotton Mart',
        ]);

        Setting::updateOrCreate([
            'config_name' => 'trn_no',
            'config_value' => '100516955000003',
        ]);
    }
}
