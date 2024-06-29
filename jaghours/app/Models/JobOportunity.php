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

    //Estado de la oportunidad de trabajo

    protected $casts = [
        'status' => JobOpportunityStatus::class,
    ];

    public function getStatusAttribute($value)
    {
        return JobOpportunityStatus::fromValue($value);
    }

    public function setStatusAttribute(JobOpportunityStatus $status)
    {
        $this->attributes['status'] = $status->value;
    }

    //Relacion Area Manager
    public function area_managers()
    {
        return $this->belongsTo(AreaManager::class);
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

    
    
}
