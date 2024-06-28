<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['student_cif','degree_code', 'skills'];


    public function applications()
    {
        return $this->hasMany(Application::Class);
    }
}
