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
    public function index(Request $request)
    {
        // Asegúrate de que el usuario sea un estudiante
        if(Auth::user()->role == 'student') {
            $student = Auth::user()->student;
    
            if($student) {
                // Obtener el filtro de estado del request, con un valor por defecto vacío (puede ser un array vacío)
                $status_filter = $request->input('status_filter', []);
    
                // Si se seleccionó "Todos", no aplicamos ningún filtro de estado
                if (in_array('Todos', $status_filter)) {
                    $applications = Application::where('student_id', $student->id)
                        ->with(['job_opportunities.area_managers.users'])
                        ->paginate(9);
                } else {
                    // Filtrar las aplicaciones por el estudiante y estado, si se seleccionó uno
                    $applications = Application::where('student_id', $student->id)
                        ->whereIn('status', ['Pendiente', 'No Aceptado', 'Aceptado']) // Filtrar solo estos estados
                        ->when(count($status_filter) > 0, function ($query) use ($status_filter) {
                            return $query->whereIn('status', $status_filter); // Filtrar por los estados seleccionados
                        })
                        ->with(['job_opportunities.area_managers.users'])
                        ->paginate(9);
                }
    
                // Contar solo las aplicaciones con estado activo en el área del gerente
                $activeapplicationcount = $applications->filter(function($application) {
                    return $application->job_opportunities->area_managers->users->status == 'active';
                })->count();
    
                // Retornar la vista con las variables necesarias
                return view('applications.index', compact('applications', 'activeapplicationcount', 'status_filter'));
            }
        }
    
        return redirect()->route('home'); // Redirige si no es un estudiante o no tiene aplicaciones
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
