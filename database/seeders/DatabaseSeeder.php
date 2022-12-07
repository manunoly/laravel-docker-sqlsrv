<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        \App\Models\User::factory()->create([
            'name' => 'Manuel Almaguer',
            'email' => 'manuel@entourageyearbooks.com',
            'password' => bcrypt('manuel123'),

        ]);
        \App\Models\User::factory()->create([
            'name' => 'Elias Jo',
            'email' => 'elias@entourageyearbooks.com',
            'password' => bcrypt('elias123'),

        ]);
        \App\Models\User::factory()->create([
            'name' => 'Nicole Rossi',
            'email' => 'nicole.rossi@entourageyearbooks.com',
            'password' => bcrypt('nicole123'),

        ]);

        \App\Models\User::factory(10)->create();

    }
}
