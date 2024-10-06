<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentAcceptedForJob
{
    use Dispatchable, SerializesModels;

    public $jobOportunity; // Asegúrate de tener esta propiedad
    public $studentId; // Cambia el nombre a studentId para mayor claridad

    /**
     * Crea una nueva instancia del evento.
     *
     * @param  $jobOportunity
     * @param  $studentId
     * @return void
     */
    public function __construct($jobOportunity, $studentId)
    {
        $this->jobOportunity = $jobOportunity; // Asigna el JobOportunity
        $this->studentId = $studentId; // Asigna el ID del estudiante
    }
}