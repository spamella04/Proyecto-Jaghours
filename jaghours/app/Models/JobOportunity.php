<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'start_date',
        'hours_validated',
        'number_applicants',
        'number_vacancies',
        'requirements',
        'area_manager_id'
    ];

    protected $casts = [
        'status' => 'string', // Estado tratado como un simple atributo
    ];

    // Relación con Area Manager
    public function area_managers()
    {
        return $this->belongsTo(AreaManager::class, 'area_manager_id', 'id');
    }

    // Relación con Postulaciones
    public function applications()
    {
        return $this->hasMany(Application::class, 'job_opportunity_id', 'id');
    }

    // Relación con Registro de Horas
    public function hourRecords()
    {
        return $this->hasMany(HourRecord::class);
    }

    // Relación con Trabajos
    public function job()
    {
        return $this->hasMany(Job::class);
    }
}
