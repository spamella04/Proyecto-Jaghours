<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use App\Models\JobOportunity;
use App\Events\StudentAcceptedForJob;
use App\Models\Student;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */

      /**
        */

        public function index(Request $request)
        {
            // Obtener el año y mes actuales si no se proporcionan valores
            $year = $request->has('year') ? $request->year : now()->year;
            $month = $request->has('month') ? $request->month : now()->month;
        
            // Iniciar la consulta con las relaciones necesarias
            $query = JobOportunity::with(['area_managers.areas']);
                //->whereHas('job', function($query) {
                    // Filtrar solo los jobs con estudiantes asociados
                   // $query->whereHas('student');
               // });
        
            // Filtrar por el área del manager si el usuario es un "area manager"
            if (auth()->user()->role == 'areamanager') {
                // Verificar que el "area_manager" esté presente en el usuario autenticado
                if(auth()->user()->area_manager) {
                    $areaManagerId = auth()->user()->area_manager->id;
                    $query->where('area_manager_id', $areaManagerId); // Filtrar por el área del manager
                }
            }
        
            // Filtrar por año y mes
            $query->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month);
        
            // Ejecutar la consulta y obtener los resultados
            $jobOpportunities = $query->get();
        
            // Pasar las oportunidades de trabajo a la vista, junto con el año y mes seleccionados
            return view('hourrecord.index', compact('jobOpportunities', 'year', 'month'));
        }
        
        


        public function showStudents(Request $request, $jobOpportunityId)
        {
            // Obtener la oportunidad de trabajo con los trabajos asociados
            $jobOpportunity = JobOportunity::with('job.hourRecords')->find($jobOpportunityId);
        
            // Verificar si la oportunidad existe
            if (!$jobOpportunity) {
                return redirect()->route('jobs.index')->with('error', 'Oportunidad de trabajo no encontrada.');
            }
        
            // Crear la consulta para obtener los trabajos asociados con la oportunidad
            $query = Job::query()->where('job_opportunity_id', $jobOpportunityId);
        
            // Si hay un término de búsqueda, filtrar por los campos del estudiante (a través de User)
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->whereHas('student.user', function ($query) use ($search) {
                    $query->where('cif', 'like', "%{$search}%")
                          ->orWhere('name', 'like', "%{$search}%")
                          ->orWhere('lastname', 'like', "%{$search}%");
                });
            }
        
            // Obtener los trabajos con los estudiantes filtrados
            $jobs = $query->with('student.user')->get();
        
            // Extraer los estudiantes de los trabajos
            $students = $jobs->map(function ($job) {
                return $job->student; // Esto te dará los estudiantes asociados a los trabajos
            });
        
            // Retornar la vista con la oportunidad de trabajo, trabajos y estudiantes
            return view('jobs.students', [
                'jobOpportunity' => $jobOpportunity,
                'jobs' => $jobs,
                'students' => $students,
            ]);
        }
        

    

    

        

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('get')) {
            // Redirigir o mostrar un mensaje de error
            return redirect()->route('joboportunity.index')->withErrors('Acceso no permitido');
        }

        // Validar la solicitud
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        // Obtener la aplicación basada en el ID proporcionado en la solicitud
        $application = Application::findOrFail($request->application_id);
        $application->status = 'Aceptado';
        $application->save();

        
        // Crear un nuevo trabajo
        $job = new Job();
        $job->job_opportunity_id = $application->job_opportunity_id; 
        $job->student_id = $application->student_id;
        $job->save();
    
        // Verificar si se alcanzó el número máximo de vacantes aceptadas
        $joboportunity = JobOportunity::findOrFail($application->job_opportunity_id);
        $acceptedCount = $joboportunity->applications()->where('status', 'Aceptado')->count();
        
        // Lanzar el evento para enviar el correo
        event(new StudentAcceptedForJob($joboportunity, $application->student_id));
         

        if ($acceptedCount >= $joboportunity->number_vacancies) {
            // Actualizar las solicitudes pendientes a rechazadas
            $joboportunity->applications()->where('status', 'Pendiente')->update(['status' => 'No Aceptado']);
        }
    
        // Redirigir
        return redirect()->route('joboportunity.showapplicants', ['id' => $job->job_opportunity_id]);
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
