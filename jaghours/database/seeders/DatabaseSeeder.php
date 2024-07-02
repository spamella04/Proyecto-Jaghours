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
    

    \App\Models\Area::factory()->create(
      [
          'code' => '0001',
          'name' => 'Biblioteca',
          'description' => 'Biblioteca',
          
      ]
      );

      \App\Models\User::factory()->create([
        'cif' => '19014700',
        'name' => 'Silvio',
      'lastname' => 'V',
        'phone' => '86035239',
      'email' => 'savigil@uamv.edu.ni',
     'password' => bcrypt('password123'),
     'role' => 'areamanager', 

  ]);

  \App\Models\AreaManager::factory()->create([
    'area_manager_id' => '2',
    'area_id' => '1',


]);
    }
}
