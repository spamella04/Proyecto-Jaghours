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
    public function student()
    {
        return $this->belongsTo(Student::class , 'student_id', 'id');
    }

    

    //Relacion Oportunidades de Trabajo
    public function job_opportunities()
    {
        return $this->belongsTo(JobOportunity::class, 'job_opportunity_id', 'id');
    }
    
   

    
    
}
