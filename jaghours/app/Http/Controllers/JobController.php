<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
class JobController extends Controller
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

        // Actualizar el estado de la aplicación a "Aceptado"
        $application->status = 'Aceptado';
        $application->save();

        // Crear un nuevo trabajo (job) y asignar el job_opportunity_id de la aplicación
        $job = new Job();
        $job->job_opportunity_id = $application->job_opportunity_id; // Asignar el job_opportunity_id de la aplicación
        $job->student_id = $application->student_id;
        $job->save();

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
