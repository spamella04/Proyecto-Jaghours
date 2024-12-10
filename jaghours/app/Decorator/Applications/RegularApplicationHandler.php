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

        // Filtrar aplicaciones con estado "Pendiente"
        foreach ($this->applications as $application) {
            // Si el estado de la aplicación es diferente de 'Pendiente', omitimos esta iteración
            if ($application->status != 'Pendiente' && $application->status != 'No Aceptado') {
                continue;
            }

            $output .= '<tr>';
            
            // Convertir el Cif en un enlace al perfil del estudiante
            $studentProfileUrl = route('student.seeprofile', ['studentId' => $application->student->student_id]);
            $output .= "<td><a href='{$studentProfileUrl}' style='color: #219EBC; text-decoration: none;'>{$application->student->user->cif}</a></td>"; // Cif del estudiante como enlace
            $output .= "<td>{$application->student->user->name}</td>"; // Nombre del estudiante
            $output .= "<td>{$application->status}</td>"; // Estado de la aplicación

            // Solo mostrar el botón de aceptar si el estado es 'Pendiente'
            if ($application->status == 'Pendiente') {
                $output .= '<td>'; // Columna de acciones
                $output .= "<form method='POST' action='" . route('job.store') . "'>";
                $output .= csrf_field(); // Incluir el token CSRF
                $output .= "<input type='hidden' name='application_id' value='{$application->id}'>"; // Incluir el ID de la aplicación
                $output .= "<button type='submit' class='btn btn-success' style='background-color: #219EBC; color: white;'>Aceptar</button>";
                $output .= "</form>";
                $output .= '</td>'; // Cerrar la columna de acciones
                $output .= '</tr>';
            } else {
                $output .= '<td>'; // Columna de acciones
                $output .= "<button class='btn btn-secondary' disabled>Aceptar</button>"; // Botón deshabilitado
                $output .= '</td>'; // Cerrar la columna de acciones    
            }

        }

        $output .= '</tbody>';
        $output .= '</table>'; // Cerrar la tabla

        return $output;
    }
}
