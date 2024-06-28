<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AreaManager;

class Area extends Model
{
    use HasFactory;

        protected $fillable = ['code','name', 'description'];


    //Relacion AreaManager
    public function area_managers()
    {
        return $this->hasMany(AreaManager::Class);
    }
}
