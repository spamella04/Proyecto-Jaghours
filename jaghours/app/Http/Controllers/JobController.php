<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use App\Models\JobOportunity;
class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $jobs=Job::with('job_opportunity')->get();
        return view('hourrecord.index', compact('jobs'));
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

        if ($acceptedCount >= $joboportunity->number_vacancies) {
            // Actualizar las solicitudes pendientes a rechazadas
            $joboportunity->applications()->where('status', 'Pendiente')->update(['status' => 'No Aceptado']);
        }


        // Redirigir o cargar la vista de vuelta con los datos necesarios
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
