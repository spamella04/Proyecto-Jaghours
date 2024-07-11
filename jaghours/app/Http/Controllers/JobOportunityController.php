<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOportunity;
use App\Enums\JobOportunityStatus;
use Illuminate\Support\Facades\Auth;
use App\Models\AreaManager;
use App\Models\Area;
use Illuminate\Support\Facades\DB;



class JobOportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'areamanager') {
            $areaManager = Auth::user()->area_manager;

            if ($areaManager) {
                $jobOportunities = JobOportunity::where('area_manager_id', $areaManager->id)->get();
                return view('joboportunity.index', compact('jobOportunities'));
            }
        }

        if (Auth::user()->role == 'admin') {
            $admin = Auth::user()->role=='admin';

            if ($admin) {
                $jobOportunities = JobOportunity::with('applications.student')->where('status', 'Publicado')->get();
                return view('joboportunity.index', compact('jobOportunities'));
            }
        }

        return redirect()->route('home'); // Redirigir a una página de inicio o de error si el usuario no es un area manager
    }

    public function indexAreaManager()
    {
        if (Auth::user()->role == 'areamanager') {
            $areaManager = Auth::user()->area_manager;

            if ($areaManager) {
                $jobOportunities = JobOportunity::where('area_manager_id', $areaManager->id)->get();
                return view('joboportunity.indexAreaManager', compact('jobOportunities'));
            }
        }


        return redirect()->route('home'); // Redirigir a una página de inicio o de error si el usuario no es un area manager
    }

    public function indexStudent()
    {
      
        if (Auth::user()->role == 'student') {
            $student = Auth::user()->student;
            if ($student) {
                // Obtener los IDs de las oportunidades a las cuales el estudiante ha aplicado
                $appliedOpportunityIds = $student->applications()->pluck('job_opportunity_id')->toArray();
                // Obtener las oportunidades publicadas que el estudiante no ha aplicado aún
                $jobOportunities = JobOportunity::where('status', 'Publicado')
                    ->whereNotIn('id', $appliedOpportunityIds)
                    ->where(function ($query) {
                        // Subconsulta para contar el número de aplicaciones por oportunidad
                        $query->whereNotExists(function ($subquery) {
                            $subquery->select(DB::raw(1))
                                    ->from('applications')
                                    ->whereColumn('applications.job_opportunity_id', 'job_oportunities.id')
                                    ->groupBy('applications.job_opportunity_id')
                                    ->havingRaw('count(*) >= job_oportunities.number_applicants');
                        });
                    })
                    ->get();

    
                return view('joboportunity.indexStudent', compact('jobOportunities'));
            }
        }
    
        return redirect()->route('home'); // Redirigir si el usuario no es un estudiante o no tiene aplicaciones
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
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'hours_validated' => 'required|integer|min:1',
            'number_applicants' => 'required|integer|min:1',
            'number_vacancies' => 'required|integer|min:1',
            'requirements' => 'required|string',
        ], [
            'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o una fecha futura.',
            'hours_validated.min' => 'Las horas convalidadas deben ser al menos 1.',
            'number_applicants.min' => 'El número de aplicantes debe ser al menos 1.',
            'number_vacancies.min' => 'El número de vacantes debe ser al menos 1.',
        ]);

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

    public function showApplicants($id)
    {
        $joboportunity = JobOportunity::with('applications.student.user')->findOrFail($id);

        return view('joboportunity.showapplicants', compact('joboportunity'));
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'hours_validated' => 'required|integer|min:1',
            'number_applicants' => 'required|integer|min:1',
            'number_vacancies' => 'required|integer|min:1',
            'requirements' => 'required|string',
        ], [
            'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o una fecha futura.',
            'hours_validated.min' => 'Las horas convalidadas deben ser al menos 1.',
            'number_applicants.min' => 'El número de aplicantes debe ser al menos 1.',
            'number_vacancies.min' => 'El número de vacantes debe ser al menos 1.',
        ]);
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
