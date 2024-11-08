<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use App\Models\Degree;


class StudentsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

     public $ignoredCount = 0;
    public function model(array $row)
    {

        // Verificar si el usuario ya existe por el CIF o correo
        $existingUser = User::where('cif', $row[0])->orWhere('email', $row[3])->first();

        if ($existingUser) {
            
            $this->ignoredCount++;
            
            // Devolver null para que no se inserte el registro
            return null;
        }
        
        $user = User::create([
            'cif' => $row[0],  
            'name' => $row[1],  
            'lastname' => $row[2],  
            'email' => $row[3],  
            'phone' => $row[4],  
            'password' => Hash::make($row[5]),  
            'role' => 'student',  // Asignamos el rol de estudiante
            'status' => 'active',  // Estado activo
        ]);

       
        $degreeId = $row[6];
        
        // Crear el estudiante y asociarlo con el usuario creado
        return new Student([
            'student_id' => $user->id,  // Relacionamos con el ID del usuario
            'degree_id' => $degreeId,  // Relacionamos con el ID de la carrera
            'skills' => $row[7],  // Habilidades
        ]);
    }

    public function getIgnoredCount()
    {
        return $this->ignoredCount;
    }
}