<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\JobOportunity;
use App\Enums\ApplicationStatus;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['student_id','job_opportunity_id', 'status'];

    protected $casts = [
        'status' => ApplicationStatus::class,
    ];

    public function getStatusAttribute($value)
    {
        return ApplicationStatus::fromValue($value);
    }

    public function setStatusAttribute($ApplicationStatus)
    {
        $this->attributes['status'] = ApplicationStatus::fromValue($ApplicationStatus);
    }

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
        return $this->belongsTo(JobOportunity::class, 'job_opportunity_id', 'id');
    }
    
    public function getJobOpportunities()
    {
        return $this->job_opportunities->title->description->status->start_date->hours_validated->number_applicants->number_vacancies->requirements->area_manager_cif;
    }

    
    
}
