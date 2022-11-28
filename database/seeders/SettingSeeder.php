<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::factory()->create([
            'minimum_basic_cost'        => 200000,
            'minimum_mandatory_cost'    => 200000,
            'maximum_loan_amount'       => 2000000,
            'saving_limit_for_loan'     => 4000000,
        ]);
    }
}
