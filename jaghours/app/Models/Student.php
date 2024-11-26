<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['student_id','degree_id', 'skills', 'fecha_de_ingreso'];

    //Relacion Usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function getUser(){
        return $this->user-> name->lastname->email->phone->password;
    }

    //Relacion Carrera
    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degree_id', 'id');
    }

    public function getDegree(){
        return $this->degree->name;
    }

    //Relacion Postulaciones
    public function applications()
    {
        return $this->hasMany(Application::class, 'student_id', 'id');
    }

    //Relacion Registros de Horas
    public function hoursrecords()
    {
        return $this->hasMany(HourRecord::class , 'student_id', 'id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class , 'student_id', 'id');
    }
    

    
}
