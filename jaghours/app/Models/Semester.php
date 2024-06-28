<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = ['name','start_date','end_date'];

    //Relacion Registros de Horas
    public function hourRecords()
    {
        return $this->hasMany(HourRecord::class);
    }

    //Relacion Registros de Horas por Semestre
    public function hourTrackingPerSemester()
    {
        return $this->hasMany(HourTrackingPerSemester::class);
    }

}
