<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['student_cif','job_opportunity_id', 'status', 'date'];

    public function students()
    {
        return $this->belongsTo(Student::class);
    }

    public function getStudents()
    {
        return $this->students->name->lastname->email->phone;
    }

    public function job_opportunities()
    {
        return $this->belongsTo(JobOpportunity::class);
    }
    
    public function getJobOpportunities()
    {
        return $this->job_opportunities->title->description->status->start_date->hours_validated->number_applicants->number_vacancies->requirements->area_manager_cif;
    }
    
}
