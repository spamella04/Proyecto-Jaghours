<?php

namespace App\Decorator\Applications;

use App\Models\Application;

class RegularApplicationHandler extends ApplicationHandler
{
    public function render()
    {
        // Comenzamos la tabla
        $output = '<table class="table table-bordered">';
        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th>Cif</th>';
        $output .= '<th>Nombre</th>';
        $output .= '<th>Estado</th>';
        $output .= '<th>Acciones</th>';
        $output .= '</tr>';
        $output .= '</thead>';
        $output .= '<tbody>';

        foreach ($this->applications as $application) {
            $output .= '<tr>';
            $output .= "<td>{$application->student->user->cif}</td>"; // Cif del estudiante
            $output .= "<td>{$application->student->user->name}</td>"; // Nombre del estudiante
            $output .= "<td>{$application->status}</td>"; // Estado de la aplicación

            // Solo mostrar el botón de aceptar si el estado es 'Pendiente'
            $output .= '<td>'; // Columna de acciones
            if ($application->status == 'Pendiente') {
                $output .= "<form method='POST' action='" . route('job.store') . "'>";
                $output .= csrf_field(); // Incluir el token CSRF
                $output .= "<input type='hidden' name='application_id' value='{$application->id}'>"; // Incluir el ID de la aplicación
                $output .= "<button type='submit' class='btn btn-success'>Aceptar</button>";
                $output .= "</form>";
            }
            $output .= '</td>'; // Cerrar la columna de acciones
            $output .= '</tr>';
        }

        $output .= '</tbody>';
        $output .= '</table>'; // Cerrar la tabla

        return $output;
    }
}
