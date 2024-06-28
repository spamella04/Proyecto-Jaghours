<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    use HasFactory;

    protected $fillable = ['code','name'];


    //Relacion Estudiantes
    public function students()
    {
        return $this->hasMany(Student::class);
    }




}
