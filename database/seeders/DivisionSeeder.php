<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Division::factory(5)->create();
        Division::factory()->create(['position' => 'Kepala Sekolah']);
        Division::factory()->create(['position' => 'Wakil Kepala Sekolah']);
        Division::factory()->create(['position' => 'Kesiswaan']);
        Division::factory()->create(['position' => 'Kurikulum']);
        Division::factory()->create(['position' => 'Tata Usaha']);
    }
}
