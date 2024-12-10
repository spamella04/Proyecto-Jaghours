<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\JobOportunityStatus;
use App\Models\AreaManager;
use App\Models\Application;
use App\Models\HourRecord;
use App\Models\Job;


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
        'match',
        'image_path',
        'area_manager_id'
    ];

    protected $casts = [
        'status' => JobOportunityStatus::class,
    ];

    public function getStatusAttribute($value)
    {
        return JobOportunityStatus::fromValue($value);
    }

    public function setStatusAttribute( $JobOportunityStatus)
    {
        $this->attributes['status'] = JobOportunityStatus::fromValue($JobOportunityStatus);
    }

    //Relacion Area Manager
    public function area_managers()
    {
        return $this->belongsTo(AreaManager::class, 'area_manager_id', 'id');
    }


    
    public function getAreaManagers()
    {
        return $this->area_managers->user->getUser();
    }

    //Relacion Postulaciones

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
        return $this->hasMany(Job::class, 'job_opportunity_id', 'id');
    }

    public function checkAndClose()
{
    // Obtener todos los trabajos relacionados con esta oportunidad
    $jobs = $this->job;

    // Verificar si todos los trabajos tienen registros de horas que sumen las horas validadas
    $totalHoursRecorded = 0;

    foreach ($jobs as $job) {
        // Sumar las horas registradas en los HourRecords de cada Job
        $jobHours = $job->hourRecords()->sum('hours_worked');
        $totalHoursRecorded += $jobHours;

        // Si algún trabajo no tiene registros o las horas no suman, retornar false
        if ($jobHours <= 0) {
            return false;
        }
    }

    // Verificar si las horas totales registradas alcanzan o superan las horas validadas de la oportunidad
    if ($totalHoursRecorded >= $this->hours_validated) {
        // Cambiar estado a "cerrado"
        $this->status = \App\Enums\JobOportunityStatus::Closed;
        $this->save();
        return true;
    }

    return false;
}

}
