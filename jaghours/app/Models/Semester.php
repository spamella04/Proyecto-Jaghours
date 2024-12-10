<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HourRecord;
use App\Models\Job;


class Semester extends Model
{
    use HasFactory;

    protected $fillable = ['name','start_date','end_date','hours_required','status'];

    //Relacion Registros de Horas
    public function hourRecords()
    {
        return $this->hasMany(HourRecord::class);
    }

    public function checkStudentHours($studentId, $semesterId)
    {
        // Buscar el semestre
        $semester = Semester::findOrFail($semesterId);
    
        // Obtener los trabajos del estudiante en ese semestre
        $jobs = Job::where('student_id', $studentId)
                    ->get();
    
        // Inicializar el total de horas
        $totalHours = 0;
    
        // Sumar las horas trabajadas en todos los trabajos del estudiante para el semestre dado
        foreach ($jobs as $job) {
            $totalHours += $job->hourRecords()
                                ->where('semester_id', $semesterId)
                                ->sum('hours_worked');
        }
    
        // Verificar si las horas trabajadas exceden o igualan las horas requeridas
        if ($totalHours >= $semester->hours_required) {
            return false; // El estudiante ya ha alcanzado o excedido las horas requeridas
        }
    
        return true; // El estudiante puede seguir registrando horas
    }
    
    

}
