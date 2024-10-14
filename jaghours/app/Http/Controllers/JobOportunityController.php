<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOportunity;
use App\Enums\JobOportunityStatus;
use Illuminate\Support\Facades\Auth;
use App\Models\AreaManager;
use App\Models\Area;
use App\Models\Student;
use App\Models\Application;
use App\Models\Job;
use App\Decorator\Applications\MatchApplicationHandler;
use App\Decorator\Applications\RegularApplicationHandler;

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
                $jobOportunities = JobOportunity::where('area_manager_id', $areaManager->id)->paginate(3);
                return view('joboportunity.index', compact('jobOportunities'));
            }
        }

        if (Auth::user()->role == 'admin') {
            $admin = Auth::user()->role=='admin';

            if ($admin) {
                $jobOportunities = JobOportunity::with('applications.student')->where('status', 'Publicado')->paginate(3);
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
                $jobOportunities = JobOportunity::where('area_manager_id', $areaManager->id)->paginate(3);
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
            'match' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validación de la imagen
            
            
        ], [
            'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o una fecha futura.',
            'hours_validated.min' => 'Las horas convalidadas deben ser al menos 1.',
            'number_applicants.min' => 'El número de aplicantes debe ser al menos 1.',
            'number_vacancies.min' => 'El número de vacantes debe ser al menos 1.',
        ]);
        //Validar si se ha subido una imagen
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('job_opportunities', 'public'); // Almacena la imagen
            $validated['image_path'] = $imagePath;
        }

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
        $jobOportunity->match = $request->has('match');
        $jobOportunity->image_path = $imagePath;
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
        $applications = Application::where('job_opportunity_id', $joboportunity->id)->get();
    
        // Usar el decorador correspondiente basado en el valor de match
        if ($joboportunity->match) {

            $joboportunityId = JobOportunity::findOrFail($id);
            $handler = new MatchApplicationHandler($applications, $joboportunityId);
        } else {
            $handler = new RegularApplicationHandler($applications);
        }
    
        $applicationsTable = $handler->render(); // Renderizar la tabla de aplicaciones
    
        return view('joboportunity.showapplicants', compact('applicationsTable', 'joboportunity'));
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
