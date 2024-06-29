<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourTrackingPerSemester extends Model
{
    use HasFactory;

    protected $fillable = ['semester_id','student_id','hours_per_semester'];

    //Relacion Semestre
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function getSemester(){
        return $this->semester->name;
    }

    //Relacion Estudiante
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    
    public function getStudent(){
        return $this->student->user->getUser();
    }

}
