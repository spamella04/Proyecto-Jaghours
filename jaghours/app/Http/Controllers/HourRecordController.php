<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HourRecord;
use App\Models\Semester;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
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

        if(Auth::user()->role == 'areamanager'){
            $hourRecord->area_manager_id = auth()->user()->area_manager->id; 
        }
        if(Auth::user()->role == 'admin'){
            $hourRecord->area_manager_id = $jobOpportunity->area_managers->id;        }

        $hourRecord->save();
        return redirect()->route('job.index')->with('success', 'Horas registradas correctamente');

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
