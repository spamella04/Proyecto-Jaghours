<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['student_cif','degree_code', 'skills'];

    //Relacion Carrera
    public function degree()
    {
        return $this->belongsTo(Degree::Class);
    }

    public function getDegree(){
        return $this->degree->name;
    }

    //Relacion Postulaciones
    public function applications()
    {
        return $this->hasMany(Application::Class);
    }

    //Relacion Registros de Horas
    public function hoursRecords()
    {
        return $this->hasMany(HourRecord::Class);
    }

    //Relacion Registros de Horas por Semestre
    public function hourTrackingPerSemester()
    {
        return $this->hasMany(HourTrackingPerSemester::Class);
    }

    
}
