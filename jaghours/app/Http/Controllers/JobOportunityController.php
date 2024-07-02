<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOportunity;
use Illuminate\Support\Facades\Auth;


class JobOportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $areaManager = Auth::user()->area_manager;

    if ($areaManager) {
        // Obtener las oportunidades de trabajo asociadas a este AreaManager
        $jobOportunities = JobOportunity::where('area_manager_id', $areaManager->id)->get();
    }
    return view('joboportunity.index', compact('jobOportunities'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('joboportunity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
        $area_manager= Auth::user()->area_manager;

        $jobOportunity = new JobOportunity();
        $jobOportunity->title = $request->title;
        $jobOportunity->description = $request->description;
        $jobOportunity->start_date= $request->start_date;
        $jobOportunity->hours_validated = $request->hours_validated;
        $jobOportunity->number_applicants = $request->number_applicants;
        $jobOportunity->number_vacancies = $request->number_vacancies;
        $jobOportunity->requirements = $request->requirements;
        $jobOportunity->area_manager_id = $area_manager->id;
        $jobOportunity->save();
        return redirect()->route('joboportunity.index');
    

        
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
