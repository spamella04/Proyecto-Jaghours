<?php

namespace App\Decorator\Applications;

use App\Decorator\Applications\ApplicationHandler;
use App\Models\Job;
use App\Models\JobOpportunity;

class MatchApplicationHandler extends ApplicationHandler
{
    protected $jobOpportunity;

    // Constructor para inicializar la propiedad jobOpportunity
    public function __construct($applications, $jobOpportunity)
    {
        parent::__construct($applications);
        $this->jobOpportunity = $jobOpportunity;
    }

    public function render()
    {
        $output = "<form method='POST' action='" . route('hourrecords.storeMatch') . "'>";
        $output .= csrf_field(); // Token CSRF para seguridad
        $output .= "<input type='hidden' name='job_opportunity_id' value='{$this->jobOpportunity->id}'>"; // Incluimos el ID de la oportunidad de trabajo

        $output .= '<table class="table">';
        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th>CIF</th>';
        $output .= '<th>Nombre</th>';
        $output .= '<th>Carrera</th>';
        $output .= '<th>Seleccionar</th>';
        $output .= '</tr>';
        $output .= '</thead>';
        $output .= '<tbody>';

        foreach ($this->applications as $application) {
            $output .= '<tr>';
            $output .= "<td>{$application->student->user->cif}</td>";
            $output .= "<td>{$application->student->user->name} {$application->student->user->lastname}</td>";
            $output .= "<td>{$application->student->degree->name}</td>";

            $output .= '<td>';
            $output .= "<input type='checkbox' name='applications[]' value='" . htmlspecialchars(json_encode($application)) . "'>"; // Codificar la aplicación como JSON
            $output .= '</td>';
            $output .= '</tr>';
        }

        $output .= '</tbody></table>';
        $output .= '<button type="submit" class="btn btn-primary">Convalidar Horas</button>';
        $output .= '</form>';

        return $output;
    }
}


