<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['student_id','job_opportunity_id', 'status'];


    //Relacion Estudiante
    public function students()
    {
        return $this->belongsTo(Student::class , 'student_id', 'id');
    }

    public function getStudents()
    {
        return $this->students->user->getUser();
    }

    //Relacion Oportunidades de Trabajo
    public function job_opportunities()
    {
        return $this->belongsTo(JobOpportunity::class, 'job_opportunity_id', 'id');
    }
    
    public function getJobOpportunities()
    {
        return $this->job_opportunities->title->description->status->start_date->hours_validated->number_applicants->number_vacancies->requirements->area_manager_cif;
    }

    
    
}
