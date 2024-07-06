<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourRecord extends Model
{
    use HasFactory;

    protected $fillable = ['work_date','hours_worked','job_id','area_manager_id','semester_id'];

   
    //Relacion Semestre
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function getSemester()
    {
        return $this->semester->name;
    }

    //Relacion Trabajo
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function getJob()
    {
        return $this->job;
    }

    
    

    //Relacion Area Manager

    public function areaManager()
    {
        return $this->belongsTo(AreaManager::class, 'area_manager_id', 'id');
    }

    public function getAreaManager()
    {
        return $this->areaManager->user;
    }

   


}
