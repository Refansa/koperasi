<?php

namespace Database\Seeders;

use App\Models\Saving;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SavingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Saving::factory()->create([
            'user_id'           => 1,
            'deposit_amount'    => 0,
            'loan_amount'       => 0,
        ]);

        Saving::factory()->create([
            'user_id'           => 2,
            'deposit_amount'    => 0,
            'loan_amount'       => 0,
        ]);

        Saving::factory(50)->create();
    }
}
