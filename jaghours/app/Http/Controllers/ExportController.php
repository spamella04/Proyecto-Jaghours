<?php

namespace App\Http\Controllers;

use App\Exports\StudReportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Semester;
use App\Models\Student;


class ExportController extends Controller
{
    //
    public function export(Request $request)
{
    $semester_id = $request->input('semester_id');
    $degree_id = $request->input('degree_id');
    $cif_search = $request->input('cif_search');
    $status_filter = $request->input('status_filter');
    
    // Obtener el semestre y las horas requeridas
    $semester = Semester::find($semester_id);
    $required_hours = $semester ? $semester->hours_required : 0;
    
    // Construir la consulta con los filtros
    $query = Student::query()
        ->where('created_at', '<=', $semester->end_date)
        ->when($cif_search, function($query, $cif) {
            return $query->whereHas('user', function($query) use ($cif) {
                $query->where('cif', '=', $cif);
            });
        })
        ->when($degree_id, function($query, $degree_id) {
            return $query->where('degree_id', $degree_id);
        })
        ->with(['user', 'degree', 'jobs.hourRecords' => function($query) use ($semester_id) {
            $query->where('semester_id', $semester_id);
        }])
        ->get();

    // Filtrar los estudiantes y calcular las horas trabajadas
    $students = $query->map(function ($student) use ($required_hours, $semester_id) {
    $total_hours = $student->jobs->flatMap(function ($job) use ($semester_id) {
            return $job->hourRecords->where('semester_id', $semester_id);
        })->sum('hours_worked');

        $status = $total_hours >= $required_hours ? 'Completadas' : 'Sin Completar';

        return [
            'student' => $student,
            'total_hours' => $total_hours,
            'status' => $status
        ];
    });

    // Aplicar el filtro de estado si está presente
    if ($status_filter) {
        $students = $students->filter(function($student) use ($status_filter) {
            return $student['status'] === $status_filter;
        });
    }

    // Exportar los datos filtrados
    return Excel::download(new StudReportExport($students), 'reporte_estudiantes.xlsx');
}
}
