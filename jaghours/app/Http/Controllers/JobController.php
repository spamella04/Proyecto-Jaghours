<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use App\Models\JobOportunity;
use App\Events\StudentAcceptedForJob;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role == 'areamanager')
        {

           $areaManagerId = auth()->user()->area_manager->id;

           $jobs = Job::with(['job_opportunity', 'job_opportunity.area_managers.areas', 'student.user', 'hourRecords'])
           ->whereHas('job_opportunity', function($query) use ($areaManagerId) {
               $query->where('area_manager_id', $areaManagerId);
           })->get();

            return view('hourrecord.index', compact('jobs'));
        }
        if(auth()->user()->role == 'admin')
        {
        $jobs = Job::with(['job_opportunity', 'job_opportunity.area_managers.areas', 'student.user', 'hourRecords'])
                    ->get();
    
        return view('hourrecord.index', compact('jobs'));
        }
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
