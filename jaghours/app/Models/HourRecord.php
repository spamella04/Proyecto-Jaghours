<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourRecord extends Model
{
    use HasFactory;

    protected $fillable = ['work_date','hours_worked','job_opportunity_id','student_cif','area_manager_cif','semester_id'];

   
    //Relacion Semestre
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function getSemester()
    {
        return $this->semester->name;
    }

    //Relacion Oportunidad de Trabajo
    public function jobOpportunity()
    {
        return $this->belongsTo(JobOpportunity::class);
    }

    public function getJobOpportunity()
    {
        return $this->jobOpportunity->name;
    }

    //Relacion Estudiante
    //PREGUNTAR SI ES STUDENT O USER
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_cif', 'cif');
    }
    public function getStudent()
    {
        return $this->student->name;
    }

    //Relacion Area Manager
     //PREGUNTAR SI ES AREA MANAGER O USER
    public function areaManager()
    {
        return $this->belongsTo(AreaManager::class, 'area_manager_cif', 'cif');
    }

    public function getAreaManager()
    {
        return $this->areaManager->name;
    }

   


}
