<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\JobOpportunity;
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
           ->get();
       return view('applications.index', compact('applications'));
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
    $request->validate([
        'job_opportunity_id' => 'required|exists:job_oportunities,id',
    ]);
    
    try {
        $jobOpportunity = JobOportunity::findOrFail($request->job_opportunity_id);
        $student = Auth::user()->student;
        $application = new Application();
        $application->student_id = $student->id;
        $application->job_opportunity_id = $jobOpportunity->id;
        $application->save();

        return redirect()->route('applications.index')->with('success', 'Aplicación enviada con éxito.');
    } catch (\Exception $e) {
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
