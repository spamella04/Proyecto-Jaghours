<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourRecord extends Model
{
    use HasFactory;

    protected $fillable = ['work_date','hours_worked','job_opportunity_id','student_id','area_manager_id','semester_id'];

   
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
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getStudent()
    {
        return $this->student->user->getUser();
    }

    //Relacion Area Manager

    public function areaManager()
    {
        return $this->belongsTo(AreaManager::class);
    }

    public function getAreaManager()
    {
        return $this->areaManager->user;
    }

   


}
