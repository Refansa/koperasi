<?php

namespace Database\Seeders;

use App\Models\Saving;
use App\Models\User;
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
            'user_id' => User::factory()->create([
                'name'      => 'Koperasi Jaya',
                'email'     => 'admin@koperasi.com',
                'password'  => bcrypt('super-rahasia'),
                'address'   => 'Jl. Menuju Kesuksesan',
                'contact'   => 'admin@koperasi.com',
                'role'      => 'admin',
            ]),
        ]);

        Saving::factory()->create([
            'user_id' => User::factory()->create([
                'name'      => 'Muhammad Refansa Ali Muzky',
                'email'     => 'm.refansa.am@gmail.com',
                'password'  => bcrypt('@nomadbush123'),
                'address'   => 'Jl. Jln',
                'contact'   => 'm.refansa.am@gmail.com',
                'role'      => 'admin',
            ]),
        ]);

        Saving::factory()->create([
            'user_id' => User::factory()->create([
                'name'      => 'Fauzan Gusdani',
                'email'     => 'fauzan.gg@gmail.com',
                'password'  => bcrypt('progamer'),
                'address'   => 'Jl. Jln',
                'contact'   => 'fauzan.gg@gmail.com',
                'role'      => 'anggota',
            ]),
        ]);

        Saving::factory(10)->create();
    }
}
