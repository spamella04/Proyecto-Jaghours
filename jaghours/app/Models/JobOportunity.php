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
        'area_manager_cif'
    ];

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

    public function area_managers()
    {
        return $this->belongsTo(AreaManager::class);
    }

    //PREGUNTAR A DURAN COMO ES AGARRAR USER CON AREA MANAGER
    public function getAreaManagers()
    {
        return $this->area_managers->area_code;
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    
    
}
