<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HourRecord;
use App\Models\Semester;
use App\Models\Job;
use App\Models\Student;
use App\Models\JobOportunity;
use App\Models\AreaManager;
use App\Models\User;
use App\Models\Area;
use App\Models\Degree;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentHourRecordsPDF;


class HourRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($job_id)
    {
        //
        $semesters = Semester::all();
        $job = Job::findOrFail($job_id);
        return view('hourrecord.create', compact('job', 'semesters'));
    }

    public function report(Request $request)
    {
        // Verifica si se ha seleccionado un semestre
        if (!$request->filled('semester_id')) {
            $students = collect(); // Colección vacía si no se selecciona un semestre
            $semesters = Semester::all();
            $degrees = Degree::all();
            $error = "Por favor, seleccione un semestre para ver los resultados.";

            return view('hourrecord.report', compact('students', 'semesters', 'degrees', 'error'));
        }

        $semester_id = $request->input('semester_id');
        $semester = Semester::find($semester_id);

        // Si el semestre no existe, establece un mensaje de error y regresa la vista
        if (!$semester) {
            $error = "El semestre seleccionado no existe.";
            $students = collect();
            $semesters = Semester::all();
            $degrees = Degree::all();

            return view('hourrecord.report', compact('students', 'semesters', 'degrees', 'error'));
        }

        $required_hours = $semester->hours_required;
        $semester_end_date = $semester->end_date;
        // Realiza la consulta solo si se ha seleccionado un semestre
        $query = Student::query()
            ->where('created_at', '<=', $semester_end_date) // Filtrar estudiantes con ingreso menor del final del semestre
            ->when($request->input('cif_search'), function ($query, $cif) {
                return $query->whereHas('user', function ($query) use ($cif) {
                    $query->where('cif', '=', $cif);
                });
            })
            ->when($request->input('degree_id'), function ($query, $degree_id) {
                return $query->where('degree_id', $degree_id);
            })
            ->with(['user', 'degree', 'jobs.hourRecords' => function ($query) use ($semester_id) {
                $query->where('semester_id', $semester_id);
            }])
            ->get();

        // Filtrar los estudiantes y calcular las horas trabajadas
        $students = $query->map(function ($student) use ($required_hours, $semester_id) {
            // Sumar horas trabajadas a través de jobs y hourRecords
            $total_hours = $student->jobs->flatMap(function ($job) use ($semester_id) {
                return $job->hourRecords->where('semester_id', $semester_id);
            })->sum('hours_worked');

            // Definir el estado basado en las horas trabajadas y las horas requeridas
            $status = $total_hours >= $required_hours ? 'Completadas' : 'Sin Completar';

            return [
                'student' => $student,
                'total_hours' => $total_hours,
                'status' => $status
            ];
        });

        // Aplicar el filtro de estado si está presente
        if ($request->filled('status_filter')) {
            $students = $students->filter(function ($student) use ($request) {
                return $student['status'] === $request->input('status_filter');
            });
        }

        $semesters = Semester::all();
        $degrees = Degree::all();

        // Si no se encontraron resultados, establecer un mensaje de error
        $error = $students->isEmpty() ? "No se encontraron resultados para los criterios de búsqueda proporcionados." : null;

        return view('hourrecord.report', compact('students', 'semesters', 'degrees', 'error'));
    }




    public function showStudentHourRecords(Student $student, Request $request)
    {
        // Obtener el semestre seleccionado de la solicitud
        $semester_id = $request->input('semester_id');

        $semester = Semester::find($semester_id);

        // Obtener todos los hour records del estudiante para el semestre seleccionado, cargando las relaciones necesarias
        $hourRecordsQuery = $student->jobs()
            ->with(['hourRecords' => function ($query) use ($semester_id) {
                if ($semester_id) {
                    $query->where('semester_id', $semester_id);
                }
            }, 'hourRecords.job.job_opportunity.area_managers.areas'])
            ->get()
            ->pluck('hourRecords')
            ->flatten();

        // Pasar los datos a la vista
        return view('hourrecord.student', [
            'student' => $student,
            'hourRecords' => $hourRecordsQuery,
            'semester' => $semester,
        ]);
    }

    public function sendPDF($studentId, $semester_id)
{
    $student = Student::with(['user','degree'])->findOrFail($studentId);

    
    // Verificar si el semestre es válido
    if (!$semester_id) {
        return back()->with('error', 'Semestre no especificado.');
    }
    $semester = Semester::findOrFail($semester_id);
    // Obtener los registros de horas solo para ese semestre
    $hourRecords = HourRecord::with('job.job_opportunity.area_managers.areas')
                             ->whereHas('job', function ($query) use ($student) {
                                 $query->where('student_id', $student->id);
                             })
                             ->where('semester_id', $semester_id) // Filtrar por semestre
                             ->get();
    
    
    // Enviar el correo con los registros de horas del semestre específico
    Mail::to('admin@uam.edu.ni') // Poner correo apropiado
    ->send(new StudentHourRecordsPDF($student, $hourRecords, $semester));

    return back()->with('success', 'Reporte enviado correctamente.');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'hours_worked' => 'required|numeric',
            'description' => 'required',
            'work_date' => [
                'required',
                'date',
                // Regla personalizada para validar la fecha dentro del rango del semestre
                function ($attribute, $value, $fail) use ($request) {
                    // Obtener el semestre seleccionado
                    $semester = Semester::findOrFail($request->semester_id);

                    // Validar que la fecha de trabajo esté dentro del rango del semestre
                    if ($value < $semester->start_date || $value > $semester->end_date) {
                        $fail('La fecha de trabajo debe estar dentro del rango del semestre seleccionado.');
                    }
                },
            ],
        ]);

        $hourRecord = new HourRecord();
        $hourRecord->work_date = $request->work_date;
        $hourRecord->job_id = $request->job_id;
        $hourRecord->hours_worked = $request->hours_worked;
        $hourRecord->semester_id = $request->semester_id;

        $job = Job::findOrFail($request->job_id);
        $jobOpportunity = $job->job_opportunity;

        if (Auth::user()->role == 'areamanager') {
            $hourRecord->area_manager_id = auth()->user()->area_manager->id;
        }
        if (Auth::user()->role == 'admin') {
            $hourRecord->area_manager_id = $jobOpportunity->area_managers->id;
        }

        $hourRecord->save();
        return redirect()->route('job.index')->with('success', 'Horas registradas correctamente');
    }


    public function storeMatch(Request $request)
    {
        // Validación
        $request->validate([
            'job_opportunity_id' => 'required|exists:job_oportunities,id',
            'applications' => 'required|array',
        ]);

        // Buscar la oportunidad de trabajo
        $jobOpportunity = JobOportunity::findOrFail($request->job_opportunity_id);

        // Encontrar semestre activo
        $semester = Semester::where('status', 'active')->first();

        foreach ($request->applications as $applicationJson) {
            $application = json_decode($applicationJson);

            // Crear el trabajo asociado a la oportunidad
            $job = new Job();
            $job->job_opportunity_id = $jobOpportunity->id;
            $job->student_id = $application->student->id;
            $job->save();

            $hourRecord = new HourRecord();
            $hourRecord->work_date = $jobOpportunity->start_date;
            $hourRecord->job_id = $job->id;
            $hourRecord->hours_worked = $jobOpportunity->hours_validated;
            $hourRecord->semester_id = $semester->id;

            if (Auth::user()->role == 'areamanager') {
                $hourRecord->area_manager_id = auth()->user()->area_manager->id;
            }
            if (Auth::user()->role == 'admin') {
                $hourRecord->area_manager_id = $jobOpportunity->area_managers->id;
            }

            $hourRecord->save();

            // Logging para verificar los datos
            Log::info('Datos del job:', ['job' => $job]);
            Log::info('Datos del hourRecord:', ['hourRecord' => $hourRecord]);
        }

        return redirect()->route('joboportunity.showapplicants', $jobOpportunity->id)->with('success', 'Horas registradas correctamente');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
