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
            'name' => 'Admin',
          'lastname' => 'Admin',
            'phone' => '123456789',
          'email' => 'admin@uam.edu.ni',
         'password' => bcrypt('password'),
         'role' => 'admin', 

      ]);

        \App\Models\Degree::factory()->create(
            [
                'code' => '0001',
                'name' => 'Ingenieria Sistemas',
                
            ]
            );
            \App\Models\Degree::factory()->create(
              [
                  'code' => '0002',
                  'name' => 'Ingenieria Industrial',
                  
              ]
              );
              \App\Models\Degree::factory()->create(
                [
                    'code' => '0003',
                    'name' => 'Ingenieria Civil',
                    
                ]
                );
                \App\Models\Degree::factory()->create(
                  [
                      'code' => '0004',
                      'name' => 'Marketing',
                      
                  ]
                  );
                  \App\Models\Degree::factory()->create(
                    [
                        'code' => '0005',
                        'name' => 'Administracion de Empresas',
                        
                    ]
                    );
                    \App\Models\Degree::factory()->create(
                      [
                          'code' => '0006',
                          'name' => 'Derecho',
                          
                      ]
                      );
                      \App\Models\Degree::factory()->create(
                        [
                            'code' => '0007',
                            'name' => 'Contabilidad',
                            
                        ]
                        );
    \App\Models\Area::factory()->create(
      [
          'code' => '0001',
          'name' => 'Biblioteca',
          'description' => 'Biblioteca Pablo Antonio Cuadra',
          
      ]
      );
      \App\Models\Area::factory()->create(
        [
            'code' => '0002',
            'name' => 'Admision',
            'description' => 'Registro academico',
            
        ]
        );
        \App\Models\Area::factory()->create(
          [
              'code' => '0003',
              'name' => 'Vida Estudiantil',
              'description' => 'Gestion estudiantil y actividades extracurriculares',
              
          ]
          );
      \App\Models\User::factory()->create([
        'cif' => '012345678B',
        'name' => 'Isabella',
      'lastname' => 'Lopez',
        'phone' => '87903578',
      'email' => 'biblioteca@uam.edu.ni',
     'password' => bcrypt('password'),
     'role' => 'areamanager', 

  ]);

  \App\Models\AreaManager::factory()->create([
    'area_manager_id' => '2',
    'area_id' => '1',


]);

\App\Models\User::factory()->create([
  'cif' => '012345678C',
  'name' => 'Carmen',
'lastname' => 'Vilches',
  'phone' => '88906578',
'email' => 'admision@uam.edu.ni',
'password' => bcrypt('password'),
'role' => 'areamanager', 

]);

\App\Models\AreaManager::factory()->create([
'area_manager_id' => '3',
'area_id' => '2',


]);


\App\Models\User::factory()->create([
  'cif' => '012345678D',
  'name' => 'Gabriel',
'lastname' => 'Gomez',
  'phone' => '82906878',
'email' => 'vidaestudiantil@uam.edu.ni',
'password' => bcrypt('password'),
'role' => 'areamanager', 

]);

\App\Models\AreaManager::factory()->create([
'area_manager_id' => '4',
'area_id' => '3',


]);


\App\Models\Semester::factory()->create(
  [
      'name' => 'I Semestre 2024',
      'start_date' => '2024-03-15',
      'end_date' => '2024-07-15',
      'hours_required' => '25',

  ]);

  \App\Models\Semester::factory()->create(
    [
        'name' => 'II Semestre 2024',
        'start_date' => '2024-08-19',
        'end_date' => '2024-12-9',
        'hours_required' => '25',
  
    ]);


    \App\Models\JobOportunity::factory()->create(
      [
          'title' => 'Ordenar libros',
          'description' => 'Se necesita un estudiante para organizar libros por facultad',
          'status' => 'Publicado',
          'start_date' => '2024-07-13',
          'hours_validated'=> '2',
          'number_applicants' => '2',
          'number_vacancies' => '1',
          'requirements' => 'Organización',
          'area_manager_id' => '1',
          
    
      ]);

      \App\Models\JobOportunity::factory()->create(
        [
            'title' => 'Gestion de documentos',
            'description' => 'Se necesita un estudiante para gestionar documentos de admision',
            'status' => 'Publicado',
            'start_date' => '2024-07-13',
            'hours_validated'=> '4',
            'number_applicants' => '3',
            'number_vacancies' => '2',
            'requirements' => 'Manejo de Excel Intermedio',
            'area_manager_id' => '2',
            
      
        ]);

        \App\Models\JobOportunity::factory()->create(
          [
              'title' => 'Etiquetado de viveres',
              'description' => 'Se necesita un estudiante para etiquetar viveres en el almacen',
              'status' => 'Publicado',
              'start_date' => '2024-07-13',
              'hours_validated'=> '4',
              'number_applicants' => '6',
              'number_vacancies' => '3',
              'requirements' => 'Responsabilidad',
              'area_manager_id' => '3',
          ]);
}
}
