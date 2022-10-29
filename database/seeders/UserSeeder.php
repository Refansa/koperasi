<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        User::factory()->create([
            'name'      => 'Muhammad Refansa Ali Muzky',
            'email'     => 'm.refansa.am@gmail.com',
            'password'  => Hash::make('@nomadbush123'),
        ]);
    }
}
