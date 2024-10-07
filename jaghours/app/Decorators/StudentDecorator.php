<?php
namespace App\Decorators;

use App\Models\Student;

class StudentDecorator
{
    protected $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function getFullName()
    {
        return $this->student->user->name . ' ' . $this->student->user->lastname;;
    }

    public function getFormattedSkills()
    {
       // Limpiar la cadena de habilidades
    $skills = trim($this->student->skills); // Quitar espacios en blanco

    // Si hay habilidades separadas por comas, retornamos tal cual
    if (strpos($skills, ',') !== false) {
        return $skills;
    }

    // Si no hay comas, usamos una expresión regular para dividir las habilidades 
    // Suponiendo que las habilidades están en formato CamelCase
    $skillsArray = preg_split('/(?=[A-Z])/', $skills);

    // Limpiar posibles entradas vacías
    $skillsArray = array_filter($skillsArray); // Elimina valores vacíos

    // Comprobar cuántas habilidades hay
    $count = count($skillsArray);
    if ($count === 0) {
        return ''; // Devuelve una cadena vacía si no hay habilidades
    }

    // Formatear la salida
    if ($count === 1) {
        return $skillsArray[0]; // Solo una habilidad
    } elseif ($count === 2) {
        return implode(' y ', $skillsArray); // Dos habilidades
    } else {
        $lastSkill = array_pop($skillsArray); // Sacamos la última habilidad
        return implode(', ', $skillsArray) . ' y ' . $lastSkill; // Reensamblamos con "y"
    }
}
}
