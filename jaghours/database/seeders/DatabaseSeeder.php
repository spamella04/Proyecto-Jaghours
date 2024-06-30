<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
            'cif' => '12345678A',
            'name' => 'Test User',
          'lastname' => 'Test User',
            'phone' => '123456789',
          'email' => 'admin@uamv.edu.ni',
         'password' => bcrypt('password'),
         'role' => 'admin', 

      ]);

        \App\Models\Degree::factory()->create(
            [
                'code' => '0001',
                'name' => 'Ingenieria Sistemas',
                
            ]
            );
    }
}
