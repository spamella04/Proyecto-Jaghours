<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Area;

class AreaManager extends Model
{
    use HasFactory;

    protected $fillable = ['area_manager_id','area_id'];


    //Relacion User
    public function users()
    {
        return $this->belongsTo(User::class, 'area_manager_id', 'id');
    }

    public function getUsers()
    {
        return $this->users->name->lastname->email->phone;
    }

    //Relacion Area
    public function areas()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');

    }
    public function getAreas()
    {
        return $this->areas->name->description;
    }

    //Relacion Oportunidades de Trabajo
    public function jobOportunities()
    {
        return $this->hasMany(JobOportunity::class);
    }

    //Relacion Registros de Horas
    public function HoursRecords()
    {
        return $this->hasMany(HourRecord::class);
    }

}
