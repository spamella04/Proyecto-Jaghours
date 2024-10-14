<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\JobOportunity;


class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if(Auth::user()->role == 'student'){
            $student = Auth::user()->student;
        }
        if($student){
           // Obtiene las aplicaciones del estudiante con estado "pendiente" o "rechazado"
           $applications = Application::where('student_id', $student->id)
            ->whereIn('status', ['Pendiente', 'No Aceptado'])
            ->with(['job_opportunities.area_managers.users'])
            ->get();

            $activeapplicationcount = $applications->filter(function($application) {
                return $application->job_opportunities->area_managers->users->status == 'active';
            })->count();
    return view('applications.index', compact('applications','activeapplicationcount'));
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
        // Validar el request
        $request->validate([
            'job_opportunity_id' => 'required|exists:job_oportunities,id',
        ]);

        try {
            // Verificar si el usuario está autenticado
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Debe iniciar sesión primero.');
            }

            // Obtener el estudiante autenticado
            $student = Auth::user()->student;

            // Verificar si el usuario autenticado es un estudiante
            if (!$student) {
                return redirect()->back()->with('error', 'El usuario no es un estudiante.');
            }

            // Encontrar la oportunidad de trabajo
            $jobOpportunity = JobOportunity::findOrFail($request->job_opportunity_id);

            // Crear una nueva aplicación
            $application = new Application();
            $application->student_id = $student->id;
            $application->job_opportunity_id = $jobOpportunity->id;
            
            if ($jobOpportunity->match) {
                $application->status = 'Aceptado';
            } else {
                $application->status = 'Pendiente';
            }
            
            $application->save();

            // Redirigir a la vista de aplicaciones con éxito
            return redirect()->route('applications.index')->with('success', 'Aplicación enviada con éxito.');
        } catch (\Exception $e) {
            // Registrar el error para depuración
            \Log::error('Error al guardar la aplicación: ' . $e->getMessage());

            // Redirigir de vuelta en caso de error
            return redirect()->back()->with('error', 'Hubo un error al enviar la aplicación.');
        }
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
