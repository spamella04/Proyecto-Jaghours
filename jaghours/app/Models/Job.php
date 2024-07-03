<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_oportunity_id'
    ];

    //Relacion Oportunidad de Trabajo
    public function job_opportunity()
    {
        return $this->belongsTo(JobOportunity::class, 'job_opportunity_id', 'id');
    }

    public function getJobOpportunity()
    {
        return $this->job_opportunity;
    }

    //Relacion Registros de Horas
    public function hourRecords()
    {
        return $this->hasMany(HourRecord::class);
    }
}
