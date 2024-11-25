<?php
namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use App\Models\Degree;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\ValidationException;

class StudentsImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public $ignoredCount = 0;
    public $headersMissing = false;

    // Verifica si los encabezados necesarios están presentes
    public function __construct()
    {
        $this->requiredHeaders = ['cif', 'name', 'lastname', 'email', 'phone', 'password', 'degree_id', 'skills'];
    }

    public function model(array $row)
    {
       
        if ($this->headersMissing) {
            return null; // No procesar si faltan los encabezados
        }

        
        foreach ($this->requiredHeaders as $header) {
            if (!array_key_exists($header, $row)) {
                $this->headersMissing = true;
                break;
            }
        }

        // Si falta algún encabezado, no procesar el archivo
        if ($this->headersMissing) {
            return null;
        }

        // Validar si el estudiante ya existe
        $existingUser = User::where('cif', $row['cif'])->orWhere('email', $row['email'])->first();
        if ($existingUser) {
            $this->ignoredCount++;
            return null; // Ignorar el registro duplicado
        }

        // Crear el usuario
        $user = User::create([
            'cif' => $row['cif'],
            'name' => $row['name'],
            'lastname' => $row['lastname'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'password' => Hash::make($row['password']),
            'role' => 'student',
            'status' => 'active',
        ]);

        // Crear el estudiante asociado
        return new Student([
            'student_id' => $user->id,
            'degree_id' => $row['degree_id'],
            'skills' => $row['skills'],
        ]);
    }

    public function getIgnoredCount()
    {
        return $this->ignoredCount;
    }

    
    public function headersMissing()
    {
        return $this->headersMissing;
    }
}
