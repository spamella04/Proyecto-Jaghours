<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['student_id','degree_id', 'skills'];

    //Relacion Usuario
    public function user()
    {
        return $this->belongsTo(User::Class, 'student_id', 'id');
    }

    public function getUser(){
        return $this->user-> name->lastname->email->phone->password;
    }

    //Relacion Carrera
    public function degree()
    {
        return $this->belongsTo(Degree::Class, 'degree_id', 'id');
    }

    public function getDegree(){
        return $this->degree->name;
    }

    //Relacion Postulaciones
    public function applications()
    {
        return $this->hasMany(Application::Class, 'student_id', 'id');
    }

    //Relacion Registros de Horas
    public function hoursRecords()
    {
        return $this->hasMany(HourRecord::Class);
    }

    

    
}
