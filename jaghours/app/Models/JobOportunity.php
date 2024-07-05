<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\JobOportunityStatus;

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

    //Estado de la oportunidad de trabajo

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
        return $this->hasMany(Application::class);
    }

    //Relacion Registro de Horas

    public function hourRecords()
    {
        return $this->hasMany(HourRecord::class);
    }

    //Relacion Trabajos
    public function job()
    {
        return $this->hasOne(Job::class);
    }

    
    
}
