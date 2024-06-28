<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Area;

class AreaManager extends Model
{
    use HasFactory;

    protected $fillable = ['area_manager_cif','area_code'];

    //  Es user o areaManager?
    //Relacion User
    public function users()
    {
        return $this->belongsTo(User::class, 'area_manager_cif', 'cif');
    }

    public function getUsers()
    {
        return $this->users->name->lastname->email->phone;
    }

    //Relacion Area
    public function areas()
    {
        return $this->belongsTo(Area::class, 'area_code', 'code');

    }
    public function getAreas()
    {
        return $this->areas->name->description;
    }

    //Relacion Oportunidades de Trabajo
    public function jobOpportunities()
    {
        return $this->hasMany(JobOpportunity::class);
    }

    //Relacion Registros de Horas
    public function HoursRecords()
    {
        return $this->hasMany(HourRecord::Class, 'area_manager_cif', 'cif');
    }

}
