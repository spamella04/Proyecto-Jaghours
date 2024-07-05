<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOportunity;
use App\Enums\JobOportunityStatus;
use Illuminate\Support\Facades\Auth;
use App\Models\AreaManager;
use App\Models\Area;



class JobOportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
       
        if(Auth::user()->role == 'areamanager'){
            $areaManager = Auth::user()->area_manager;
            $area = $areaManager->area;

            if ($areaManager) {
                // Obtener las oportunidades de trabajo asociadas a este AreaManager
                $jobOportunities = JobOportunity::where('area_manager_id', $areaManager->id)->get();
                return view('joboportunity.index', compact('jobOportunities'));
            }
        }
       

        if(Auth::user()->role == 'student'){
        $student = Auth::user()->student;

        if($student){
            $jobOportunities = JobOportunity::where('status', 'Publicado')->get();
            return view('joboportunity.indexStudent', compact('jobOportunities'));
        }

        }

    
   
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
        try{
            $jobOportunity = JobOportunity::findOrFail($id);
            $jobOportunity->title = $request->title;
            $jobOportunity->description = $request->description;
            $jobOportunity->start_date = $request->start_date;
            $jobOportunity->hours_validated = $request->hours_validated;
            $jobOportunity->number_applicants = $request->number_applicants;
            $jobOportunity->number_vacancies = $request->number_vacancies;
            $jobOportunity->requirements = $request->requirements;
            $jobOportunity->save();
            return redirect()->route('joboportunity.index');
        }
        catch(\Exception $e){
            return redirect()->route('joboportunity.edit');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
